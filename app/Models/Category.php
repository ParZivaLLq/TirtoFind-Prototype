<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function foundItems()
    {
        return $this->hasMany(FoundItem::class);
    }

    public function lostReports()
    {
        return $this->hasMany(LostReport::class);
    }
}
