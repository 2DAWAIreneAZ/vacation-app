<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model {
    protected $fillable = ['id_user', 'id_vacation', 'text'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function vacation(): BelongsTo {
        return $this->belongsTo(Vacation::class, 'id_vacation');
    }

    /** El comentario pertenece al usuario dado */
    public function ownedBy(User $user): bool {
        return $this->id_user === $user->id;
    }
}