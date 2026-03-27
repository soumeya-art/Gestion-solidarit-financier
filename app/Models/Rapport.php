<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model {
    protected $fillable = [
        'groupe_id', 'type', 'titre',
        'periode_debut', 'periode_fin',
        'total_cotisations', 'total_prets', 'total_remboursements',
    ];

    public function groupe() {
        return $this->belongsTo(GroupeSolidarite::class, 'groupe_id');
    }
}