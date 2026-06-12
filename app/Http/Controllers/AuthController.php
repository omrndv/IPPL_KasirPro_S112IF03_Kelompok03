<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $outlet = Outlet::create([
                'name' => $request->name . ' Outlet',
                'address' => null,
                'phone' => null,
            ]);

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'owner',
                'outlet_id' => $outlet->id,
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Sistem Database Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /**
             * Jaga-jaga untuk user lama yang belum punya outlet_id.
             * Kalau semua user lama sudah kamu isi outlet_id lewat tinker, bagian ini tetap aman.
             */
            $user = Auth::user();

            if ($user->isSuperAdmin()) {
                return redirect()->route('superadmin.dashboard');
            }

            if (!$user->outlet_id) {
                $outlet = Outlet::firstOrCreate([
                    'name' => 'Outlet Utama',
                ], [
                    'address' => null,
                    'phone' => null,
                ]);

                $user->update([
                    'role' => $user->role ?? 'owner',
                    'outlet_id' => $outlet->id,
                ]);
            }

            return redirect()->route('dashboard');
        }

        return back()
            ->with('error', 'Username/Email atau Password Anda salah.')
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}