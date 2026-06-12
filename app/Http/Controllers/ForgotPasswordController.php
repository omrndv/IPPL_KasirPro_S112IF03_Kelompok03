<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar dalam sistem.',
        ]);

        $email = $request->email;
        $otp = sprintf("%06d", rand(100000, 999999));

        DB::beginTransaction();

        try {
            // Delete old OTPs
            DB::table('password_otps')->where('email', $email)->delete();

            // Insert new OTP
            DB::table('password_otps')->insert([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(15),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();

            // Send Mail
            Mail::to($email)->send(new SendOtpMail($otp));

            return redirect()->route('password.verify', ['email' => $email])
                ->with('success', 'Kode OTP telah dikirimkan ke email Anda. Silakan periksa kotak masuk atau spam.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengirim OTP: ' . $e->getMessage())->withInput();
        }
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->email;

        if (!$email) {
            return redirect()->route('password.request')->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }

        return view('verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
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
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$record) {
            return back()->with('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.')->withInput();
        }

        // OTP is correct, clear it
        DB::table('password_otps')->where('email', $email)->delete();

        // Put email into session to authorize password reset
        session(['password_reset_email' => $email]);

        return redirect()->route('password.reset')
            ->with('success', 'Verifikasi OTP berhasil! Silakan masukkan kata sandi baru Anda.');
    }

    public function showResetPassword()
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi Anda telah berakhir. Silakan minta OTP baru.');
        }

        return view('reset-password-page');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi Anda telah berakhir. Silakan minta OTP baru.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $email = session('password_reset_email');

        DB::beginTransaction();

        try {
            $user = User::where('email', $email)->firstOrFail();
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            // Forget the session email
            session()->forget('password_reset_email');

            return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan login kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mereset kata sandi: ' . $e->getMessage());
        }
    }
}
