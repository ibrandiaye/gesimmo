<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;
    protected $fillable = [
        'immeuble_id', 'numero', 'surface', 'nombre_pieces',
        'loyer_mensuel', 'description', 'statut'
    ];

    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    public function contratActif()
    {
        return $this->hasOne(Contrat::class)->where('statut', 'actif');
    }
}
