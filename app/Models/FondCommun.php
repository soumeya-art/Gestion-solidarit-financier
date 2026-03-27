<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FondCommun extends Model {
    protected $table = 'fonds_commun';
    protected $fillable = ['solde_total', 'solde_disponible', 'solde_reserve'];
}