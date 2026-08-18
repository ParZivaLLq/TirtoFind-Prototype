<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display contact and location info page.
     */
    public function __invoke(Request $request)
    {
        return view('pages.public.contact');
    }
}
