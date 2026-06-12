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
                'email_verified_at' => null,
            ]);

            $otp = sprintf("%06d", rand(100000, 999999));

            // Delete old OTPs
            DB::table('password_otps')->where('email', $user->email)->delete();

            // Insert new OTP
            DB::table('password_otps')->insert([
                'email' => $user->email,
                'otp' => $otp,
                'expires_at' => \Carbon\Carbon::now()->addMinutes(15),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            DB::commit();

            // Send Mail
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendRegistrationOtpMail($otp));

            // Store in session
            session(['registration_email' => $user->email]);

            return redirect()->route('register.verify')
                ->with('success', 'Registrasi berhasil! Kode OTP aktivasi akun telah dikirimkan ke email Anda.');
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
            $user = Auth::user();

            // Block unverified users from logging in
            if ($user->email_verified_at === null) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $otp = sprintf("%06d", rand(100000, 999999));

                DB::beginTransaction();
                try {
                    DB::table('password_otps')->where('email', $user->email)->delete();
                    DB::table('password_otps')->insert([
                        'email' => $user->email,
                        'otp' => $otp,
                        'expires_at' => \Carbon\Carbon::now()->addMinutes(15),
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                    DB::commit();

                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendRegistrationOtpMail($otp));
                } catch (\Exception $e) {
                    DB::rollBack();
                }

                session(['registration_email' => $user->email]);

                return redirect()->route('register.verify')
                    ->with('error', 'Akun Anda belum aktif. Kode verifikasi OTP baru telah dikirimkan ke email Anda.');
            }

            $request->session()->regenerate();

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

    public function showVerifyRegister()
    {
        $email = session('registration_email');

        if (!$email) {
            return redirect()->route('register')->with('error', 'Silakan daftar akun terlebih dahulu.');
        }

        return view('verify-register-otp', compact('email'));
    }

    public function verifyRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $email = $request->email;
        $otp = $request->otp;

        $record = DB::table('password_otps')
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('expires_at', '>', \Carbon\Carbon::now())
            ->first();

        if (!$record) {
            return back()->with('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.')->withInput();
        }

        DB::beginTransaction();
        try {
            // Delete OTP
            DB::table('password_otps')->where('email', $email)->delete();

            // Verify user
            $user = User::where('email', $email)->firstOrFail();
            $user->update([
                'email_verified_at' => \Carbon\Carbon::now(),
            ]);

            DB::commit();

            // Log user in
            Auth::login($user);

            // Clear session email
            session()->forget('registration_email');

            return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil! Akun Anda kini telah aktif.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memverifikasi akun: ' . $e->getMessage())->withInput();
        }
    }

    public function resendRegisterOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        $otp = sprintf("%06d", rand(100000, 999999));

        DB::beginTransaction();
        try {
            DB::table('password_otps')->where('email', $email)->delete();
            DB::table('password_otps')->insert([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => \Carbon\Carbon::now()->addMinutes(15),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

            DB::commit();

            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\SendRegistrationOtpMail($otp));

            return back()->with('success', 'Kode OTP baru berhasil dikirimkan ke email Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengirim ulang OTP: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}