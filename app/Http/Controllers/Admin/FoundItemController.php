<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.found-items.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.found-items.index')->with('success', 'Barang temuan berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        return redirect()->route('admin.found-items.index')->with('success', 'Data barang temuan diperbarui.');
    }

    public function destroy(int $id)
    {
        return redirect()->route('admin.found-items.index')->with('success', 'Barang temuan berhasil dihapus.');
    }
}
