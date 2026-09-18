<?php

namespace App\Services\Ai;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    /**
     * Kirim pertanyaan pengguna ke Gemini API dan kembalikan jawaban teksnya.
     */
    public function ask(string $message): string
    {
        try {
            $response = Http::connectTimeout(5)
                ->timeout(config('ai.timeout'))
                ->asJson()
                ->post($this->endpoint(), [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $this->buildPrompt($message)],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 600,
                    ],
                ])
                ->throw();
        } catch (ConnectionException $e) {
            throw new RuntimeException('Terjadi masalah koneksi ke layanan AI.', 0, $e);
        }

        $responseData = $response->json();
        $parts = data_get($responseData, 'candidates.0.content.parts', []);

        $text = collect($parts)
            ->map(fn (array $part) => data_get($part, 'text'))
            ->filter()
            ->implode("\n");

        if (blank($text)) {
            throw new RuntimeException('Layanan AI mengembalikan respons kosong.');
        }

        return trim($text);
    }

    /**
     * Bangun prompt sistem dengan konteks bisnis Mahligai Bakery.
     */
    private function buildPrompt(string $message): string
    {
        $whatsapp = config('business.whatsapp_display');

        $menu = collect(config('menu.groups', []))
            ->map(function (array $group): string {
                $lines = ['### '.$group['title']];

                if (isset($group['badge'])) {
                    $lines[] = 'Label: '.$group['badge'];
                }

                foreach ($group['variants'] ?? [] as $variant) {
                    $line = '- '.$variant['name'];
                    if (isset($variant['price'])) {
                        $line .= ': '.$this->formatPrice($variant['price']);
                        if (! empty($variant['per_pcs'])) {
                            $line .= ' per pcs';
                        }
                    }
                    if (! empty($variant['note'])) {
                        $line .= ' ('.$variant['note'].')';
                    }
                    $lines[] = $line;
                }

                foreach ($group['variant_groups'] ?? [] as $subgroup) {
                    $lines[] = $subgroup['label'].':';
                    foreach ($subgroup['items'] as $variant) {
                        $line = '  - '.$variant['name'].': '.$this->formatPrice($variant['price']);
                        if (! empty($variant['per_pcs'])) {
                            $line .= ' per pcs';
                        }
                        $lines[] = $line;
                    }
                }

                foreach ($group['packages'] ?? [] as $package) {
                    $line = '- Paket '.$package['name'].': '.$this->formatPrice($package['price']);
                    if (! empty($package['note'])) {
                        $line .= ' ('.$package['note'].')';
                    }
                    $lines[] = $line;
                }

                foreach ($group['add_ons'] ?? [] as $addOn) {
                    $line = '- Additional '.$addOn['name'].': + '.$this->formatPrice($addOn['price']);
                    if (! empty($addOn['note'])) {
                        $line .= ' '.$addOn['note'];
                    }
                    $lines[] = $line;
                }

                return implode("\n", $lines);
            })
            ->join("\n\n");

        return <<<PROMPT
Kamu adalah "Mahligai AI Assistant", customer service virtual dari toko roti Mahligai Bakery.

Informasi bisnis:
- Nama toko: Mahligai Bakery
- Tagline: "Rasa Hangat, Kualitas Istimewa"
- Alamat: Jl. Tukad Barito Timur No.99, Renon, Denpasar Selatan, Kota Denpasar, Bali 80226
- Jam operasional: Setiap hari (Senin - Minggu) pukul 07.00 - 22.00 WITA
- Kontak / WhatsApp: $whatsapp
- Rating: 4,6/5 dari 195 ulasan
- Kisaran harga: Rp1.000 - Rp50.000 per orang

Menu produk tersedia:
$menu

Jawablah pertanyaan pelanggan dengan ramah, hangat, dan ringkas dalam Bahasa Indonesia. Jika pertanyaan berada di luar konteks bakery atau toko, arahkan kembali dengan sopan ke layanan kami. Jika ada informasi yang tidak diketahui, jangan mengarang — sarankan pelanggan menghubungi $whatsapp.

Pertanyaan pelanggan: $message
PROMPT;
    }

    private function formatPrice(int $price): string
    {
        return 'Rp'.number_format($price, 0, ',', '.');
    }

    private function endpoint(): string
    {
        return rtrim((string) config('ai.url'), '/')
            .'/v1beta/models/'.config('ai.model')
            .':generateContent?key='.config('ai.api_key');
    }
}
