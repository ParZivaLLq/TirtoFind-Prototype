<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\LostReport;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function __invoke(Request $request)
    {
        $totalFound = FoundItem::count();
        $totalClaimed = FoundItem::where('status', 'claimed')->count();
        $totalLost = LostReport::count();

        // 3 recent found items (active status)
        $recentItems = FoundItem::with('category')
            ->where('status', 'active')
            ->orderBy('date_found', 'desc')
            ->take(3)
            ->get();

        return view('pages.public.home', compact('totalFound', 'totalClaimed', 'totalLost', 'recentItems'));
    }
}
