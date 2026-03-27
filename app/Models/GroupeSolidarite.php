<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupeSolidarite extends Model {
    protected $table = 'groupes_solidarite';

    protected $fillable = [
        'nom', 'type', 'date_creation', 'nombre_membres', 'statut'
    ];

    public function adhesions() {
        return $this->hasMany(Adhesion::class, 'groupe_id');
    }

    public function regle() {
        return $this->hasOne(RegleGroupe::class, 'groupe_id');
    }

    public function fond() {
        return $this->hasOne(FondCommun::class, 'groupe_id');
    }

    public function cotisations() {
        return $this->hasMany(Cotisation::class, 'groupe_id');
    }

    public function prets() {
        return $this->hasMany(Pret::class, 'groupe_id');
    }

    public function rapports() {
        return $this->hasMany(Rapport::class, 'groupe_id');
    }
}
