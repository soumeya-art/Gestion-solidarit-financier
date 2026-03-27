<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Adhesion extends Model {
    protected $fillable = [
        'membre_id', 'date_adhesion', 'role', 'statut', 'cotisations_payees'
    ];

    public function membre() { return $this->belongsTo(Membre::class); }
}