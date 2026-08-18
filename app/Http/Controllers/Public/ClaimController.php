<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    /**
     * Show claim submission form.
     */
    public function create(int $id = 1)
    {
        return view('pages.public.claim', ['id' => $id]);
    }

    /**
     * Handle claim submission.
     */
    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'Pengajuan klaim berhasil dikirim!');
    }
}
