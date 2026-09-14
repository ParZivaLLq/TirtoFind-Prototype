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
     * Auto generate catalog description using OpenRouter Vision Cataloging Engine.
     */
    public function generateAutoDescription(string $title, string $category, string $color = '', string $style = 'Standar Katalog TirtoFind', ?string $imagePath = null, string $existingDescription = '', string $brand = ''): array
    {
        $systemPrompt = "Anda adalah \"Vision Cataloging Engine\" untuk sistem Lost and Found kelas enterprise TirtoFind Terminal Tirtonadi. Tugas Anda adalah menganalisis data masukan pengguna (yang dapat berupa teks parsial dan/atau gambar/foto barang) untuk menormalisasi atribut dan menghasilkan deskripsi katalog yang profesional.\n\n" .
            "1. ATURAN ANALISIS & EKSTRAKSI MULTIMODAL\n" .
            "- Analisis Gambar (jika tersedia): Perhatikan bentuk fisik, warna dominan, logo/merek, kondisi fisik (lecet/mulus), dan detail unik pada foto.\n" .
            "- Validasi Silang Teks & Gambar: Jika input teks menyebutkan \"Samsung\" tetapi foto menunjukkan logo \"Apple\", prioritaskan bukti visual dari gambar atau gabungkan secara logis (misal: casing atau perangkat).\n" .
            "- Koreksi & Standardisasi: Bersihkan typo, standarisasikan nama merek, dan tentukan Kategori yang paling akurat dari daftar kategori standar sistem.\n\n" .
            "2. GAYA FORMAT DESKRIPSI (BERDASARKAN PILIHAN USER)\n" .
            "Sesuaikan format paragraf hasil deskripsi (professional_description) dengan opsi gaya format yang dipilih:\n" .
            "- Jika \"Standar Katalog TirtoFind\": Gunakan format formal, terstruktur, menyebutkan jenis barang, warna, merek, kondisi fisik, dan ciri khas secara padat dalam 1-2 paragraf.\n" .
            "- Jika gaya lain: Sesuaikan dengan nada profesional, deskriptif, dan ready-to-publish.\n\n" .
            "3. FORMAT OUTPUT JSON MURNI\n" .
            "Keluarkan respons HANYA dalam format JSON valid berikut (tanpa teks pembuka atau penutup):\n" .
            "{\n" .
            "  \"catalog_title\": \"[Judul katalog yang rapi dan deskriptif, contoh: Dompet Kulit Eiger Coklat Tua]\",\n" .
            "  \"extracted_category\": \"[Kategori final yang paling sesuai, misal: Tas & Dompet, Elektronik & HP, dll]\",\n" .
            "  \"extracted_color\": \"[Warna utama yang terdeteksi secara akurat, misal: Coklat Tua, Biru Metallic]\",\n" .
            "  \"extracted_brand\": \"[Merek/Brand yang terdeteksi, atau '-' jika tidak ada]\",\n" .
            "  \"professional_description\": \"[Teks deskripsi lengkap hasil sintesis teks dan gambar yang rapi, profesional, dan siap masuk database katalog]\"\n" .
            "}";

        $prompt = "Analisis dan buatkan deskripsi katalog barang temuan berdasarkan masukan berikut:\n" .
            "- Input Nama Barang: {$title}\n" .
            "- Input Kategori: {$category}\n" .
            "- Input Warna: " . ($color ?: '-') . "\n" .
            "- Input Merek: " . ($brand ?: '-') . "\n" .
            "- Catatan Ciri Khusus / Deskripsi: " . ($existingDescription ?: '-') . "\n" .
            "- Gaya Format: {$style}";

        $aiResult = $this->askAiWithImage($prompt, $systemPrompt, $imagePath);

        if ($aiResult) {
            $json = json_decode($this->cleanJsonResponse($aiResult), true);
            if (is_array($json)) {
                $description = trim((string) ($json['professional_description'] ?? ($json['description'] ?? '')));
                if (!empty($description)) {
                    return [
                        'available' => true,
                        'catalog_title' => $json['catalog_title'] ?? $title,
                        'description' => $description,
                        'professional_description' => $description,
                        'detected_category' => $json['extracted_category'] ?? ($json['detected_category'] ?? $category),
                        'detected_color' => $json['extracted_color'] ?? ($json['detected_color'] ?? $color),
                        'detected_brand' => $json['extracted_brand'] ?? ($json['detected_brand'] ?? ($brand ?: '-')),
                    ];
                }
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
            'catalog_title' => $title,
            'description' => $fallback,
            'professional_description' => $fallback,
            'detected_category' => $category,
            'detected_color' => $color ?: '-',
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
     * Uses strict Core Matching Kernel evaluation.
     */
    public function matchItems(string $lostDescription, string $foundDescription): ?array
    {
        $systemPrompt = "Anda adalah Core Matching Kernel untuk sistem Lost and Found tingkat enterprise TirtoFind Terminal Tirtonadi. Tugas Anda adalah melakukan evaluasi silang secara sangat ketat antara Laporan Kehilangan dan Laporan Temuan. Anda dilarang memberikan skor toleransi atau asal tebak jika logika dasar tidak terpenuhi.\n\n" .
            "1. TAHAP 1: ZERO-TOLERANCE HARD FILTERS (KONDISI DISKUALIFIKASI MUTLAK)\n" .
            "Evaluasi dua kondisi ini terlebih dahulu. Jika salah satu kondisi di bawah TRUE, match_score WAJIB 0, recommendation WAJIB 'Reject':\n" .
            "a) Anomali Waktu: Apakah [Waktu Temu] terjadi SEBELUM [Waktu Hilang]? Jika Ya -> DISKUALIFIKASI (skor 0).\n" .
            "b) Konflik Kategori Mutlak: Apakah Kategori Utama objek berada di domain yang mustahil sama? (misal: Elektronik/HP vs Dompet/Pakaian/Tas). Jika Ya -> DISKUALIFIKASI (skor 0).\n\n" .
            "2. TAHAP 2: MATRIKS BOBOT PARAMETER & PENALTI (Hanya jika lolos Tahap 1)\n" .
            "- Kategori & Sub-Kategori (Bobot Maks: 25%): 25% jika identik persis, 10% jika 1 kategori umum tp sub-kategori meragukan, 0% jika berbeda.\n" .
            "- Atribut Visual Utama - Warna & Merek (Bobot Maks: 30%): Merek spesifik dan berbeda (misal Eiger vs Exsport, Samsung vs iPhone) -> PENALTI MUTLAK (skor merek = 0). Warna bertolak belakang mutlak (misal Biru vs Merah/Abu) -> PENALTI MUTLAK (skor warna = 0). Warna cocok parsial -> nilai proporsional (max 15%).\n" .
            "- Atribut Spesifik / Ciri Unik (Bobot Maks: 20%): Cocok spesifik (IMEI, nama pemilik, wallpaper, goresan unik) = 20%. Tidak ada ciri unik = 0%.\n" .
            "- Kedekatan Lokasi Spasial (Bobot Maks: 15%): Lokasi sama/gate berdekatan = 15%, 1 area besar beda zona = 5%, beda lokasi jauh = 0%.\n" .
            "- Jarak Waktu / Temporal (Bobot Maks: 10%): Waktu temu <3 jam setelah hilang = 10%, <24 jam = 5%, >3 hari = 0%.\n\n" .
            "3. TAHAP 3: REKOMENDASI\n" .
            "- Skor 85-100: Auto-Match\n" .
            "- Skor 50-84: Manual Verification Needed\n" .
            "- Skor 1-49: Low Match / Review\n" .
            "- Skor 0: Reject\n\n" .
            "Berikan respon JSON murni:\n" .
            "{\n" .
            "  \"score\": <total_skor_0_sampai_100>,\n" .
            "  \"reason\": \"Alasan evaluasi dalam 1 kalimat Bahasa Indonesia\",\n" .
            "  \"color_match\": <skor_warna_0_sampai_100>,\n" .
            "  \"brand_match\": <skor_merek_0_sampai_100>,\n" .
            "  \"location_match\": <skor_lokasi_0_sampai_100>,\n" .
            "  \"time_match\": <skor_waktu_0_sampai_100>\n" .
            "}";

        $prompt = "Bandingkan dua data berikut:\n" .
            "Laporan Kehilangan: \"{$lostDescription}\"\n" .
            "Barang Temuan: \"{$foundDescription}\"";

        $aiResult = $this->askAi($prompt, $systemPrompt);

        if ($aiResult) {
            $json = json_decode($this->cleanJsonResponse($aiResult), true);
            if (isset($json['score']) && is_numeric($json['score'])) {
                return [
                    'available' => true,
                    'score' => (int) $json['score'],
                    'reason' => $json['reason'] ?? 'Evaluasi berbasis Core Matching Kernel.',
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
     * Fallback: Strict Core Matching Kernel Algorithmic Evaluation.
     */
    protected function algorithmicMatch(string $lostDesc, string $foundDesc): array
    {
        // 1. HARD FILTERS (ZERO-TOLERANCE)
        $lostCategory = $this->extractValue($lostDesc, 'Kategori');
        $foundCategory = $this->extractValue($foundDesc, 'Kategori');
        
        $lostDateStr = $this->extractValue($lostDesc, 'Waktu') ?: $this->extractValue($lostDesc, 'Tanggal');
        $foundDateStr = $this->extractValue($foundDesc, 'Ditemukan') ?: $this->extractValue($foundDesc, 'Waktu');

        // Check Hard Filter 1: Category Conflict (e.g. Elektronik vs Tas & Dompet)
        if ($lostCategory && $foundCategory && $lostCategory !== '-' && $foundCategory !== '-') {
            if (mb_strtolower($lostCategory) !== mb_strtolower($foundCategory)) {
                return [
                    'available' => true,
                    'score' => 0,
                    'reason' => "DISKUALIFIKASI MUTLAK: Konflik Kategori Utama ('{$lostCategory}' vs '{$foundCategory}').",
                    'color_match' => 0,
                    'brand_match' => 0,
                    'location_match' => 0,
                    'time_match' => 0,
                ];
            }
        }

        // Check Hard Filter 2: Chronological Paradox (Found BEFORE Lost)
        if ($lostDateStr && $foundDateStr) {
            try {
                $lostTime = \Carbon\Carbon::parse($lostDateStr);
                $foundTime = \Carbon\Carbon::parse($foundDateStr);
                
                // If item found strictly before lost date (difference > 1 hour margin for clock inaccuracy)
                if ($foundTime->lt($lostTime->subHour())) {
                    return [
                        'available' => true,
                        'score' => 0,
                        'reason' => "DISKUALIFIKASI MUTLAK: Anomali Waktu! Barang ditemukan ({$foundTime->format('d M Y')}) SEBELUM tanggal dilaporkan hilang ({$lostTime->format('d M Y')}).",
                        'color_match' => 0,
                        'brand_match' => 0,
                        'location_match' => 0,
                        'time_match' => 0,
                    ];
                }
            } catch (\Exception $e) {
                // Ignore parse errors in fallback
            }
        }

        // 2. WEIGHT MATRIX CALCULATION (If Hard Filters passed)
        // A. Category (Max 25%)
        $catScore = ($lostCategory && $foundCategory && mb_strtolower($lostCategory) === mb_strtolower($foundCategory)) ? 25 : 10;

        // B. Visual Attributes - Color & Brand (Max 30%)
        $lostColor = mb_strtolower($this->extractValue($lostDesc, 'Warna'));
        $foundColor = mb_strtolower($this->extractValue($foundDesc, 'Warna'));
        $lostBrand = mb_strtolower($this->extractValue($lostDesc, 'Merek'));
        $foundBrand = mb_strtolower($this->extractValue($foundDesc, 'Merek'));

        $colorScore = 0;
        if (!empty($lostColor) && !empty($foundColor) && $lostColor !== '-' && $foundColor !== '-') {
            if ($lostColor === $foundColor) {
                $colorScore = 15;
            } elseif (str_contains($foundColor, $lostColor) || str_contains($lostColor, $foundColor)) {
                $colorScore = 10;
            } else {
                // Mutually exclusive color penalty
                $colorScore = 0;
            }
        } else {
            $colorScore = 5; // Neutral
        }

        $brandScore = 0;
        if (!empty($lostBrand) && !empty($foundBrand) && $lostBrand !== '-' && $foundBrand !== '-') {
            if ($lostBrand === $foundBrand) {
                $brandScore = 15;
            } else {
                // Conflicting brands penalty
                $brandScore = 0;
            }
        } else {
            $brandScore = 5; // Neutral
        }
        $visualScore = $colorScore + $brandScore;

        // C. Specific Unique Features (Max 20%)
        $lostFeature = mb_strtolower($this->extractValue($lostDesc, 'Ciri Khusus') ?: $this->extractValue($lostDesc, 'Deskripsi'));
        $foundFeature = mb_strtolower($this->extractValue($foundDesc, 'Deskripsi') ?: $this->extractValue($foundDesc, 'Ciri Khusus'));
        $uniqueScore = 0;
        if ($lostFeature && $foundFeature && $lostFeature !== '-' && $foundFeature !== '-') {
            if (str_contains($foundFeature, $lostFeature) || str_contains($lostFeature, $foundFeature)) {
                $uniqueScore = 20;
            } else {
                $lWords = array_filter(preg_split('/\s+/', $lostFeature));
                $fWords = array_filter(preg_split('/\s+/', $foundFeature));
                $common = count(array_intersect($lWords, $fWords));
                $uniqueScore = $common > 0 ? min(15, $common * 5) : 0;
            }
        }

        // D. Location Proximity (Max 15%)
        $lostLoc = mb_strtolower($this->extractValue($lostDesc, 'Lokasi Hilang') ?: $this->extractValue($lostDesc, 'Lokasi'));
        $foundLoc = mb_strtolower($this->extractValue($foundDesc, 'Lokasi Temu') ?: $this->extractValue($foundDesc, 'Lokasi'));
        $locationScore = 0;
        if ($lostLoc && $foundLoc && $lostLoc !== '-' && $foundLoc !== '-') {
            if ($lostLoc === $foundLoc) {
                $locationScore = 15;
            } elseif (str_contains($foundLoc, $lostLoc) || str_contains($lostLoc, $foundLoc)) {
                $locationScore = 10;
            } else {
                $locationScore = 5;
            }
        }

        // E. Temporal Distance (Max 10%)
        $timeScore = 5;
        if (isset($lostTime) && isset($foundTime)) {
            $diffHours = $lostTime->diffInHours($foundTime, false);
            if ($diffHours >= 0 && $diffHours <= 3) {
                $timeScore = 10;
            } elseif ($diffHours > 3 && $diffHours <= 24) {
                $timeScore = 5;
            } else {
                $timeScore = 0;
            }
        }

        $totalScore = (int) round($catScore + $visualScore + $uniqueScore + $locationScore + $timeScore);
        $totalScore = max(0, min(100, $totalScore));

        $reason = "Kategori sama ({$catScore}%), visual ({$visualScore}%), lokasi ({$locationScore}%), waktu ({$timeScore}%).";

        return [
            'available' => true,
            'score' => $totalScore,
            'reason' => "Core Kernel: {$reason}",
            'color_match' => (int) round(($colorScore / 15) * 100),
            'brand_match' => (int) round(($brandScore / 15) * 100),
            'location_match' => (int) round(($locationScore / 15) * 100),
            'time_match' => (int) round(($timeScore / 10) * 100),
        ];
    }

    /**
     * Extract field value from structured string format "Key: Value".
     */
    protected function extractValue(string $text, string $key): string
    {
        if (preg_match('/' . preg_quote($key, '/') . '[:\s]+([^,\n]+)/ui', $text, $matches)) {
            return trim($matches[1]);
        }
        return '';
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
