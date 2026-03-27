<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DemandeRemboursement extends Model {
    protected $table = 'demandes_remboursement';
    protected $fillable = [
        'membre_id', 'montant_demande', 'montant_approuve', 'motif', 'statut'
    ];

    public function membre() {
        return $this->belongsTo(Membre::class);
    }
}