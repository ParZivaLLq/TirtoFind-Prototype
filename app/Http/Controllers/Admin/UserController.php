<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.users.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.users.index')->with('success', 'Petugas admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        return redirect()->route('admin.users.index')->with('success', 'Data petugas admin diperbarui.');
    }

    public function destroy(int $id)
    {
        return redirect()->route('admin.users.index')->with('success', 'Petugas admin dihapus.');
    }
}
