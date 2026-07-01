<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Send a prompt to Gemini API with optional multi-turn conversation history.
     *
     * @param string $userPrompt   The current user message
     * @param string $systemPrompt System instruction / context
     * @param array  $history      Array of ['role' => 'user'|'model', 'content' => string]
     * @return string
     */
    public function generateResponse(string $userPrompt, string $systemPrompt, array $history = []): string
    {
        if (empty($this->apiKey)) {
            return "Kunci API (GEMINI_API_KEY) belum dikonfigurasi. Silakan tambahkan ke file .env Anda.";
        }

        // Build the contents array from history + current message
        $contents = [];

        foreach ($history as $turn) {
            $role = $turn['role'] === 'user' ? 'user' : 'model';
            $contents[] = [
                'role'  => $role,
                'parts' => [['text' => $turn['content']]],
            ];
        }

        // Append the new user message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userPrompt]],
        ];

        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents'         => $contents,
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'generationConfig' => [
                    'temperature'     => 0.75,
                    'maxOutputTokens' => 1024,
                    'topP'            => 0.95,
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HARASSMENT',        'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH',       'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($text) {
                    return $text;
                }

                // Handle finish reason (e.g. safety block)
                $finishReason = $data['candidates'][0]['finishReason'] ?? 'UNKNOWN';
                Log::warning("Gemini finish reason: {$finishReason}", ['data' => $data]);
                return "Maaf, saya tidak dapat memproses permintaan tersebut saat ini.";
            }

            $status = $response->status();
            Log::error("Gemini API Error [{$status}]: " . $response->body());

            if ($status === 401 || $status === 403) {
                return "Gagal menghubungkan ke Gemini AI. Kunci API tidak valid atau tidak memiliki izin. Silakan periksa GEMINI_API_KEY di file .env.";
            }

            if ($status === 429) {
                return "Batas penggunaan API tercapai. Silakan coba lagi beberapa saat.";
            }

            if ($status === 404) {
                return "Model Gemini tidak ditemukan. Pastikan nama model di konfigurasi sudah benar.";
            }

            return "Terjadi kesalahan saat berkomunikasi dengan AI (Status: {$status}).";

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gemini Connection Error: ' . $e->getMessage());
            return "Koneksi ke server AI gagal. Pastikan server dapat mengakses internet.";
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return "Terjadi kesalahan tidak terduga saat menghubungi asisten AI.";
        }
    }
}
