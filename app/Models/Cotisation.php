<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model {
    protected $fillable = [
        'membre_id',
        'transaction_id',
        'montant',
        'penalite',
        'montant_total',
        'en_retard',
        'statut',
        'date_paiement',
    ];

    public function membre() {
        return $this->belongsTo(Membre::class);
    }

    public function groupe() {
        return $this->belongsTo(GroupeSolidarite::class, 'groupe_id');
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}