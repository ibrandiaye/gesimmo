<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Contrat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('contrat.locataire', 'contrat.appartement')
            ->latest()
            ->get();

        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {
        $contrats = Contrat::where('statut', 'actif')->get();
        return view('paiements.create', compact('contrats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2020',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Paiement::create($validated);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement enregistré avec succès.');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load('contrat.locataire', 'contrat.appartement.immeuble');
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $contrats = Contrat::where('statut', 'actif')->get();
        return view('paiements.edit', compact('paiement', 'contrats'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer|min:2020',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'statut' => 'required|in:paye,en_retard,partiel',
            'mode_paiement' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $paiement->update($validated);

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement modifié avec succès.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()->route('paiements.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }

    public function genererQuittance(Paiement $paiement)
    {
        $paiement->load('contrat.locataire', 'contrat.appartement.immeuble');

        $pdf = Pdf::loadView('paiements.quittance', compact('paiement'));

        return $pdf->download('quittance-' . $paiement->id . '.pdf');
    }
}
