<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('name')->get();
        return view('pages.admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nip' => ['nullable', 'string', 'max:50', 'unique:users,nip'],
            'role' => ['required', 'in:super_admin,cs,petugas'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        ActivityLog::create(['user_id' => Auth::id(), 'activity' => 'Tambah Pengguna', 'details' => "Menambahkan pengguna {$user->email}."]);
        return redirect()->route('admin.users.index')->with('success', 'Petugas admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'nip' => ['nullable', 'string', 'max:50', 'unique:users,nip,' . $id],
            'role' => ['required', 'in:super_admin,cs,petugas'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        ActivityLog::create(['user_id' => Auth::id(), 'activity' => 'Edit Pengguna', 'details' => "Mengubah pengguna {$user->email}."]);
        return redirect()->route('admin.users.index')->with('success', 'Data petugas admin diperbarui.');
    }

    public function destroy(int $id)
    {
        abort_if(Auth::id() === $id, 422, 'Akun yang sedang digunakan tidak dapat dihapus.');
        $user = User::findOrFail($id);
        $email = $user->email;
        $user->delete();
        ActivityLog::create(['user_id' => Auth::id(), 'activity' => 'Hapus Pengguna', 'details' => "Menghapus pengguna {$email}."]);
        return redirect()->route('admin.users.index')->with('success', 'Petugas admin dihapus.');
    }
}
