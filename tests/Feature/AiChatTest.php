<?php

namespace Tests\Feature;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiChatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guest users are redirected to login.
     */
    public function test_ai_chat_endpoint_requires_auth(): void
    {
        $response = $this->postJson(route('dashboard.ai-chat'), [
            'message' => 'Halo AI!',
        ]);

        $response->assertStatus(401); // Unauthorized for JSON response
    }

    /**
     * Test that authenticated users can successfully get a reply.
     */
    public function test_authenticated_user_can_chat_with_ai(): void
    {
        // Set a mock environment variable so the service runs
        config(['services.gemini.key' => 'fake-key']);

        $outlet = Outlet::create([
            'name' => 'Test Outlet',
            'address' => 'Test Address',
            'phone' => '1234567890',
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuserchat',
            'email' => 'testchat@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
        ]);

        // Fake the Gemini API response
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo Owner! Penjualan Anda bulan ini terpantau sangat baik. Teruskan kerja keras Anda.']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('dashboard.ai-chat'), [
            'message' => 'Bagaimana performa toko saya bulan ini?',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'reply' => 'Halo Owner! Penjualan Anda bulan ini terpantau sangat baik. Teruskan kerja keras Anda.',
        ]);
    }
}
