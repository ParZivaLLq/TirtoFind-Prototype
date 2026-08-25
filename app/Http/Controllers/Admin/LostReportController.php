<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LostReport;
use App\Models\Category;
use App\Models\AiMatchingLog;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostReportController extends Controller
{
    public function index(Request $request)
    {
        $queryStr = $request->input('q');
        $categoryFilter = $request->input('category');
        $statusFilter = $request->input('status');

        $query = LostReport::with(['category', 'aiMatchingLogs' => function ($query) {
            $query->orderByDesc('score');
        }]);

        if ($queryStr) {
            $query->where(function($q) use ($queryStr) {
                $q->where('reporter_name', 'like', "%{$queryStr}%")
                  ->orWhere('report_code', 'like', "%{$queryStr}%")
                  ->orWhere('item_name', 'like', "%{$queryStr}%")
                  ->orWhere('location_lost', 'like', "%{$queryStr}%");
            });
        }

        if ($categoryFilter) {
            $query->whereHas('category', function($q) use ($categoryFilter) {
                $q->where('name', $categoryFilter);
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('pages.admin.lost-reports.index', compact('reports', 'categories', 'queryStr', 'categoryFilter', 'statusFilter'));
    }

    public function show(int $id)
    {
        $report = LostReport::with('category')->findOrFail($id);
        
        $matches = AiMatchingLog::with('foundItem.category')
            ->where('lost_report_id', $id)
            ->orderBy('score', 'desc')
            ->get();

        return view('pages.admin.lost-reports.show', compact('report', 'matches'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $report = LostReport::findOrFail($id);

        $request->validate([
            'status' => ['required', 'string', 'in:Menunggu Verifikasi,Terverifikasi,Selesai'],
        ]);

        $oldStatus = $report->status;
        $report->update(['status' => $request->status]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Status Laporan',
            'details' => "Mengubah status laporan kehilangan {$report->report_code} dari '{$oldStatus}' menjadi '{$request->status}'.",
        ]);

        return redirect()->route('admin.lost-reports.show', $id)->with('success', 'Status laporan kehilangan berhasil diperbarui.');
    }
}
