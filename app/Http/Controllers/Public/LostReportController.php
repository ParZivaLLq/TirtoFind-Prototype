<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LostReportController extends Controller
{
    /**
     * Show lost report form.
     */
    public function create()
    {
        return view('pages.public.lost-report');
    }

    /**
     * Handle lost report submission.
     */
    public function store(Request $request)
    {
        // Handle form submission logic
        return redirect()->route('lost-report')->with('success', 'Laporan kehilangan berhasil dikirim!');
    }
}
