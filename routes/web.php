<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// 2. Akses Tamu / Belum Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Akses User Terdaftar / Sudah Login (Auth)
Route::middleware('auth')->group(function () {

    // --- RUTE PRODUK ---
    Route::get('/produk', [App\Http\Controllers\ProductController::class, 'index'])->name('produk.index');
    Route::post('/produk', [App\Http\Controllers\ProductController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('produk.destroy');

    // --- RUTE KATEGORI ---
    Route::post('/kategori', [App\Http\Controllers\CategoryController::class, 'store'])->name('kategori.store');

    // --- RUTE BAHAN BAKU ---
    Route::get('/bahan-baku', [App\Http\Controllers\RawMaterialController::class, 'index'])->name('bahan.index');
    Route::post('/bahan-baku', [App\Http\Controllers\RawMaterialController::class, 'store'])->name('bahan.store');
    Route::put('/bahan-baku/{id}', [App\Http\Controllers\RawMaterialController::class, 'update'])->name('bahan.update');
    Route::delete('/bahan-baku/{id}', [App\Http\Controllers\RawMaterialController::class, 'destroy'])->name('bahan.destroy');

    // Rute Khusus Quick Restock
    Route::post('/bahan-baku/{id}/add-stock', [App\Http\Controllers\RawMaterialController::class, 'addStock'])->name('bahan.addStock');

    // --- RUTE TRANSAKSI KASIR ---
    Route::get('/transaksi', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/transaksi/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');

    // --- RUTE ANALYTICS (LAPORAN & RIWAYAT) ---
    Route::get('/riwayat', [App\Http\Controllers\AnalyticsController::class, 'riwayat'])->name('analytics.riwayat');
    Route::get('/laporan', [App\Http\Controllers\AnalyticsController::class, 'laporan'])->name('analytics.laporan');

    // RUTE BARU UNTUK EXPORT
    Route::get('/laporan/export', [App\Http\Controllers\AnalyticsController::class, 'exportCsv'])->name('analytics.export');

    // Semua halaman ini otomatis TERKUNCI untuk yang belum login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/pengaturan', function () {
        return view('pengaturan');
    });
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
