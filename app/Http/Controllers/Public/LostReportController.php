<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LostReport;
use App\Models\Category;
use App\Models\FoundItem;
use App\Models\AiMatchingLog;
use App\Jobs\MatchLostReportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LostReportController extends Controller
{
    /**
     * Show lost report form.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.public.lost-report', compact('categories'));
    }

    /**
     * Handle lost report submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'reporter_phone' => ['required', 'string', 'max:50'],
            'reporter_id_type' => ['required', 'string', 'max:50'],
            'reporter_id_number' => ['required', 'string', 'max:50'],
            'item_name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_lost' => ['required', 'string', 'max:255'],
            'date_lost' => ['required', 'date'],
            'color' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'distinctive_features' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('lost-reports', 'public');
            }

            // Generate report code: #LR-YYYY-XXXX
            $latestReport = LostReport::latest('id')->first();
            $nextNumber = $latestReport ? ($latestReport->id + 1) : 1;
            $reportCode = '#LR-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $lostReport = LostReport::create([
                'report_code' => $reportCode,
                'category_id' => $request->category_id,
                'reporter_name' => $request->reporter_name,
                'reporter_phone' => $request->reporter_phone,
                'reporter_id_type' => $request->reporter_id_type,
                'reporter_id_number' => $request->reporter_id_number,
                'item_name' => $request->item_name,
                'color' => $request->color,
                'brand' => $request->brand,
                'location_lost' => $request->location_lost,
                'date_lost' => $request->date_lost,
                'distinctive_features' => $request->distinctive_features,
                'image_path' => $imagePath ? '/storage/' . $imagePath : null,
                'status' => 'Menunggu Verifikasi',
            ]);

            DB::commit();

            MatchLostReportJob::dispatch($lostReport)->afterCommit();

            return redirect()->route('lost-report')
                ->with('success', "Laporan kehilangan berhasil dikirim! Kode Laporan Anda: {$reportCode}. Silakan simpan kode ini untuk keperluan klaim.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lost Report Store Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba beberapa saat lagi.')->withInput();
        }
    }
}
