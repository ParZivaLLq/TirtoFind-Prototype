<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.claims.index');
    }

    public function approve(Request $request, int $id)
    {
        return redirect()->route('admin.claims.index')->with('success', 'Permohonan klaim disetujui.');
    }

    public function reject(Request $request, int $id)
    {
        return redirect()->route('admin.claims.index')->with('success', 'Permohonan klaim ditolak.');
    }
}
