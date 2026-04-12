<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLogin()
    {
        return view('login'); // Pastikan nama file blade Anda sesuai
    }

    // 2. Tampilkan Halaman Register
    public function showRegister()
    {
        return view('register'); // Pastikan nama file blade Anda sesuai
    }

    // 3. Proses Pendaftaran (Register)
    public function register(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Proses simpan ke Database
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Enkripsi password
            ]);

            // Otomatiskan Login setelah berhasil daftar
            Auth::login($user);

            // Arahkan ke Dashboard
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        } catch (\Exception $e) {
            // JIKA GAGAL, TANGKAP ERRORNYA DAN TAMPILKAN DI FORM
            return back()->with('error', 'Sistem Database Error: ' . $e->getMessage())->withInput();
        }
    }

    // 4. Proses Masuk (Login)
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah user menggunakan Email atau Username
        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username/Email atau Password Anda salah.')->withInput();
    }

    // 5. Proses Keluar (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}
