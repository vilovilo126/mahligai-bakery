<?php

namespace App\Http\Controllers;

use App\Services\Ai\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AiChatController extends Controller
{
    public function __construct(private readonly GeminiService $gemini) {}

    public function chat(Request $request): JsonResponse
    {
        $message = $request->validate([
            'message' => ['required', 'string', 'max:800'],
        ])['message'];

        if (blank(config('ai.api_key'))) {
            return response()->json([
                'reply' => 'Assisten AI belum dikonfigurasi. Silakan hubungi admin untuk mengaktifkan GEMINI_API_KEY di file .env.',
            ]);
        }

        try {
            $reply = $this->gemini->ask($message);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'reply' => 'Maaf, saya sedang mengalami kendala menghubungi layanan AI. Silakan coba lagi beberapa saat.',
            ], 500);
        }

        return response()->json(['reply' => $reply]);
    }
}
