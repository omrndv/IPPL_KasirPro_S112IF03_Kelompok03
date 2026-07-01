<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Setting;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $categories = Category::where('outlet_id', $outletId)->latest()->get();

        $query = Product::where('outlet_id', $outletId)
            ->where('stock', '>', 0)
            ->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();
        $settings = Setting::getAllAsArray();
        
        // Ambil voucher aktif untuk ditawarkan di kasir
        $vouchers = \App\Models\Voucher::where('outlet_id', $outletId)
            ->where('is_active', true)
            ->orderBy('min_purchase')
            ->get();

        return view('transaksi', compact('products', 'categories', 'settings', 'vouchers'));
    }

    /**
     * Handle checkout — 2 flow:
     *   1. cash       → simpan langsung, status paid, return struk
     *   2. midtrans   → simpan pending, generate snap token, return token ke frontend
     */
    public function checkout(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'cart'           => 'required|array',
            'cart.*.id'      => 'required|integer',
            'cart.*.qty'     => 'required|integer|min:1',
            'pay_amount'     => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,midtrans',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $details  = [];

            foreach ($request->cart as $item) {
                $product = Product::where('outlet_id', $outletId)
                    ->lockForUpdate()
                    ->find($item['id']);

                if (!$product) throw new \Exception('Produk tidak ditemukan di outlet kamu.');

                if ($product->is_stock_tracked && $product->stock < $item['qty']) {
                    throw new \Exception("Stok untuk {$product->name} tidak mencukupi! Sisa: {$product->stock}");
                }

                $itemSubtotal = $product->selling_price * $item['qty'];
                $subtotal += $itemSubtotal;

                $details[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'qty'          => $item['qty'],
                    'price'        => $product->selling_price,
                    'subtotal'     => $itemSubtotal,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            $request->validate([
                'voucher_code' => 'nullable|string',
                'discount'     => 'nullable|numeric|min:0',
            ]);

            // Hitung diskon secara aman di backend
            $discount = 0;
            if ($request->filled('voucher_code')) {
                $voucher = \App\Models\Voucher::where('outlet_id', $outletId)
                    ->where('code', $request->voucher_code)
                    ->where('is_active', true)
                    ->first();

                if ($voucher && $subtotal >= $voucher->min_purchase) {
                    if ($voucher->type === 'fixed') {
                        $discount = min($voucher->value, $subtotal);
                    } else {
                        $discount = round($subtotal * ($voucher->value / 100));
                    }
                }
            }

            $taxEnabled = Setting::getValue('tax_enabled', '1') == '1';
            $taxRate    = (float) Setting::getValue('tax_rate', 10);
            
            // Tax dihitung setelah subtotal dikurangi diskon
            $totalAfterDiscount = max($subtotal - $discount, 0);
            $tax        = $taxEnabled ? $totalAfterDiscount * ($taxRate / 100) : 0;
            $grandTotal = $totalAfterDiscount + $tax;

            $isCash = $request->payment_method === 'cash';

            // Untuk cash: validasi uang pembayaran
            if ($isCash && $request->pay_amount < $grandTotal) {
                throw new \Exception('Uang pembayaran kurang!');
            }

            // Generate invoice number unik
            $invoiceNo = $this->generateInvoiceNo();

            // Untuk Midtrans: stok dikurangi di sini (saat checkout),
            // dan dikembalikan jika webhook melaporkan gagal/cancel.
            foreach ($request->cart as $item) {
                $product = Product::where('outlet_id', $outletId)->find($item['id']);
                if ($product && $product->is_stock_tracked) {
                    $product->stock -= $item['qty'];
                    $product->save();
                }
            }

            // Midtrans order_id = invoice_no (unik)
            $midtransOrderId = $isCash ? null : $invoiceNo;

            $transaction = Transaction::create([
                'outlet_id'           => $outletId,
                'invoice_no'          => $invoiceNo,
                'midtrans_order_id'   => $midtransOrderId,
                'subtotal'            => $subtotal,
                'discount'            => $discount,
                'tax'                 => $tax,
                'grand_total'         => $grandTotal,
                'payment_method'      => $request->payment_method,
                'pay_amount'          => $isCash ? $request->pay_amount : $grandTotal,
                'return_amount'       => $isCash ? ($request->pay_amount - $grandTotal) : 0,
                'payment_status'      => $isCash ? 'paid' : 'pending',
            ]);

            foreach ($details as &$detail) {
                $detail['transaction_id'] = $transaction->id;
            }
            TransactionDetail::insert($details);
            $transaction->load('details');

            $settings = Setting::getAllAsArray();
            $receiptData = [
                'success'        => true,
                'transaction_id' => $transaction->id,
                'invoice_no'     => $transaction->invoice_no,
                'subtotal'       => $transaction->subtotal,
                'discount'       => $transaction->discount,
                'tax'            => $transaction->tax,
                'grand_total'    => $transaction->grand_total,
                'payment_method' => $transaction->payment_method,
                'pay_amount'     => $transaction->pay_amount,
                'return_amount'  => $transaction->return_amount,
                'created_at'     => $transaction->created_at->format('d M Y, H:i'),
                'items'          => $transaction->details,
                'settings'       => [
                    'store_name'     => auth()->user()->outlet->name ?? 'KasirPro',
                    'store_phone'    => auth()->user()->outlet->phone ?? '-',
                    'store_address'  => auth()->user()->outlet->address ?? 'Alamat toko belum diatur',
                    'tax_rate'       => $settings['tax_rate'] ?? $taxRate,
                    'receipt_footer' => $settings['receipt_footer'] ?? 'Terima kasih atas kunjungannya!',
                ],
            ];

            DB::commit();

            // ── CASH: langsung return struk ───────────────────────────────────
            if ($isCash) {
                return response()->json(array_merge($receiptData, ['message' => 'Transaksi berhasil!']));
            }

            // ── MIDTRANS: generate Snap token ─────────────────────────────────
            $snapResult = $this->midtransService->createSnapToken($transaction);

            if (!$snapResult['success']) {
                // Rollback: kembalikan stok dan hapus transaksi
                $this->rollbackMidtransTransaction($transaction, $request->cart, $outletId);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghubungi Midtrans: ' . ($snapResult['message'] ?? 'Unknown error'),
                ], 500);
            }

            // Simpan snap token ke DB
            $transaction->update(['midtrans_snap_token' => $snapResult['token']]);

            return response()->json([
                'success'     => true,
                'type'        => 'midtrans',
                'snap_token'  => $snapResult['token'],
                'receipt_data' => $receiptData,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Generate invoice number yang unik.
     */
    private function generateInvoiceNo(): string
    {
        do {
            $invoiceNo = 'INV-' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999);
        } while (Transaction::where('invoice_no', $invoiceNo)->exists());

        return $invoiceNo;
    }

    /**
     * Rollback: kembalikan stok jika Snap token gagal dibuat.
     */
    private function rollbackMidtransTransaction(Transaction $transaction, array $cart, int $outletId): void
    {
        foreach ($cart as $item) {
            $product = Product::where('outlet_id', $outletId)->find($item['id']);
            if ($product && $product->is_stock_tracked) {
                $product->stock += $item['qty'];
                $product->save();
            }
        }
        $transaction->details()->delete();
        $transaction->delete();
    }
}
