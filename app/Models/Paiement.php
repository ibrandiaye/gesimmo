<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberToWords\NumberToWords;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrat_id', 'mois', 'annee', 'montant',
        'date_paiement', 'statut', 'mode_paiement', 'notes'
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    /**
     * Convertit le montant en lettres pour la quittance
     */
    public function getMontantEnLettres()
    {
        try {
            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getNumberTransformer('fr');

            // Séparer les euros et les centimes
            $euros = floor($this->montant);
            $centimes = round(($this->montant - $euros) * 100);

            $texte = $numberTransformer->toWords($euros) . ' euro';
            if ($euros > 1) {
                $texte .= 's';
            }

            if ($centimes > 0) {
                $texte .= ' et ' . $numberTransformer->toWords($centimes) . ' centime';
                if ($centimes > 1) {
                    $texte .= 's';
                }
            }

            return ucfirst($texte);
        } catch (\Exception $e) {
            // Fallback si le package ne fonctionne pas
            return number_format($this->montant, 2, ',', ' ') . ' euros';
        }
    }

    /**
     * Getter pour le mois en lettres
     */
    public function getMoisLettresAttribute()
    {
        $mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        return $mois[$this->mois] ?? '';
    }
}
