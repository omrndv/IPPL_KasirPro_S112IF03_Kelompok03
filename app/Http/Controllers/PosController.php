<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    // 1. Menampilkan Halaman Kasir (UI)
    public function index(Request $request)
    {
        // Ambil semua kategori untuk filter tombol di atas
        $categories = Category::all();

        // Ambil produk, bisa difilter berdasarkan pencarian atau klik kategori
        $query = Product::where('stock', '>', 0); // Hanya tampilkan yang stoknya ada!

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();

        return view('transaksi', compact('products', 'categories'));
    }

    // 2. Memproses Checkout / Pembayaran (API backend)
    public function checkout(Request $request)
    {
        // Validasi input dari JavaScript
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'pay_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string'
        ]);

        // Mula sistem anti-bocor (Database Transaction)
        DB::beginTransaction();

        try {
            $subtotal = 0;
            $details = [];

            // Looping keranjang belanja
            foreach ($request->cart as $item) {
                // Kunci produk agar tidak dibeli kasir lain di detik yang sama (Pessimistic Locking)
                $product = Product::lockForUpdate()->find($item['id']);

                // Cek apakah stok cukup
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok untuk {$product->name} tidak mencukupi! Sisa: {$product->stock}");
                }

                $itemSubtotal = $product->selling_price * $item['qty'];
                $subtotal += $itemSubtotal;

                // Kurangi stok produk
                $product->stock -= $item['qty'];
                $product->save();

                // Siapkan data detail untuk disimpan
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

            // Hitung Pajak (Misal 10%)
            $tax = $subtotal * 0.10;
            $grandTotal = $subtotal + $tax;

            // Pastikan uang cukup
            if ($request->pay_amount < $grandTotal) {
                throw new \Exception("Uang pembayaran kurang!");
            }

            // Generate Nomor Invoice unik
            $invoiceNo = 'INV-' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999);

            // Simpan Transaksi Utama
            $transaction = Transaction::create([
                'invoice_no' => $invoiceNo,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'pay_amount' => $request->pay_amount,
                'return_amount' => $request->pay_amount - $grandTotal
            ]);

            // Masukkan ID transaksi ke detail lalu simpan massal (lebih cepat)
            foreach ($details as &$detail) {
                $detail['transaction_id'] = $transaction->id;
            }
            TransactionDetail::insert($details);

            // Jika semua sukses, Commit (permanenkan ke database)
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id,
                'invoice_no' => $invoiceNo,
                'return_amount' => $transaction->return_amount
            ]);
        } catch (\Exception $e) {
            // Jika ada error (stok habis/uang kurang), batalkan semua!
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
