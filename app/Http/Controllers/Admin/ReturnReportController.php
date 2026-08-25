<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ReturnReportController extends Controller
{
    public function index(Request $request)
    {
        $queryStr = $request->input('q');

        $query = Claim::with(['foundItem.category', 'lostReport'])
            ->where('status', 'Disetujui');

        if ($queryStr) {
            $query->where(function($q) use ($queryStr) {
                $q->where('claimant_name', 'like', "%{$queryStr}%")
                  ->orWhere('claim_code', 'like', "%{$queryStr}%")
                  ->orWhereHas('foundItem', function($subQ) use ($queryStr) {
                      $subQ->where('title', 'like', "%{$queryStr}%")
                           ->orWhere('ref_code', 'like', "%{$queryStr}%");
                  });
            });
        }

        $reports = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('pages.admin.return-report.index', compact('reports', 'queryStr'));
    }

    public function print(int $id)
    {
        $claim = Claim::with(['foundItem.category', 'lostReport'])
            ->where('status', 'Disetujui')
            ->findOrFail($id);

        return view('pages.admin.return-report.print', compact('claim'));
    }
}
