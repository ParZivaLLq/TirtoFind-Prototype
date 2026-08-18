<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    /**
     * Display found items gallery.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category', 'all');
        $location = $request->input('location', 'all');

        return view('pages.public.found-items', compact('query', 'category', 'location'));
    }

    /**
     * Display item detail.
     */
    public function show(int $id)
    {
        return view('pages.public.item-detail', ['id' => $id]);
    }
}
