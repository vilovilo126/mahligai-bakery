<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_requires_message(): void
    {
        $this->postJson('/ai/chat', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('message');
    }

    public function test_chat_rejects_overlong_message(): void
    {
        $this->postJson('/ai/chat', ['message' => str_repeat('a', 801)])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('message');
    }

    public function test_chat_informs_when_ai_not_configured(): void
    {
        config(['ai.api_key' => null]);

        $this->postJson('/ai/chat', ['message' => 'Halo, apa saja menu kalian?'])
            ->assertOk()
            ->assertJson(['reply' => 'Assisten AI belum dikonfigurasi. Silakan hubungi admin untuk mengaktifkan GEMINI_API_KEY di file .env.']);
    }

    public function test_chat_returns_reply_when_ai_configured(): void
    {
        config(['ai.api_key' => 'test-key']);

        Http::fake([
            '*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Selamat datang di Mahligai Bakery! Menu favorit kami adalah sourdough.'],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $this->postJson('/ai/chat', ['message' => 'Menu favorit apa?'])
            ->assertOk()
            ->assertJson(['reply' => 'Selamat datang di Mahligai Bakery! Menu favorit kami adalah sourdough.']);

        Http::assertSent(fn ($request) => str_contains($request->url(), 'v1beta/models/gemini-2.0-flash:generateContent')
            && str_contains($request->url(), 'key=test-key'));
    }

    public function test_chat_gracefully_handles_ai_failure(): void
    {
        config(['ai.api_key' => 'test-key']);

        Http::fake(['*' => Http::response([], 500)]);

        $this->postJson('/ai/chat', ['message' => 'Halo'])
            ->assertStatus(500)
            ->assertJsonFragment(['reply' => 'Maaf, saya sedang mengalami kendala menghubungi layanan AI. Silakan coba lagi beberapa saat.']);
    }
}
