<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remboursement extends Model {
    protected $fillable = [
        'pret_id', 'transaction_id',
        'montant', 'date_remboursement', 'statut',
    ];

    public function pret() {
        return $this->belongsTo(Pret::class);
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}