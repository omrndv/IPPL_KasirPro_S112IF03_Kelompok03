<?php

namespace Tests\Feature;

use App\Models\Outlet;
use App\Models\User;
use App\Mail\SendRegistrationOtpMail;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationOtpAndAccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function createOutlet(): Outlet
    {
        return Outlet::create([
            'name' => 'Outlet Test',
        ]);
    }

    public function test_registration_redirects_to_otp_and_sends_email(): void
    {
        Mail::fake();

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('register.verify'));
        $response->assertSessionHas('registration_email', 'john@example.com');

        // Assert user created but unverified
        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->email_verified_at);

        // Assert OTP stored in database
        $this->assertDatabaseHas('password_otps', [
            'email' => 'john@example.com',
        ]);

        $otpRecord = DB::table('password_otps')->where('email', 'john@example.com')->first();
        $this->assertNotNull($otpRecord);

        // Assert mail dispatched
        Mail::assertSent(SendRegistrationOtpMail::class, function ($mail) use ($otpRecord) {
            return $mail->hasTo('john@example.com') && $mail->otp === $otpRecord->otp;
        });
    }

    public function test_verify_registration_page_requires_session_email(): void
    {
        $response = $this->get(route('register.verify'));
        $response->assertRedirect(route('register'));
        $response->assertSessionHas('error', 'Silakan daftar akun terlebih dahulu.');
    }

    public function test_verify_registration_otp_fails_if_incorrect_or_expired(): void
    {
        $outlet = $this->createOutlet();
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => null,
        ]);

        // 1. Incorrect OTP
        DB::table('password_otps')->insert([
            'email' => 'john@example.com',
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        $response = $this->withSession(['registration_email' => 'john@example.com'])
            ->post(route('register.confirm'), [
                'email' => 'john@example.com',
                'otp' => '999999', // incorrect
            ]);

        $response->assertSessionHas('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.');

        // 2. Expired OTP
        DB::table('password_otps')->where('email', 'john@example.com')->update([
            'expires_at' => Carbon::now()->subMinutes(1),
        ]);

        $response = $this->withSession(['registration_email' => 'john@example.com'])
            ->post(route('register.confirm'), [
                'email' => 'john@example.com',
                'otp' => '123456',
            ]);

        $response->assertSessionHas('error', 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.');
    }

    public function test_verify_registration_otp_success(): void
    {
        $outlet = $this->createOutlet();
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => null,
        ]);

        DB::table('password_otps')->insert([
            'email' => 'john@example.com',
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        $response = $this->withSession(['registration_email' => 'john@example.com'])
            ->post(route('register.confirm'), [
                'email' => 'john@example.com',
                'otp' => '123456',
            ]);

        $response->assertRedirect(route('dashboard'));

        // Assert user verified and logged in
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $this->assertAuthenticatedAs($user);

        // Assert session cleared and OTP record deleted
        $this->assertNull(session('registration_email'));
        $this->assertDatabaseMissing('password_otps', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_unverified_user_cannot_login_and_gets_new_otp(): void
    {
        Mail::fake();

        $outlet = $this->createOutlet();
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => null, // unverified
        ]);

        $response = $this->post(route('login'), [
            'username' => 'johndoe',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('register.verify'));
        $response->assertSessionHas('registration_email', 'john@example.com');
        $response->assertSessionHas('error');
        $this->assertGuest(); // should not be logged in

        // Assert new OTP generated and email sent
        $this->assertDatabaseHas('password_otps', [
            'email' => 'john@example.com',
        ]);

        $otpRecord = DB::table('password_otps')->where('email', 'john@example.com')->first();
        $this->assertNotNull($otpRecord);

        Mail::assertSent(SendRegistrationOtpMail::class, function ($mail) use ($otpRecord) {
            return $mail->hasTo('john@example.com') && $mail->otp === $otpRecord->otp;
        });
    }

    public function test_cashier_cannot_access_restricted_routes(): void
    {
        $outlet = $this->createOutlet();
        $cashier = User::create([
            'name' => 'Cashier User',
            'username' => 'cashier',
            'email' => 'cashier@example.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($cashier);

        // Access products -> 403
        $response = $this->get(route('produk.index'));
        $response->assertStatus(403);

        // Access raw materials -> 403
        $response = $this->get(route('bahan.index'));
        $response->assertStatus(403);

        // Access reports -> 403
        $response = $this->get(route('analytics.laporan'));
        $response->assertStatus(403);

        // Access settings -> 403
        $response = $this->get(route('settings.index'));
        $response->assertStatus(403);

        // Access POS -> 200 (allowed)
        $response = $this->get(route('pos.index'));
        $response->assertStatus(200);

        // Access history -> 200 (allowed)
        $response = $this->get(route('analytics.riwayat'));
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_settings_but_can_access_master_data(): void
    {
        $outlet = $this->createOutlet();
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);

        // Access settings -> 403
        $response = $this->get(route('settings.index'));
        $response->assertStatus(403);

        // Access products -> 200 (allowed)
        $response = $this->get(route('produk.index'));
        $response->assertStatus(200);

        // Access raw materials -> 200 (allowed)
        $response = $this->get(route('bahan.index'));
        $response->assertStatus(200);

        // Access reports -> 200 (allowed)
        $response = $this->get(route('analytics.laporan'));
        $response->assertStatus(200);
    }

    public function test_owner_can_access_settings(): void
    {
        $outlet = $this->createOutlet();
        $owner = User::create([
            'name' => 'Owner User',
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($owner);

        // Access settings -> 200 (allowed)
        $response = $this->get(route('settings.index'));
        $response->assertStatus(200);
    }
}
