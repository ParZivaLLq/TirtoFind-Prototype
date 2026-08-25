<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    protected string $apiKey;
    protected string $model;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('services.openrouter.key', env('OPENROUTER_API_KEY', ''));
        $this->model = (string) config('services.openrouter.model', 'google/gemini-2.5-flash');
        $this->apiUrl = (string) config('services.openrouter.url', 'https://openrouter.ai/api/v1/chat/completions');
    }

    /**
     * Send prompt to OpenRouter API.
     */
    protected function askAi(string $prompt, string $systemPrompt = 'Anda adalah asisten AI profesional untuk sistem TirtoFind Terminal Tirtonadi.'): ?string
    {
        if (empty($this->apiKey)) {
            Log::warning('OpenRouter API key is missing.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'TirtoFind Lost & Found System',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.4,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            } else {
                Log::error('OpenRouter API Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Auto generate catalog description using OpenRouter.
     */
    public function generateAutoDescription(string $title, string $category, string $color = '', string $style = 'Standar Katalog TirtoFind', ?string $imagePath = null, string $existingDescription = '', string $brand = ''): array
    {
        $prompt = "Buatkan deskripsi katalogisasi resmi barang temuan untuk sistem TirtoFind Terminal Tirtonadi Surakarta.\n" .
            "Nama Barang: {$title}\n" .
            "Kategori: {$category}\n" .
            "Warna: {$color}\n" .
            "Merek: {$brand}\n" .
            "Ciri/deskripsi yang sudah dicatat petugas: {$existingDescription}\n" .
            "Gaya Format: {$style}\n\n" .
            "Berikan respon JSON murni dengan format:\n" .
            "{\n" .
            "  \"description\": \"Teks deskripsi lengkap dan rapi dalam Bahasa Indonesia\",\n" .
            "  \"detected_category\": \"{$category}\",\n" .
            "  \"detected_color\": \"{$color}\",\n" .
            "  \"detected_brand\": \"Merek terdeteksi atau N/A\"\n" .
            "}";

        $aiResult = $this->askAiWithImage($prompt, "Anda adalah sistem Vision AI cataloging engine TirtoFind. Gunakan gambar sebagai referensi, tetapi jangan mengarang atribut yang tidak terlihat.", $imagePath);

        if ($aiResult) {
            $json = json_decode($this->cleanJsonResponse($aiResult), true);
            if (is_array($json) && !empty(trim((string) ($json['description'] ?? '')))) {
                return [
                    'available' => true,
                    'description' => trim($json['description']),
                    'detected_category' => $json['detected_category'] ?? $category,
                    'detected_color' => $json['detected_color'] ?? $color,
                    'detected_brand' => $json['detected_brand'] ?? ($brand ?: '-'),
                ];
            }
        }

        $fallbackParts = ["Ditemukan {$title}"];
        if ($color) {
            $fallbackParts[] = "berwarna {$color}";
        }
        if ($brand) {
            $fallbackParts[] = "dengan merek {$brand}";
        }
        $fallback = implode(' ', $fallbackParts) . ".";
        if ($existingDescription) {
            $fallback .= " Ciri-ciri: {$existingDescription}.";
        }

        return [
            'available' => false,
            'description' => $fallback,
            'detected_category' => $category,
            'detected_color' => $color,
            'detected_brand' => $brand ?: '-',
        ];
    }

    protected function askAiWithImage(string $prompt, string $systemPrompt, ?string $imagePath): ?string
    {
        if (!$imagePath) {
            return $this->askAi($prompt, $systemPrompt);
        }

        $absolutePath = public_path(ltrim(str_replace('/storage/', 'storage/', $imagePath), '/'));
        if (!is_file($absolutePath)) {
            return $this->askAi($prompt, $systemPrompt);
        }

        $mimeType = mime_content_type($absolutePath) ?: 'image/jpeg';
        $imageData = base64_encode((string) file_get_contents($absolutePath));

        if (empty($this->apiKey)) {
            Log::warning('OpenRouter API key is missing.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'TirtoFind Lost & Found System',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => [
                        ['type' => 'text', 'text' => $prompt],
                        ['type' => 'image_url', 'image_url' => ['url' => "data:{$mimeType};base64,{$imageData}"]],
                    ]],
                ],
                'temperature' => 0.4,
            ]);

            return $response->successful() ? ($response->json('choices.0.message.content') ?? null) : null;
        } catch (\Exception $e) {
            Log::error('OpenRouter Vision Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate AI Smart Matching confidence percentage between lost report & found item.
     */
    public function matchItems(string $lostDescription, string $foundDescription): ?array
    {
        $prompt = "Bandingkan dua deskripsi barang berikut dan analisis kecocokannya:\n" .
            "Laporan Kehilangan: \"{$lostDescription}\"\n" .
            "Barang Temuan: \"{$foundDescription}\"\n\n" .
            "Berikan respon JSON murni dengan format:\n" .
            "{\n" .
            "  \"score\": 94,\n" .
            "  \"reason\": \"Alasan singkat pencocokan dalam 1 kalimat Bahasa Indonesia\",\n" .
            "  \"color_match\": 100,\n" .
            "  \"brand_match\": 95,\n" .
            "  \"location_match\": 90,\n" .
            "  \"time_match\": 92\n" .
            "}";

        $aiResult = $this->askAi($prompt, "Anda adalah sistem Vision AI pencocok barang hilang TirtoFind.");

        if ($aiResult) {
            $json = json_decode($this->cleanJsonResponse($aiResult), true);
            if (isset($json['score'])) {
                return [
                    'available' => true,
                    'score' => (int) $json['score'],
                    'reason' => $json['reason'] ?? 'Cocok berdasarkan analisis deskripsi visual dan atribut lokasi.',
                    'color_match' => $json['color_match'] ?? 100,
                    'brand_match' => $json['brand_match'] ?? 95,
                    'location_match' => $json['location_match'] ?? 90,
                    'time_match' => $json['time_match'] ?? 92,
                ];
            }
        }

        return null;
    }

    /**
     * Clean markdown code block wraps from JSON string if AI outputs ```json ... ```.
     */
    protected function cleanJsonResponse(string $text): string
    {
        $text = preg_replace('/^```json\s*/i', '', trim($text));
        $text = preg_replace('/^```\s*/i', '', $text);
        $text = preg_replace('/\s*```$/i', '', $text);
        $jsonStart = strpos($text, '{');
        $jsonEnd = strrpos($text, '}');
        if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd > $jsonStart) {
            $text = substr($text, $jsonStart, $jsonEnd - $jsonStart + 1);
        }
        return trim($text);
    }
}
