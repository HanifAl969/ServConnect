<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * ChatbotController
 * 
 * Developer API: Implementasi AI Chatbot menggunakan OpenAI GPT
 * Fitur: SQA (validasi input, error handling) + SSE (sanitasi, logging, API key protection)
 */
class ChatbotController extends Controller
{
    /**
     * Endpoint utama chatbot
     * POST /api/chat
     * 
     * Security: Auth middleware + rate limiting diterapkan di routes/api.php
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'min:1',
                'max:1000',
            ],
        ]);

        $userMessage = strip_tags(trim($validated['message']));

        if ($this->containsInjectionPatterns($userMessage)) {
            Log::warning('Potential prompt injection detected', [
                'user_id' => auth()->id(),
                'ip'      => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'error'   => 'Pesan mengandung konten yang tidak diizinkan.',
            ], 422);
        }

        // === IMPLEMENTASI: Kirim ke OpenAI ===
        try {
            $response = Http::withHeaders([
                // SECURE CODING: API key diambil dari env, tidak di-hardcode
                'Authorization' => 'Bearer ' . config('services.openai.key'),
                'Content-Type'  => 'application/json',
            ])
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'       => 'gpt-3.5-turbo',
                'max_tokens'  => 500,
                'temperature' => 0.7,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten layanan ServConn, platform penyedia jasa. ' .
                                     'Bantu pengguna menemukan jasa yang mereka butuhkan. ' .
                                     'Jawab dalam Bahasa Indonesia secara ramah dan singkat.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => $userMessage,
                    ],
                ],
            ]);

            // Tangani error dari OpenAI
            if ($response->failed()) {
                Log::error('OpenAI API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json([
                    'success' => false,
                    'error'   => 'Layanan chatbot sedang tidak tersedia. Coba lagi nanti.',
                ], 503);
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak ada jawaban yang diterima.';

            $reply = htmlspecialchars(strip_tags($reply), ENT_QUOTES, 'UTF-8');

            Log::info('Chatbot request successful', [
                'user_id'    => auth()->id(),
                'tokens_used'=> $data['usage']['total_tokens'] ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'reply'   => $reply,
                'usage'   => [
                    'prompt_tokens'     => $data['usage']['prompt_tokens'] ?? 0,
                    'completion_tokens' => $data['usage']['completion_tokens'] ?? 0,
                ],
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('OpenAI connection failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error'   => 'Gagal terhubung ke layanan AI. Periksa koneksi Anda.',
            ], 503);
        } catch (\Exception $e) {
            Log::error('Chatbot unexpected error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error'   => 'Terjadi kesalahan internal.',
            ], 500);
        }
    }

    /**
     * Health check endpoint
     * GET /api/chat/health
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'status'    => 'ok',
            'service'   => 'ServConn Chatbot API',
            'timestamp' => now()->toISOString(),
        ]);
    }

    private function containsInjectionPatterns(string $message): bool
    {
        $patterns = [
            '/ignore\s+(all\s+)?previous\s+instructions/i',
            '/you\s+are\s+now\s+.{0,50}(dan|and)/i',
            '/system\s*:\s*(override|prompt|instruction)/i',
            '/\[INST\]|\[\/INST\]|<\|im_start\|>|<\|im_end\|>/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
    }
}
