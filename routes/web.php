<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransController;

// 1. Landing Page (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// Midtrans Webhook (tidak perlu auth — dikecualikan dari CSRF di VerifyCsrfToken)
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// 2. Akses Tamu / Belum Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // --- VERIFIKASI PENDAFTARAN VIA EMAIL OTP ---
    Route::get('/verify-registration', [AuthController::class, 'showVerifyRegister'])->name('register.verify');
    Route::post('/verify-registration', [AuthController::class, 'verifyRegister'])->name('register.confirm');
    Route::post('/resend-registration-otp', [AuthController::class, 'resendRegisterOtp'])->name('register.resend');

    // --- LUPA PASSWORD VIA EMAIL OTP ---
    Route::get('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\ForgotPasswordController::class, 'sendOtp'])->name('password.email');

    Route::get('/verify-otp', [App\Http\Controllers\ForgotPasswordController::class, 'showVerifyOtp'])->name('password.verify');
    Route::post('/verify-otp', [App\Http\Controllers\ForgotPasswordController::class, 'verifyOtp'])->name('password.confirm');

    Route::get('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// 3. Akses User Terdaftar / Sudah Login (Auth)
Route::middleware('auth')->group(function () {

    // --- RUTE PROTECTED (OWNER & ADMIN) ---
    Route::middleware([\App\Http\Middleware\OwnerOrAdminMiddleware::class])->group(function () {
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
        Route::post('/bahan-baku/{id}/add-stock', [App\Http\Controllers\RawMaterialController::class, 'addStock'])->name('bahan.addStock');

        // --- RUTE LAPORAN (ANALYTICS) ---
        Route::get('/laporan', [App\Http\Controllers\AnalyticsController::class, 'laporan'])->name('analytics.laporan');
        Route::get('/laporan/export', [App\Http\Controllers\AnalyticsController::class, 'exportCsv'])->name('analytics.export');

        // --- RUTE VOUCHER ---
        Route::get('/voucher', [App\Http\Controllers\VoucherController::class, 'index'])->name('voucher.index');
        Route::post('/voucher', [App\Http\Controllers\VoucherController::class, 'store'])->name('voucher.store');
        Route::put('/voucher/{id}', [App\Http\Controllers\VoucherController::class, 'update'])->name('voucher.update');
        Route::delete('/voucher/{id}', [App\Http\Controllers\VoucherController::class, 'destroy'])->name('voucher.destroy');
    });

    // --- RUTE TRANSAKSI KASIR (KASIR, OWNER, ADMIN) ---
    Route::get('/transaksi', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/transaksi/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');
    Route::post('/transaksi/cek-voucher', [App\Http\Controllers\VoucherController::class, 'checkVoucher'])->name('pos.check-voucher');

    // --- RUTE ANALYTICS RIWAYAT (KASIR, OWNER, ADMIN) ---
    Route::get('/riwayat', [App\Http\Controllers\AnalyticsController::class, 'riwayat'])->name('analytics.riwayat');
    Route::delete('/riwayat/{id}', [App\Http\Controllers\AnalyticsController::class, 'destroy'])->name('analytics.riwayat.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/ai-chat', [App\Http\Controllers\AiController::class, 'chat'])->name('dashboard.ai-chat');

    // --- RUTE SUPERADMIN ---
    Route::middleware([\App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
        Route::get('/superadmin/dashboard', [\App\Http\Controllers\SuperAdminController::class, 'index'])->name('superadmin.dashboard');
        Route::post('/superadmin/users', [\App\Http\Controllers\SuperAdminController::class, 'storeUser'])->name('superadmin.users.store');
        Route::put('/superadmin/users/{id}', [\App\Http\Controllers\SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
        Route::delete('/superadmin/users/{id}', [\App\Http\Controllers\SuperAdminController::class, 'destroyUser'])->name('superadmin.users.destroy');
        Route::put('/superadmin/users/{id}/password', [\App\Http\Controllers\SuperAdminController::class, 'resetUserPassword'])->name('superadmin.users.password');
        Route::post('/superadmin/outlets', [\App\Http\Controllers\SuperAdminController::class, 'storeOutlet'])->name('superadmin.outlets.store');
        Route::put('/superadmin/outlets/{id}', [\App\Http\Controllers\SuperAdminController::class, 'updateOutlet'])->name('superadmin.outlets.update');
        Route::delete('/superadmin/outlets/{id}', [\App\Http\Controllers\SuperAdminController::class, 'destroyOutlet'])->name('superadmin.outlets.destroy');
    });
    
    // --- RUTE PENGATURAN (OWNER SAJA) ---
    Route::middleware([\App\Http\Middleware\OwnerMiddleware::class])->group(function () {
        Route::get('/pengaturan', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/pengaturan/profil', [SettingController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/pengaturan/toko', [SettingController::class, 'updateStore'])->name('settings.store.update');
        Route::put('/pengaturan/struk', [SettingController::class, 'updateReceipt'])->name('settings.receipt.update');
    });
    
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
