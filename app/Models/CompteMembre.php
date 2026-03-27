<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteMembre extends Model {
    protected $table = 'comptes_membre';

    protected $fillable = [
        'membre_id',
        'solde',
        'total_cotise',
        'credit_disponible',
        'statut',
    ];

    public function membre() {
        return $this->belongsTo(Membre::class);
    }
}