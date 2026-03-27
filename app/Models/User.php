<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'role',
        'statut',
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


public function isAdmin(): bool {
    return $this->role === 'administrateur';
}

public function isCaissier(): bool {
    return $this->role === 'caissier';
}

public function isMembre(): bool {
    return $this->role === 'membre';
}
public function membre() {
    return $this->hasOne(\App\Models\Membre::class);
}
}