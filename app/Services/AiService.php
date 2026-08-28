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
                'max_tokens' => 600,
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
                'max_tokens' => 600,
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
            "Berikan respon JSON murni dengan format (isi angka nyata, bukan contoh):\n" .
            "{\n" .
            "  \"score\": <total_skor_0_sampai_100>,\n" .
            "  \"reason\": \"Alasan singkat pencocokan dalam 1 kalimat Bahasa Indonesia\",\n" .
            "  \"color_match\": <skor_0_sampai_100>,\n" .
            "  \"brand_match\": <skor_0_sampai_100>,\n" .
            "  \"location_match\": <skor_0_sampai_100>,\n" .
            "  \"time_match\": <skor_0_sampai_100>\n" .
            "}";

        $aiResult = $this->askAi($prompt, "Anda adalah sistem Vision AI pencocok barang hilang TirtoFind. Berikan skor kecocokan yang akurat berdasarkan kesamaan nama barang, warna, merek, lokasi, dan waktu. Jangan gunakan nilai contoh seperti 94, 100, 95, 90, 92.");

        if ($aiResult) {
            $json = json_decode($this->cleanJsonResponse($aiResult), true);
            if (isset($json['score']) && is_numeric($json['score'])) {
                return [
                    'available' => true,
                    'score' => (int) $json['score'],
                    'reason' => $json['reason'] ?? 'Cocok berdasarkan analisis deskripsi visual dan atribut lokasi.',
                    'color_match' => (int) ($json['color_match'] ?? 0),
                    'brand_match' => (int) ($json['brand_match'] ?? 0),
                    'location_match' => (int) ($json['location_match'] ?? 0),
                    'time_match' => (int) ($json['time_match'] ?? 0),
                ];
            }
        }

        // --- Algorithmic fallback when API key is empty or API fails ---
        return $this->algorithmicMatch($lostDescription, $foundDescription);
    }

    /**
     * Fallback: keyword-based similarity scoring without AI.
     */
    protected function algorithmicMatch(string $lostDesc, string $foundDesc): array
    {
        $lostWords = array_filter(preg_split('/[\s,;]+/', mb_strtolower($lostDesc)));
        $foundWords = array_filter(preg_split('/[\s,;]+/', mb_strtolower($foundDesc)));

        $stopwords = ['barang', 'nama', 'kategori', 'warna', 'merek', 'lokasi', 'hilang', 'temu', 'deskripsi', 'ciri', 'khusus', 'dan', 'atau', 'yang', 'di', 'ke', 'dari', 'tidak', 'ada'];
        $lostWords = array_values(array_diff($lostWords, $stopwords));
        $foundWords = array_values(array_diff($foundWords, $stopwords));

        $commonWords = count(array_intersect($lostWords, $foundWords));
        $totalWords = max(count($lostWords), count($foundWords), 1);
        $overlapRatio = min(100, (int) round(($commonWords / $totalWords) * 100));

        // Extract specific fields
        $colorScore = $this->extractFieldScore($lostDesc, $foundDesc, 'Warna');
        $brandScore = $this->extractFieldScore($lostDesc, $foundDesc, 'Merek');
        $locationScore = $this->extractFieldScore($lostDesc, $foundDesc, 'Lokasi');

        $score = (int) round(($overlapRatio * 0.4) + ($colorScore * 0.2) + ($brandScore * 0.2) + ($locationScore * 0.1) + 10);
        $score = min(95, max(5, $score));

        $reasons = [];
        if ($colorScore > 60) $reasons[] = 'warna cocok';
        if ($brandScore > 60) $reasons[] = 'merek sesuai';
        if ($locationScore > 60) $reasons[] = 'lokasi berdekatan';
        $reasonText = count($reasons) > 0
            ? 'Analisis algoritmik mendeteksi kesamaan: ' . implode(', ', $reasons) . '.'
            : 'Kesamaan terbatas berdasarkan analisis kata kunci deskripsi.';

        return [
            'available' => true,
            'score' => $score,
            'reason' => $reasonText . ' (Aktifkan OpenRouter API key untuk analisis AI yang lebih akurat.)',
            'color_match' => $colorScore,
            'brand_match' => $brandScore,
            'location_match' => $locationScore,
            'time_match' => max(0, min(100, $overlapRatio + 10)),
        ];
    }

    /**
     * Extract and compare a specific field value between two descriptions.
     */
    protected function extractFieldScore(string $lostDesc, string $foundDesc, string $field): int
    {
        preg_match('/' . preg_quote($field, '/') . '[:\s]+([^,\n]+)/ui', $lostDesc, $lostMatch);
        preg_match('/' . preg_quote($field, '/') . '[:\s]+([^,\n]+)/ui', $foundDesc, $foundMatch);

        $lostVal = mb_strtolower(trim($lostMatch[1] ?? ''));
        $foundVal = mb_strtolower(trim($foundMatch[1] ?? ''));

        if (empty($lostVal) || empty($foundVal) || $lostVal === '-' || $foundVal === '-') {
            return 50; // neutral when field not available
        }
        if ($lostVal === $foundVal) return 100;
        if (str_contains($foundVal, $lostVal) || str_contains($lostVal, $foundVal)) return 80;

        // Word overlap between field values
        $lWords = array_filter(preg_split('/\s+/', $lostVal));
        $fWords = array_filter(preg_split('/\s+/', $foundVal));
        $common = count(array_intersect($lWords, $fWords));
        $total = max(count($lWords), count($fWords), 1);
        return min(75, (int) round(($common / $total) * 100));
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
