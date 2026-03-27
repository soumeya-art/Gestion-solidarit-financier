<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RegleGroupe extends Model {
    protected $table = 'regles_groupe';
    protected $fillable = [
        'cotisation_minimale', 
        'frequence', 
        'penalite_retard', 
        'plafond_aide',
        'description'
    ];
}