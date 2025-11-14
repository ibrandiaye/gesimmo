<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;
      protected $fillable = [
        'locataire_id', 'appartement_id', 'date_debut', 'date_fin',
        'loyer_mensuel', 'depot_garantie', 'statut', 'conditions_speciales'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }

    public function appartement()
    {
        return $this->belongsTo(Appartement::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function paiementsEnRetard()
    {
        return $this->paiements()->where('statut', 'en_retard');
    }
}
