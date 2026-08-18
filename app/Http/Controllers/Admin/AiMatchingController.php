<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;

class AiMatchingController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(Request $request)
    {
        return view('pages.admin.ai-matching.index');
    }

    public function match(Request $request)
    {
        $lostDesc = $request->input('lost_desc', 'Dompet lipat dua warna hitam kulit, ada kartu e-money mandiri dan KTP atas nama Budi Santoso.');
        $foundDesc = $request->input('found_desc', 'Dompet kulit pria warna hitam merk Imperial Horse berisi kartu E-Money diserahkan dari Platform 4.');

        $matchResult = $this->aiService->matchItems($lostDesc, $foundDesc);

        return redirect()->route('admin.ai-matching.index')
            ->with('matchResult', $matchResult)
            ->with('success', "Proses AI Smart Matching selesai via OpenRouter. Skor kecocokan: {$matchResult['score']}%.");
    }
}
