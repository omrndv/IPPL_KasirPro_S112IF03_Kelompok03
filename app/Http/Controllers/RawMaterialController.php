<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $query = RawMaterial::where('outlet_id', $outletId)->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $raw_materials = $query->get();

        $categories = RawMaterial::where('outlet_id', $outletId)
            ->select('category')
            ->distinct()
            ->pluck('category');

        $total_items = RawMaterial::where('outlet_id', $outletId)->count();

        $critical_items = RawMaterial::where('outlet_id', $outletId)
            ->whereRaw('stock <= min_stock')
            ->count();

        $total_value = RawMaterial::where('outlet_id', $outletId)
            ->selectRaw('SUM(stock * price_per_unit) as total')
            ->value('total') ?? 0;

        return view('bahan_baku', compact(
            'raw_materials',
            'total_items',
            'critical_items',
            'total_value',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        RawMaterial::create([
            'outlet_id' => $outletId,
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'price_per_unit' => $request->price_per_unit,
        ]);

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $material = RawMaterial::where('outlet_id', $outletId)->findOrFail($id);

        $material->update([
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'price_per_unit' => $request->price_per_unit,
        ]);

        return redirect()->back()->with('success', 'Data bahan baku diperbarui!');
    }

    public function destroy($id)
    {
        $outletId = auth()->user()->outlet_id;

        $material = RawMaterial::where('outlet_id', $outletId)->findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', 'Bahan baku dihapus.');
    }

    public function addStock(Request $request, $id)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'added_stock' => 'required|numeric|min:0.1',
        ]);

        $material = RawMaterial::where('outlet_id', $outletId)->findOrFail($id);

        $material->stock += $request->added_stock;
        $material->save();

        return redirect()->back()->with(
            'success',
            'Stok ' . $material->name . ' berhasil ditambah sebanyak ' . $request->added_stock . ' ' . $material->unit
        );
    }
}