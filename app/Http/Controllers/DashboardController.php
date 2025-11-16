<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Contrat;
use App\Models\Paiement;
use App\Models\Locataire;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les filtres ou utiliser les valeurs par défaut (mois/année actuels)
        $moisActuel = $request->get('mois', now()->month);
        $anneeActuelle = $request->get('annee', now()->year);

        // Valider les valeurs
        $moisActuel = max(1, min(12, (int)$moisActuel));
        $anneeActuelle = max(2020, min(now()->year + 1, (int)$anneeActuelle));

        $stats = [
            'total_immeubles' => Immeuble::count(),
            'total_appartements' => Appartement::count(),
            'appartements_occupes' => Appartement::where('statut', 'occupe')->count(),
            'contrats_actifs' => Contrat::where('statut', 'actif')->count(),
            'paiements_du_mois' => Paiement::where('mois', $moisActuel)
                ->where('annee', $anneeActuelle)
                ->where('statut', 'paye')
                ->sum('montant'),
        ];

        // Paiements en retard (tous les mois)
        $paiements_en_retard = Paiement::where('statut', 'en_retard')
            ->with('contrat.locataire', 'contrat.appartement')
            ->get();

        // Contrats bientôt expirés
        $contrats_bientot_expires = Contrat::where('statut', 'actif')
            ->where('date_fin', '<=', now()->addDays(30))
            ->with('locataire', 'appartement')
            ->get();

        // Locataires avec leur statut de paiement du mois/année sélectionnés
        $locatairesAvecPaiement = $this->getLocatairesAvecStatutPaiement($moisActuel, $anneeActuelle);

        // Convertir en Collection pour utiliser les méthodes where()
        $locatairesCollection = collect($locatairesAvecPaiement);

        return view('dashboard', compact(
            'stats',
            'paiements_en_retard',
            'contrats_bientot_expires',
            'locatairesCollection',
            'moisActuel',
            'anneeActuelle'
        ));
    }

    /**
     * Récupère tous les locataires avec leur statut de paiement pour le mois/année donnés
     */
    private function getLocatairesAvecStatutPaiement($mois, $annee)
    {
        $contratsActifs = Contrat::where('statut', 'actif')
            ->with(['locataire', 'appartement.immeuble', 'paiements' => function($query) use ($mois, $annee) {
                $query->where('mois', $mois)->where('annee', $annee);
            }])
            ->get();

        $locataires = [];

        foreach ($contratsActifs as $contrat) {
            $paiementMois = $contrat->paiements->first();

            $locataires[] = [
                'id' => $contrat->locataire->id,
                'nom_complet' => $contrat->locataire->prenom . ' ' . $contrat->locataire->nom,
                'appartement' => $contrat->appartement->numero,
                'immeuble' => $contrat->appartement->immeuble->nom,
                'loyer' => $contrat->loyer_mensuel,
                'a_paye' => !is_null($paiementMois),
                'statut_paiement' => $paiementMois ? $paiementMois->statut : 'impaye',
                'date_paiement' => $paiementMois ? $paiementMois->date_paiement : null,
                'montant_paye' => $paiementMois ? $paiementMois->montant : 0,
                'contrat_id' => $contrat->id,
            ];
        }

        // Trier : payés d'abord, puis impayés
        usort($locataires, function($a, $b) {
            if ($a['a_paye'] === $b['a_paye']) {
                return strcmp($a['nom_complet'], $b['nom_complet']);
            }
            return $a['a_paye'] ? -1 : 1;
        });

        return $locataires;
    }

    /**
     * Génère les options de mois pour le select
     */
    private function getMoisOptions()
    {
        return [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        ];
    }

    /**
     * Génère les options d'année pour le select
     */
    private function getAnneeOptions()
    {
        $annees = [];
        $anneeDebut = 2020;
        $anneeFin = now()->year + 1;

        for ($i = $anneeDebut; $i <= $anneeFin; $i++) {
            $annees[$i] = $i;
        }

        return $annees;
    }

    public function rapports()
    {
        // Logique pour les rapports
        return view('rapports');
    }
}
