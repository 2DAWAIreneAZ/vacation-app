<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'password' => 'hashed',
        ];
    }

    // Helpers de rol 

    public function isAdmin(): bool {
        return $this->rol === 'admin';
    }

    public function isAdvanced(): bool {
        return $this->rol === 'advanced';
    }

    public function isNormal(): bool {
        return $this->rol === 'normal';
    }

    /** Admin y Advanced pueden gestionar paquetes */
    public function canManageVacations(): bool {
        return in_array($this->rol, ['admin', 'advanced']);
    }


    public function reserves(): HasMany {
        return $this->hasMany(Reserve::class, 'id_user');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'id_user');
    }

    /** Comprueba si el usuario ha reservado un paquete concreto */
    public function hasReserved(int $vacationId): bool {
        return $this->reserves()->where('id_vacation', $vacationId)->exists();
    }
}