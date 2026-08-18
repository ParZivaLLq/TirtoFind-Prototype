<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.analytics.index');
    }

    public function export(Request $request)
    {
        return redirect()->route('admin.analytics.index')->with('success', 'Laporan berhasil di-export.');
    }
}
