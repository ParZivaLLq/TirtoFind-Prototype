<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiMatchingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'lost_report_id',
        'found_item_id',
        'score',
        'reason',
        'color_match',
        'brand_match',
        'location_match',
        'time_match'
    ];

    public function lostReport()
    {
        return $this->belongsTo(LostReport::class);
    }

    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class);
    }
}
