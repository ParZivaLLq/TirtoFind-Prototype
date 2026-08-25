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
}
