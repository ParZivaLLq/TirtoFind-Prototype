<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['foundItems', 'lostReports'])
            ->orderBy('name', 'asc')
            ->get();
        return view('pages.admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Tambah Kategori',
            'details' => "Menambahkan kategori baru: {$category->name}.",
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
        ]);

        $oldName = $category->name;
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Edit Kategori',
            'details' => "Mengubah nama kategori dari '{$oldName}' menjadi '{$category->name}'.",
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $category = Category::withCount(['foundItems', 'lostReports'])->findOrFail($id);

        if ($category->found_items_count > 0 || $category->lost_reports_count > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori ini tidak dapat dihapus karena masih memiliki barang temuan atau laporan kehilangan aktif.');
        }

        $categoryName = $category->name;
        $category->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Hapus Kategori',
            'details' => "Menghapus kategori: {$categoryName}.",
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
