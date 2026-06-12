<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $outletId = auth()->user()->outlet_id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->where(function ($query) use ($outletId) {
                    return $query->where('outlet_id', $outletId);
                }),
            ],
        ], [
            'name.unique' => 'Kategori ini sudah ada di outlet kamu, silakan buat yang lain.',
        ]);

        Category::create([
            'outlet_id' => $outletId,
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);

        return redirect()->back()->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan!');
    }
}