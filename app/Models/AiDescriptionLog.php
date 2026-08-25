<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiDescriptionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'found_item_id',
        'prompt',
        'response'
    ];

    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class);
    }
}
