<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        return User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword'),
            'role' => 'owner',
            'outlet_id' => null,
        ]);
    }

    public function test_guest_can_view_forgot_password_page(): void
    {
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi');
    }

    public function test_request_otp_validations(): void
    {
        // 1. Required validation
        $response = $this->post(route('password.email'), ['email' => '']);
        $response->assertSessionHasErrors(['email' => 'Email wajib diisi.']);

        // 2. Email format validation
        $response = $this->post(route('password.email'), ['email' => 'invalid-email']);
        $response->assertSessionHasErrors(['email' => 'Format email tidak valid.']);

        // 3. Exists validation
        $response = $this->post(route('password.email'), ['email' => 'nonexistent@example.com']);
        $response->assertSessionHasErrors(['email' => 'Email ini tidak terdaftar dalam sistem.']);
    }

    public function test_request_otp_generates_otp_and_sends_mail(): void
    {
        Mail::fake();

        $user = $this->createUser();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('password.verify', ['email' => $user->email]));
        $response->assertSessionHas('success');

        // Check DB has OTP record
        $this->assertDatabaseHas('password_otps', [
            'email' => $user->email,
        ]);

        $otpRecord = DB::table('password_otps')->where('email', $user->email)->first();
        $this->assertNotNull($otpRecord);
        $this->assertEquals(6, strlen($otpRecord->otp));

        // Check Mail sent
        Mail::assertSent(SendOtpMail::class, function ($mail) use ($user, $otpRecord) {
            return $mail->hasTo($user->email) && $mail->otp === $otpRecord->otp;
        });
    }

    public function test_verify_otp_page_requires_email(): void
    {
        $response = $this->get(route('password.verify'));
        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error', 'Silakan masukkan email Anda terlebih dahulu.');
    }

    public function test_verify_otp_validations(): void
    {
        $user = $this->createUser();

        // 1. Required validation
        $response = $this->post(route('password.confirm'), [
            'email' => $user->email,
            'otp' => '',
        ]);
        $response->assertSessionHasErrors(['otp' => 'Kode OTP wajib diisi.']);

        // 2. Size validation
        $response = $this->post(route('password.confirm'), [
            'email' => $user->email,
            'otp' => '12345',
        ]);
        $response->assertSessionHasErrors(['otp' => 'Kode OTP harus berjumlah 6 digit.']);
    }

    public function test_verify_otp_invalid_or_expired(): void
    {
        $user = $this->createUser();

        // 1. Incorrect OTP
        DB::table('password_otps')->insert([
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(15),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->post(route('password.confirm'), [
            'email' => $user->email,
            'otp' => '999999', // wrong OTP
        ]);
        $response->assertSessionHas('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.');

        // 2. Expired OTP
        DB::table('password_otps')->where('email', $user->email)->update([
            'expires_at' => Carbon::now()->subMinutes(1),
        ]);

        $response = $this->post(route('password.confirm'), [
            'email' => $user->email,
            'otp' => '123456',
        ]);
        $response->assertSessionHas('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.');
    }

    public function test_verify_otp_success(): void
    {
        $user = $this->createUser();

        DB::table('password_otps')->insert([
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(15),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->post(route('password.confirm'), [
            'email' => $user->email,
            'otp' => '123456',
        ]);

        $response->assertRedirect(route('password.reset'));
        $response->assertSessionHas('password_reset_email', $user->email);

        // Check OTP deleted from DB
        $this->assertDatabaseMissing('password_otps', [
            'email' => $user->email,
        ]);
    }

    public function test_reset_password_page_requires_session_email(): void
    {
        $response = $this->get(route('password.reset'));
        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error', 'Sesi Anda telah berakhir. Silakan minta OTP baru.');
    }

    public function test_reset_password_validations(): void
    {
        $user = $this->createUser();

        // Put email in session
        $this->withSession(['password_reset_email' => $user->email]);

        // 1. Password required
        $response = $this->post(route('password.update'), [
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors(['password' => 'Kata sandi baru wajib diisi.']);

        // 2. Password length min 8
        $response = $this->post(route('password.update'), [
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        $response->assertSessionHasErrors(['password' => 'Kata sandi minimal harus 8 karakter.']);

        // 3. Password confirmation mismatch
        $response = $this->post(route('password.update'), [
            'password' => 'newpassword123',
            'password_confirmation' => 'mismatch123',
        ]);
        $response->assertSessionHasErrors(['password' => 'Konfirmasi kata sandi tidak cocok.']);
    }

    public function test_reset_password_success(): void
    {
        $user = $this->createUser();

        // Put email in session
        $this->withSession(['password_reset_email' => $user->email]);

        $response = $this->post(route('password.update'), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Kata sandi berhasil diperbarui! Silakan login kembali.');

        // Assert session email cleared
        $this->assertNull(session('password_reset_email'));

        // Assert password updated in DB
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }
}
