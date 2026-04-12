<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = RawMaterial::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $raw_materials = $query->get();

        // --- TAMBAHKAN BARIS INI: Ambil daftar kategori unik dari database ---
        $categories = RawMaterial::select('category')->distinct()->pluck('category');

        $total_items = RawMaterial::count();
        $critical_items = RawMaterial::whereRaw('stock <= min_stock')->count();
        $total_value = RawMaterial::selectRaw('SUM(stock * price_per_unit) as total')->value('total');

        // Pastikan variabel $categories ikut dikirim ke view (tambahkan di dalam compact)
        return view('bahan_baku', compact('raw_materials', 'total_items', 'critical_items', 'total_value', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        RawMaterial::create($request->all());
        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        RawMaterial::findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Data bahan baku diperbarui!');
    }

    public function destroy($id)
    {
        RawMaterial::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Bahan baku dihapus.');
    }

    // FITUR REKOMENDASI: Quick Restock (Tambah Stok Tanpa Edit Form Penuh)
    public function addStock(Request $request, $id)
    {
        $request->validate(['added_stock' => 'required|numeric|min:0.1']);

        $material = RawMaterial::findOrFail($id);
        $material->stock += $request->added_stock;
        $material->save();

        return redirect()->back()->with('success', 'Stok ' . $material->name . ' berhasil ditambah sebanyak ' . $request->added_stock . ' ' . $material->unit);
    }
}
