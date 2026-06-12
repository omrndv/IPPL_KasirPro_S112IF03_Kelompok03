<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $query = Product::with('category')
            ->where('outlet_id', $outletId)
            ->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();

        $categories = Category::where('outlet_id', $outletId)
            ->latest()
            ->get();

        return view('produk', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'sku' => [
                'nullable',
                'string',
                Rule::unique('products', 'sku')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                })
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'sku.unique' => 'Kode SKU/Barcode ini sudah dipakai produk lain.',
            'category_id.exists' => 'Kategori tidak valid untuk outlet kamu.',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'outlet_id' => $outletId,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'sku' => $request->sku,
            'is_stock_tracked' => $request->has('is_stock_tracked'),
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke rak KasirPro!');
    }

    public function update(Request $request, $id)
    {
        $outletId = auth()->user()->outlet_id;

        $product = Product::where('outlet_id', $outletId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'sku' => [
                'nullable',
                'string',
                Rule::unique('products', 'sku')->ignore($product->id)->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                })
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'sku.unique' => 'Kode SKU/Barcode ini sudah dipakai produk lain.',
            'category_id.exists' => 'Kategori tidak valid untuk outlet kamu.',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'sku' => $request->sku,
            'is_stock_tracked' => $request->has('is_stock_tracked'),
            'image' => $product->image,
        ]);

        return redirect()->back()->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $outletId = auth()->user()->outlet_id;

        $product = Product::where('outlet_id', $outletId)->findOrFail($id);

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari sistem.');
    }
}