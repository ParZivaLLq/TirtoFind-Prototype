<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search interface and query database using unified FoundItem scope.
     */
    public function __invoke(Request $request)
    {
        $q = $request->input('q');
        $categorySlug = $request->input('category', 'all');
        $location = $request->input('location', 'all');
        $date = $request->input('date');

        $items = FoundItem::with('category')
            ->search($q, $categorySlug, $location, $date)
            ->orderBy('date_found', 'desc')
            ->get();

        $categories = Category::all();

        return view('pages.public.search', compact('items', 'categories', 'q', 'categorySlug', 'location', 'date'));
    }
}
