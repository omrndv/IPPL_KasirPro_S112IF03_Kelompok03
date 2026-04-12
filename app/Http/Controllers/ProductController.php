<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Menampilkan Halaman Data Produk
    public function index(Request $request)
    {
        // Mulai merakit query database
        $query = Product::with('category')->latest();

        // 1. Logika Pencarian (Search) berdasarkan Nama atau SKU
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter berdasarkan Kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Eksekusi query
        $products = $query->get();

        $categories = Category::all();

        return view('produk', compact('products', 'categories'));
    }

    // 2. Menyimpan Produk Baru ke Database
    public function store(Request $request)
    {
        // 1. Validasi data, tambahkan validasi untuk image
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock'         => 'required|numeric|min:0',
            'unit'          => 'required|string',
            'sku'           => 'nullable|string|unique:products,sku',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ], [
            'sku.unique' => 'Kode SKU/Barcode ini sudah dipakai produk lain.'
        ]);

        // 2. Proses Upload Gambar (Jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'products' di dalam public storage
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan data ke Database
        Product::create([
            'name'             => $request->name,
            'category_id'      => $request->category_id,
            'cost_price'       => $request->cost_price,
            'selling_price'    => $request->selling_price,
            'stock'            => $request->stock,
            'unit'             => $request->unit,
            'sku'              => $request->sku,
            'is_stock_tracked' => $request->has('is_stock_tracked') ? true : false,
            'image'            => $imagePath, // Simpan path gambar
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke rak KasirPro!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'cost_price'    => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock'         => 'required|numeric|min:0',
            // Validasi unik untuk SKU, TAPI abaikan ID produk ini sendiri agar bisa di-save tanpa mengubah SKU
            'sku'           => 'nullable|string|unique:products,sku,' . $id,
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Cek jika ada upload foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan foto baru
            $product->image = $request->file('image')->store('products', 'public');
        }

        // Update data lainnya
        $product->update([
            'name'          => $request->name,
            'category_id'   => $request->category_id,
            'cost_price'    => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock'         => $request->stock,
            'sku'           => $request->sku,
        ]);

        return redirect()->back()->with('success', 'Data produk berhasil diperbarui!');
    }

    // 2. Sempurnakan Fungsi Hapus (Delete)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file foto dari server (Storage) jika produk dihapus
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari sistem.');
    }
}
