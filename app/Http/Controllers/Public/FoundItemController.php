<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    /**
     * Display found items gallery.
     */
    public function index(Request $request)
    {
        $queryStr = $request->input('q');
        $categorySlug = $request->input('category', 'all');

        $itemsQuery = FoundItem::with('category')->where('status', 'active');

        if ($queryStr) {
            $itemsQuery->where(function($q) use ($queryStr) {
                $q->where('title', 'like', "%{$queryStr}%")
                  ->orWhere('description', 'like', "%{$queryStr}%")
                  ->orWhere('ref_code', 'like', "%{$queryStr}%")
                  ->orWhere('location_found', 'like', "%{$queryStr}%");
            });
        }

        if ($categorySlug !== 'all' && !empty($categorySlug)) {
            $itemsQuery->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)->orWhere('name', $categorySlug);
            });
        }

        $items = $itemsQuery->orderBy('date_found', 'desc')->get();
        $categories = Category::all();

        return view('pages.public.found-items', compact('items', 'categories', 'queryStr', 'categorySlug'));
    }

    /**
     * Display item detail.
     */
    public function show(int $id)
    {
        $item = FoundItem::with('category')->findOrFail($id);
        return view('pages.public.item-detail', compact('item', 'id'));
    }
}
