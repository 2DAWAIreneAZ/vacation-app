<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model {
    protected $fillable = ['id_vacation', 'route'];

    public function vacation(): BelongsTo {
        return $this->belongsTo(Vacation::class, 'id_vacation');
    }
}