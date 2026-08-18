<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReturnReportController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.return-report.index');
    }

    public function print(int $id)
    {
        return view('pages.admin.return-report.index');
    }
}
