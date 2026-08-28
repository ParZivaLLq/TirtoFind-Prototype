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

    /**
     * Reusable Scope for Searching and Filtering Found Items.
     */
    public function scopeSearch($query, ?string $q = null, ?string $category = null, ?string $location = null, ?string $date = null)
    {
        $query->where('status', 'active');

        if (!empty($q)) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('ref_code', 'like', "%{$q}%")
                    ->orWhere('color', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('location_found', 'like', "%{$q}%");
            });
        }

        if (!empty($category) && $category !== 'all') {
            $query->whereHas('category', function($sub) use ($category) {
                $sub->where('slug', $category)->orWhere('name', $category);
            });
        }

        if (!empty($location) && $location !== 'all') {
            $query->where('location_found', 'like', "%{$location}%");
        }

        if (!empty($date)) {
            $query->whereDate('date_found', $date);
        }

        return $query;
    }

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
