<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search interface and query database.
     */
    public function __invoke(Request $request)
    {
        $q = $request->input('q');
        $categorySlug = $request->input('category', 'all');
        $location = $request->input('location', 'all');
        $date = $request->input('date');

        $itemsQuery = FoundItem::with('category')->where('status', 'active');

        if ($q) {
            $itemsQuery->where(function($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%")
                      ->orWhere('ref_code', 'like', "%{$q}%")
                      ->orWhere('color', 'like', "%{$q}%")
                      ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        if ($categorySlug !== 'all' && !empty($categorySlug)) {
            $itemsQuery->whereHas('category', function($query) use ($categorySlug) {
                $query->where('slug', $categorySlug)->orWhere('name', $categorySlug);
            });
        }

        if ($location !== 'all' && !empty($location)) {
            $itemsQuery->where('location_found', 'like', "%{$location}%");
        }

        if ($date) {
            $itemsQuery->whereDate('date_found', $date);
        }

        $items = $itemsQuery->orderBy('date_found', 'desc')->get();
        $categories = Category::all();

        return view('pages.public.search', compact('items', 'categories', 'q', 'categorySlug', 'location', 'date'));
    }
}
