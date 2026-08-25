<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from');
        $to = $request->date('to');
        $claims = Claim::query();
        $reports = LostReport::query();
        $foundItems = FoundItem::query();
        foreach ([$claims, $reports, $foundItems] as $query) {
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
        }

        $stats = [
            'found_total' => $foundItems->count(),
            'claims_verified' => (clone $claims)->where('status', 'Disetujui')->count(),
            'claims_pending' => (clone $claims)->where('status', 'Menunggu Verifikasi')->count(),
            'reports_total' => $reports->count(),
            'match_average' => round((float) \App\Models\AiMatchingLog::query()
                ->when($from, fn ($query) => $query->whereDate('created_at', '>=', $from))
                ->when($to, fn ($query) => $query->whereDate('created_at', '<=', $to))
                ->avg('score'), 1),
        ];

        $trend = $reports->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as reports'))
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');
        $claimTrend = $claims->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as claims'))
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');
        $trendDates = $trend->keys()->merge($claimTrend->keys())->unique()->sort()->values();

        return view('pages.admin.analytics.index', compact('stats', 'from', 'to', 'trend', 'claimTrend', 'trendDates'));
    }

    public function export(Request $request): StreamedResponse
    {
        $claims = Claim::with('foundItem')->latest()->get();
        ActivityLog::create(['user_id' => Auth::id(), 'activity' => 'Export Laporan', 'details' => 'Mengekspor laporan klaim operasional dalam format CSV.']);

        return response()->streamDownload(function () use ($claims): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Kode Klaim', 'Pemohon', 'Barang', 'Status', 'Dibuat']);
            foreach ($claims as $claim) {
                fputcsv($output, [$claim->claim_code, $claim->claimant_name, $claim->foundItem?->title, $claim->status, $claim->created_at?->toDateTimeString()]);
            }
            fclose($output);
        }, 'tirtofind-claims-' . now()->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv']);
    }
}
