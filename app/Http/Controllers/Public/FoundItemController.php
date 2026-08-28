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
        $location = $request->input('location', 'all');
        $date = $request->input('date');

        $items = FoundItem::with('category')
            ->search($queryStr, $categorySlug, $location, $date)
            ->orderBy('date_found', 'desc')
            ->get();

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
