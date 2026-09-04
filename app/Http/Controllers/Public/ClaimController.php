<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\LostReport;
use App\Notifications\ClaimSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClaimController extends Controller
{
    /**
     * Show claim submission form.
     */
    public function create($id = null)
    {
        if (!$id) {
            return redirect()->route('found-items')->with('error', 'Silakan pilih barang temuan yang ingin diklaim terlebih dahulu.');
        }

        $item = FoundItem::with('category')->findOrFail($id);

        if ($item->status !== 'active') {
            return redirect()->route('found-items')->with('error', 'Barang ini tidak dapat diklaim karena status tidak aktif atau sudah diambil.');
        }

        return view('pages.public.claim', compact('item', 'id'));
    }

    /**
     * Handle claim submission.
     */
    public function store(Request $request, $id = null)
    {
        if (!$id) {
            $id = $request->input('found_item_id');
        }

        $item = FoundItem::findOrFail($id);

        if ($item->status !== 'active') {
            return redirect()->route('found-items')->with('error', 'Barang ini tidak dapat diklaim karena status tidak aktif atau sudah diambil.');
        }

        $request->validate([
            'claimant_name' => ['required', 'string', 'max:255'],
            'claimant_phone' => ['required', 'string', 'max:50'],
            'claimant_id_number' => ['required', 'string', 'max:50'],
            'claimant_email' => ['nullable', 'email', 'max:255'],
            'relationship' => ['required', 'string', 'max:100'],
            'reason' => ['required', 'string'],
            'distinctive_features' => ['nullable', 'string'],
            'supporting_document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'], // Max 2MB
            'lost_report_code' => ['nullable', 'string', 'max:50'],
        ]);

        try {
            DB::beginTransaction();

            // Check lost report code if provided
            $lostReport = null;
            if ($request->lost_report_code) {
                $cleanReportCode = trim($request->lost_report_code);
                $formattedReportCode = str_starts_with($cleanReportCode, '#') ? $cleanReportCode : '#' . $cleanReportCode;
                $lostReport = LostReport::where('report_code', $cleanReportCode)
                    ->orWhere('report_code', $formattedReportCode)
                    ->first();
            }

            // Generate claim code: #CL-YYYY-XXXX
            $latestClaim = Claim::latest('id')->first();
            $nextNumber = $latestClaim ? ($latestClaim->id + 1) : 1;
            $claimCode = '#CL-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Upload file
            $documentPath = null;
            if ($request->hasFile('supporting_document')) {
                $documentPath = $request->file('supporting_document')->store('claims/documents', 'local');
            }

            $claim = Claim::create([
                'claim_code' => $claimCode,
                'found_item_id' => $item->id,
                'lost_report_id' => $lostReport ? $lostReport->id : null,
                'claimant_name' => $request->claimant_name,
                'claimant_phone' => $request->claimant_phone,
                'claimant_id_number' => $request->claimant_id_number,
                'claimant_email' => $request->claimant_email,
                'relationship' => $request->relationship,
                'reason' => $request->reason,
                'distinctive_features' => $request->distinctive_features,
                'supporting_document_path' => $documentPath,
                'status' => 'Menunggu Verifikasi',
            ]);

            DB::commit();

            if ($claim->claimant_email) {
                try {
                    $claim->notify(new ClaimSubmittedNotification);
                } catch (\Exception $e) {
                    Log::warning('ClaimSubmittedNotification failed: ' . $e->getMessage());
                }
            }

            // Generate WhatsApp click-to-chat URL
            $csPhone = (string) config('services.whatsapp.cs_phone', '6281234567890');
            $message = "Halo Helpdesk Lost & Found Terminal Tirtonadi,\n\n" .
                       "Saya ingin melakukan konfirmasi pengajuan klaim barang temuan:\n" .
                       "- Kode Klaim: {$claimCode}\n" .
                       "- Nama Pemohon: {$request->claimant_name}\n" .
                       "- Nama Barang: {$item->title}\n" .
                       "- Kode Ref Barang: {$item->ref_code}\n\n" .
                       "Mohon bantuannya untuk melakukan verifikasi berkas. Terima kasih.";

            $waUrl = "https://wa.me/{$csPhone}?text=" . urlencode($message);

            return redirect()->route('claim', $item->id)
                ->with('success', "Permohonan klaim berhasil dikirim dengan Kode Tiket: {$claimCode}.")
                ->with('claimCode', $claimCode)
                ->with('waUrl', $waUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Claim Store Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengirim pengajuan klaim. Silakan coba kembali.')->withInput();
        }
    }

    public function tracking(Request $request)
    {
        $claims = collect();
        $rawSearchKey = (string) $request->input('claim_code');
        $searchKey = trim($rawSearchKey);

        if ($searchKey !== '') {
            $upperSearch = strtoupper($searchKey);

            // Format variations (e.g. "CL-2026-0001" => "#CL-2026-0001", "2026-0001" => "#CL-2026-0001")
            $formattedClaimCode = str_starts_with($upperSearch, '#')
                ? $upperSearch
                : (str_starts_with($upperSearch, 'CL-') ? '#' . $upperSearch : '#CL-' . $upperSearch);

            $formattedLostCode = str_starts_with($upperSearch, '#')
                ? $upperSearch
                : (str_starts_with($upperSearch, 'LR-') ? '#' . $upperSearch : '#LR-' . $upperSearch);

            $claims = Claim::with(['foundItem.category', 'lostReport'])
                ->where(function ($q) use ($searchKey, $upperSearch, $formattedClaimCode, $formattedLostCode) {
                    $q->where('claim_code', $searchKey)
                      ->orWhere('claim_code', $upperSearch)
                      ->orWhere('claim_code', $formattedClaimCode)
                      ->orWhere('claim_code', 'LIKE', '%' . $searchKey . '%')
                      ->orWhere('claimant_phone', 'LIKE', '%' . $searchKey . '%')
                      ->orWhere('claimant_email', 'LIKE', '%' . $searchKey . '%')
                      ->orWhere('claimant_id_number', $searchKey)
                      ->orWhereHas('lostReport', function ($lq) use ($searchKey, $formattedLostCode) {
                          $lq->where('report_code', $searchKey)
                             ->orWhere('report_code', $formattedLostCode);
                      });
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $claim = $claims->first();

        return view('pages.public.claim-tracking', compact('claims', 'claim', 'searchKey'));
    }
}
