<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\LostReport;
use App\Models\Claim;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard overview.
     */
    public function __invoke(Request $request)
    {
        $stats = [
            'total_found' => FoundItem::count(),
            'active_found' => FoundItem::where('status', 'active')->count(),
            'claimed_found' => FoundItem::where('status', 'claimed')->count(),
            'total_lost' => LostReport::count(),
            'pending_lost' => LostReport::where('status', 'Menunggu Verifikasi')->count(),
            'pending_claims' => Claim::where('status', 'Menunggu Verifikasi')->count(),
        ];

        $recentFound = FoundItem::with('category')->latest()->take(5)->get();
        $recentLost = LostReport::with('category')->latest()->take(5)->get();
        $recentClaims = Claim::with('foundItem')->latest()->take(5)->get();
        $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return view('pages.admin.dashboard', compact('stats', 'recentFound', 'recentLost', 'recentClaims', 'activityLogs'));
    }
}
