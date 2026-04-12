<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Fungsi untuk menyimpan kategori baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.unique' => 'Kategori ini sudah ada, silakan buat yang lain.'
        ]);

        // Simpan ke database
        Category::create([
            'name' => $request->name
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan!');
    }
}
