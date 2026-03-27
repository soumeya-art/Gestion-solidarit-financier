<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pret extends Model {
    protected $fillable = [
        'membre_id',
        'groupe_id',
        'montant_pret',
        'taux_interet',
        'duree_en_mois',
        'capital_restant',
        'motif',
        'statut',
        'date_approbation',
    ];

    public function membre() {
        return $this->belongsTo(Membre::class);
    }

    public function groupe() {
        return $this->belongsTo(GroupeSolidarite::class, 'groupe_id');
    }

    public function remboursements() {
        return $this->hasMany(Remboursement::class);
    }
}