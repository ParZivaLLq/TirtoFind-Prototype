<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FoundItemController extends Controller
{
    public function index(Request $request)
    {
        $queryStr = $request->input('q');
        $categoryFilter = $request->input('category');
        $statusFilter = $request->input('status');

        $query = FoundItem::with('category');

        if ($queryStr) {
            $query->where(function($q) use ($queryStr) {
                $q->where('title', 'like', "%{$queryStr}%")
                  ->orWhere('ref_code', 'like', "%{$queryStr}%")
                  ->orWhere('location_found', 'like', "%{$queryStr}%")
                  ->orWhere('description', 'like', "%{$queryStr}%");
            });
        }

        if ($categoryFilter) {
            $query->whereHas('category', function($q) use ($categoryFilter) {
                $q->where('name', $categoryFilter);
            });
        }

        if ($statusFilter) {
            if ($statusFilter === 'Disimpan (Brankas)') {
                $query->where('status', 'active');
            } elseif ($statusFilter === 'Dikembalikan (Claimed)') {
                $query->where('status', 'claimed');
            } elseif ($statusFilter === 'Diarsipkan') {
                $query->where('status', 'archived');
            }
        }

        $items = $query->orderBy('date_found', 'desc')->paginate(10);
        $categories = Category::all();

        return view('pages.admin.found-items.index', compact('items', 'categories', 'queryStr', 'categoryFilter', 'statusFilter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_found' => ['required', 'string', 'max:255'],
            'date_found' => ['required', 'date'],
            'color' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'storage_location' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('found-items', 'public');
        }

        // Generate Ref Code: #TF-YYYY-XXXX
        $latestItem = FoundItem::latest('id')->first();
        $nextNumber = $latestItem ? ($latestItem->id + 1) : 1;
        $refCode = '#TF-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $item = FoundItem::create([
            'ref_code' => $refCode,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'location_found' => $request->location_found,
            'date_found' => $request->date_found,
            'color' => $request->color,
            'brand' => $request->brand,
            'storage_location' => $request->storage_location,
            'description' => $request->description,
            'image_path' => $imagePath ? '/storage/' . $imagePath : 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800',
            'status' => 'active',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Tambah Barang Temuan',
            'details' => "Mencatat barang temuan baru: {$item->title} ({$refCode}).",
        ]);

        return redirect()->route('admin.found-items.index')->with('success', 'Barang temuan berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $item = FoundItem::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_found' => ['required', 'string', 'max:255'],
            'date_found' => ['required', 'date'],
            'color' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'storage_location' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['active', 'claimed', 'archived'])],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $item->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if it is local public
            if ($item->image_path && strpos($item->image_path, '/storage/') === 0) {
                $oldPath = str_replace('/storage/', '', $item->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $newFile = $request->file('image')->store('found-items', 'public');
            $imagePath = '/storage/' . $newFile;
        }

        $item->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'location_found' => $request->location_found,
            'date_found' => $request->date_found,
            'color' => $request->color,
            'brand' => $request->brand,
            'storage_location' => $request->storage_location,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Edit Barang Temuan',
            'details' => "Mengubah rincian barang temuan: {$item->title} ({$item->ref_code}).",
        ]);

        return redirect()->route('admin.found-items.index')->with('success', 'Data barang temuan diperbarui.');
    }

    public function destroy(int $id)
    {
        $item = FoundItem::findOrFail($id);

        // Delete image if local public
        if ($item->image_path && strpos($item->image_path, '/storage/') === 0) {
            $oldPath = str_replace('/storage/', '', $item->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $title = $item->title;
        $refCode = $item->ref_code;
        $item->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Hapus Barang Temuan',
            'details' => "Menghapus data barang temuan: {$title} ({$refCode}).",
        ]);

        return redirect()->route('admin.found-items.index')->with('success', 'Barang temuan berhasil dihapus.');
    }
}
