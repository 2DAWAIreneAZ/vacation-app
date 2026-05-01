<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacation extends Model {
    protected $fillable = [
        'title',
        'description',
        'price',
        'id_type',
        'country',
    ];

    // Relaciones 

    public function type(): BelongsTo {
        return $this->belongsTo(Type::class, 'id_type');
    }

    public function images() {
				return $this->hasMany(Image::class, 'id_vacation');
		}

    public function reserves(): HasMany {
        return $this->hasMany(Reserve::class, 'id_vacation');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'id_vacation')->latest();
    }

		public function getMainImageAttribute(): string {
				$image = $this->images->first();

				if ($image) {
						return asset('storage/' . $image->route);
				}

				return asset('images/noimage.jpg');
		}
}