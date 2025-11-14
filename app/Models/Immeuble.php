<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'adresse', 'ville', 'code_postal'];

    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    }

    public function contratsActifs()
    {
        return $this->hasManyThrough(Contrat::class, Appartement::class)
            ->where('statut', 'actif');
    }
}
