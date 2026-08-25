<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\AiDescriptionLog;
use App\Models\FoundItem;
use App\Models\ActivityLog;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiAutoDescController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $draftItem = FoundItem::with('category')->find(session('found_item_id'));
        return view('pages.admin.ai-auto-desc.index', compact('categories', 'draftItem'));
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'color' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'location_found' => ['required', 'string', 'max:255'],
            'date_found' => ['required', 'date'],
            'storage_location' => ['nullable', 'string', 'max:255'],
            'style' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
        $title = $data['title'];
        $category = Category::findOrFail($data['category_id'])->name;
        $color = $data['color'] ?? '';
        $style = $data['style'];

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = '/storage/' . $request->file('image')->store('found-items', 'public');
        }

        $result = $this->aiService->generateAutoDescription(
            $title,
            $category,
            $color,
            $style,
            $imagePath,
            '',
            (string) ($data['brand'] ?? '')
        );

        $latestItem = FoundItem::latest('id')->first();
        $nextNumber = $latestItem ? $latestItem->id + 1 : 1;
        $foundItem = FoundItem::create([
            'ref_code' => '#TF-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
            'title' => $title,
            'category_id' => $data['category_id'],
            'description' => $result['description'],
            'color' => $color,
            'brand' => $data['brand'] ?? $result['detected_brand'],
            'location_found' => $data['location_found'],
            'date_found' => $data['date_found'],
            'storage_location' => $data['storage_location'] ?? null,
            'image_path' => $imagePath,
            'status' => 'active',
        ]);

        AiDescriptionLog::create([
            'found_item_id' => $foundItem->id,
            'prompt' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'response' => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);
        ActivityLog::create(['user_id' => Auth::id(), 'activity' => 'AI Auto Description', 'details' => "Generate deskripsi untuk barang baru {$foundItem->ref_code}."]);

        return redirect()->route('admin.ai-auto-desc.index')
            ->with('aiData', $result)
            ->with('found_item_id', $foundItem->id)
            ->with('success', 'Deskripsi Vision AI berhasil di-generate secara otomatis via OpenRouter API.')
            ->withInput();
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'found_item_id' => ['required', 'exists:found_items,id'],
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'color' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
        ]);

        $item = FoundItem::findOrFail($data['found_item_id']);
        $item->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'color' => $data['color'] ?? null,
            'brand' => $data['brand'] ?? null,
            'description' => $data['description'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Simpan AI Auto Description',
            'details' => "Memperbarui deskripsi barang temuan {$item->ref_code}.",
        ]);

        return redirect()->route('admin.found-items.index')
            ->with('success', "Deskripsi barang {$item->ref_code} berhasil disimpan ke katalog.");
    }
}
