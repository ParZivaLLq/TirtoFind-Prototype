<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;

class AiAutoDescController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(Request $request)
    {
        return view('pages.admin.ai-auto-desc.index');
    }

    public function generate(Request $request)
    {
        $title = $request->input('title', 'Dompet Kulit Pria Imperial Horse');
        $category = $request->input('category', 'Tas & Dompet');
        $color = $request->input('color', 'Hitam');
        $style = $request->input('style', 'Standar Katalog TirtoFind');

        $result = $this->aiService->generateAutoDescription($title, $category, $color, $style);

        return redirect()->route('admin.ai-auto-desc.index')
            ->with('aiData', $result)
            ->with('success', 'Deskripsi Vision AI berhasil di-generate secara otomatis via OpenRouter API.');
    }
}
