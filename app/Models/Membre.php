<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model {
    protected $fillable = ['user_id', 'date_naissance', 'adresse', 'piece_identite'];

    public function user() { return $this->belongsTo(User::class); }
    public function adhesion() { return $this->hasOne(Adhesion::class); }
    public function compte() { return $this->hasOne(CompteMembre::class); }
    public function cotisations() { return $this->hasMany(Cotisation::class); }
    public function demandes() { return $this->hasMany(DemandeAide::class); }
}