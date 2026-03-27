<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeAide extends Model {
    protected $table = 'demandes_aide';

    protected $fillable = [
        'membre_id',
        'type',
        'montant_demande',
        'motif',
        'preuve',
        'motif_refus',
        'score_priorite',
        'statut',
        'montant_approuve',
        'date_demande',
    ];

    public function membre() {
        return $this->belongsTo(Membre::class);
    }

    public function groupe() {
        return $this->belongsTo(GroupeSolidarite::class, 'groupe_id');
    }
}