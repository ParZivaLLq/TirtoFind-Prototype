<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard overview.
     */
    public function __invoke(Request $request)
    {
        return view('pages.admin.dashboard');
    }
}
