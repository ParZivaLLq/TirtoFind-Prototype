<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display about page.
     */
    public function __invoke(Request $request)
    {
        return view('pages.public.about');
    }
}
