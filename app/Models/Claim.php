<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Claim extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'claim_code',
        'found_item_id',
        'lost_report_id',
        'claimant_name',
        'claimant_phone',
        'claimant_id_number',
        'claimant_email',
        'relationship',
        'reason',
        'distinctive_features',
        'supporting_document_path',
        'status'
    ];

    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class);
    }

    public function lostReport()
    {
        return $this->belongsTo(LostReport::class);
    }

    public function routeNotificationForMail(): ?string
    {
        return $this->claimant_email;
    }

    /**
     * Get descriptive status message for tracking.
     */
    public function statusMessage(): string
    {
        return match ($this->status) {
            'Disetujui' => 'Permohonan klaim Anda telah DISETUJUI! Silakan bawa kartu identitas (KTP/SIM) asli ke Pos Pelayanan Lost & Found Terminal Tirtonadi untuk verifikasi fisik & serah terima barang.',
            'Ditolak' => 'Mohon maaf, permohonan klaim Anda DITOLAK karena bukti kepemilikan atau ciri khusus yang dilampirkan belum cocok. Silakan hubungi CS Pos Informasi untuk verifikasi ulang.',
            default => 'Permohonan klaim Anda sedang dalam proses verifikasi oleh tim Customer Service & Petugas Terminal Tirtonadi. Mohon siapkan bukti pendukung tambahan jika diperlukan.',
        };
    }

    /**
     * Get tracking steps timeline.
     */
    public function statusSteps(): array
    {
        return [
            'Permohonan Terkirim',
            'Verifikasi Berkas',
            'Keputusan Klaim',
            'Penyerahan Barang'
        ];
    }
}

