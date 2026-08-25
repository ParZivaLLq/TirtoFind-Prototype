<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_code',
        'title',
        'category_id',
        'description',
        'color',
        'brand',
        'location_found',
        'date_found',
        'storage_location',
        'image_path',
        'status'
    ];

    protected $casts = [
        'date_found' => 'datetime',
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

    public function aiDescriptionLogs()
    {
        return $this->hasMany(AiDescriptionLog::class);
    }
}
