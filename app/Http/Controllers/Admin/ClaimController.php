<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClaimStatusUpdatedNotification;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $queryStr = $request->input('q');

        $query = Claim::with(['foundItem.category', 'lostReport']);

        if ($queryStr) {
            $query->where(function($q) use ($queryStr) {
                $q->where('claimant_name', 'like', "%{$queryStr}%")
                  ->orWhere('claim_code', 'like', "%{$queryStr}%")
                  ->orWhere('claimant_phone', 'like', "%{$queryStr}%");
            });
        }

        $claims = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.claims.index', compact('claims', 'queryStr'));
    }

    public function approve(int $id)
    {
        try {
            DB::beginTransaction();
            $claim = Claim::with('foundItem')->lockForUpdate()->findOrFail($id);
            if ($claim->status !== 'Menunggu Verifikasi' || $claim->foundItem->status !== 'active') {
                DB::rollBack();
                return redirect()->route('admin.claims.index')->with('error', 'Transisi klaim tidak valid atau barang sudah diproses.');
            }
            $oldStatus = $claim->status;
            $foundItem = $claim->foundItem;

            $claim->update(['status' => 'Disetujui']);

            // Set the associated FoundItem as claimed
            $foundItem->update(['status' => 'claimed']);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Setujui Klaim',
                'details' => "Status {$claim->claim_code}: {$oldStatus} -> Disetujui; barang {$foundItem->title} ({$foundItem->ref_code}) ditandai claimed.",
            ]);

            DB::commit();

            if ($claim->claimant_email) {
                $claim->notify(new ClaimStatusUpdatedNotification);
            }

            return redirect()->route('admin.claims.index')->with('success', "Klaim {$claim->claim_code} berhasil disetujui. Barang ditandai sebagai dikembalikan.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Claim Approve Error: ' . $e->getMessage());
            return redirect()->route('admin.claims.index')->with('error', 'Terjadi kesalahan saat menyetujui klaim.');
        }
    }

    public function reject(int $id)
    {
        try {
            $claim = Claim::with('foundItem')->lockForUpdate()->findOrFail($id);
            if ($claim->status !== 'Menunggu Verifikasi') {
                return redirect()->route('admin.claims.index')->with('error', 'Transisi klaim tidak valid.');
            }
            $oldStatus = $claim->status;
            $claim->update(['status' => 'Ditolak']);

            if ($claim->claimant_email) {
                $claim->notify(new ClaimStatusUpdatedNotification);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Tolak Klaim',
                'details' => "Status {$claim->claim_code}: {$oldStatus} -> Ditolak untuk barang {$claim->foundItem->title} ({$claim->foundItem->ref_code}).",
            ]);

            return redirect()->route('admin.claims.index')->with('success', "Klaim {$claim->claim_code} berhasil ditolak.");

        } catch (\Exception $e) {
            Log::error('Claim Reject Error: ' . $e->getMessage());
            return redirect()->route('admin.claims.index')->with('error', 'Terjadi kesalahan saat menolak klaim.');
        }
    }

    public function document(int $id)
    {
        $claim = Claim::findOrFail($id);

        abort_unless($claim->supporting_document_path, 404);

        return Storage::disk('local')->download($claim->supporting_document_path);
    }
}
