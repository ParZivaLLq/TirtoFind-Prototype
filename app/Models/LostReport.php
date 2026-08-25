<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_code',
        'category_id',
        'reporter_name',
        'reporter_phone',
        'reporter_id_type',
        'reporter_id_number',
        'item_name',
        'color',
        'brand',
        'location_lost',
        'date_lost',
        'distinctive_features',
        'image_path',
        'status'
    ];

    protected $casts = [
        'date_lost' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function aiMatchingLogs()
    {
        return $this->hasMany(AiMatchingLog::class);
    }
}
