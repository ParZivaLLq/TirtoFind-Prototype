<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display realtime search interface.
     */
    public function __invoke(Request $request)
    {
        return view('pages.public.search');
    }
}
