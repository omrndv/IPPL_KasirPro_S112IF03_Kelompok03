<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $categories = Category::where('outlet_id', $outletId)
            ->latest()
            ->get();

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

        return view('transaksi', compact('products', 'categories', 'settings'));
    }

    public function checkout(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer',
            'cart.*.qty' => 'required|integer|min:1',
            'pay_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $details = [];

            foreach ($request->cart as $item) {
                $product = Product::where('outlet_id', $outletId)
                    ->lockForUpdate()
                    ->find($item['id']);

                if (!$product) {
                    throw new \Exception('Produk tidak ditemukan di outlet kamu.');
                }

                if ($product->is_stock_tracked && $product->stock < $item['qty']) {
                    throw new \Exception("Stok untuk {$product->name} tidak mencukupi! Sisa: {$product->stock}");
                }

                $itemSubtotal = $product->selling_price * $item['qty'];
                $subtotal += $itemSubtotal;

                if ($product->is_stock_tracked) {
                    $product->stock -= $item['qty'];
                    $product->save();
                }

                $details[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'qty' => $item['qty'],
                    'price' => $product->selling_price,
                    'subtotal' => $itemSubtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $taxEnabled = Setting::getValue('tax_enabled', '1') == '1';
            $taxRate = (float) Setting::getValue('tax_rate', 10);

            $tax = $taxEnabled ? $subtotal * ($taxRate / 100) : 0;
            $grandTotal = $subtotal + $tax;

            if ($request->pay_amount < $grandTotal) {
                throw new \Exception('Uang pembayaran kurang!');
            }

            $invoiceNo = 'INV-' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999);

            while (Transaction::where('invoice_no', $invoiceNo)->exists()) {
                $invoiceNo = 'INV-' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999);
            }

            $transaction = Transaction::create([
                'outlet_id' => $outletId,
                'invoice_no' => $invoiceNo,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'pay_amount' => $request->pay_amount,
                'return_amount' => $request->pay_amount - $grandTotal,
            ]);

            foreach ($details as &$detail) {
                $detail['transaction_id'] = $transaction->id;
            }

            TransactionDetail::insert($details);

            $transaction->load('details');

            $settings = Setting::getAllAsArray();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id,
                'invoice_no' => $transaction->invoice_no,
                'subtotal' => $transaction->subtotal,
                'tax' => $transaction->tax,
                'grand_total' => $transaction->grand_total,
                'payment_method' => $transaction->payment_method,
                'pay_amount' => $transaction->pay_amount,
                'return_amount' => $transaction->return_amount,
                'created_at' => $transaction->created_at->format('d M Y, H:i'),
                'items' => $transaction->details,
                'settings' => [
                    'store_name' => auth()->user()->outlet->name ?? 'KasirPro',
                    'store_phone' => auth()->user()->outlet->phone ?? '-',
                    'store_address' => auth()->user()->outlet->address ?? 'Alamat toko belum diatur',
                    'tax_rate' => $settings['tax_rate'] ?? $taxRate,
                    'receipt_footer' => $settings['receipt_footer'] ?? 'Terima kasih atas kunjungannya!',
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
