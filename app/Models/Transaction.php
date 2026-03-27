<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = [
        'type',
        'montant',
        'statut',
        'description',
    ];

    public function cotisation() {
        return $this->hasOne(Cotisation::class);
    }

    public function pret() {
        return $this->hasOne(Pret::class);
    }

    public function remboursement() {
        return $this->hasOne(Remboursement::class);
    }
}