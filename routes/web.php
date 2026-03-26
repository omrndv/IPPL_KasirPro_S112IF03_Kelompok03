<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('/transaksi', function () {
    return view('transaksi');
});
Route::get('/produk', function () {
    return view('produk');
});
Route::get('/laporan', function () {
    return view('laporan');
});
Route::get('/riwayat', function () {
    return view('riwayat');
});
Route::get('/pengaturan', function () {
    return view('pengaturan');
});
