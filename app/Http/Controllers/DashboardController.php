<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Contrat;
use App\Models\Paiement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_immeubles' => Immeuble::count(),
            'total_appartements' => Appartement::count(),
            'appartements_occupes' => Appartement::where('statut', 'occupe')->count(),
            'contrats_actifs' => Contrat::where('statut', 'actif')->count(),
            'paiements_du_mois' => Paiement::where('mois', now()->month)
                ->where('annee', now()->year)
                ->where('statut', 'paye')
                ->sum('montant'),
        ];

        $paiements_en_retard = Paiement::where('statut', 'en_retard')
            ->with('contrat.locataire', 'contrat.appartement')
            ->get();

        $contrats_bientot_expires = Contrat::where('statut', 'actif')
            ->where('date_fin', '<=', now()->addDays(30))
            ->with('locataire', 'appartement')
            ->get();

        return view('dashboard', compact('stats', 'paiements_en_retard', 'contrats_bientot_expires'));
    }

    public function rapports()
    {
        // Logique pour les rapports
        return view('rapports');
    }
}
