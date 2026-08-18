<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LostReportController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.lost-reports.index');
    }

    public function show(int $id)
    {
        return view('pages.admin.lost-reports.index');
    }

    public function updateStatus(Request $request, int $id)
    {
        return redirect()->route('admin.lost-reports.index')->with('success', 'Status laporan kehilangan diperbarui.');
    }
}
