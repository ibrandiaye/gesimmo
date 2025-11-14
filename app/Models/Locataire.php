<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{
    use HasFactory;
     protected $fillable = [
        'nom', 'prenom', 'email', 'telephone',
        'piece_identite', 'adresse'
    ];

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    public function contratActif()
    {
        return $this->hasOne(Contrat::class)->where('statut', 'actif');
    }

    public function paiements()
    {
        return $this->hasManyThrough(Paiement::class, Contrat::class);
    }
}
