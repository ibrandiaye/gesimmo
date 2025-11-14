<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Locataire;
use App\Models\Appartement;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    public function index()
    {
        $contrats = Contrat::with(['locataire', 'appartement.immeuble'])->latest()->get();
        return view('contrats.index', compact('contrats'));
    }

    public function create()
    {
        $locataires = Locataire::doesntHave('contratActif')->get();
        $appartements = Appartement::where('statut', 'libre')->get();

        return view('contrats.create', compact('locataires', 'appartements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'appartement_id' => 'required|exists:appartements,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'loyer_mensuel' => 'required|numeric|min:0',
            'depot_garantie' => 'required|numeric|min:0',
            'conditions_speciales' => 'nullable|string',
        ]);

        $contrat = Contrat::create($validated);

        // Mettre à jour le statut de l'appartement
        $contrat->appartement->update(['statut' => 'occupe']);

        return redirect()->route('contrats.index')
            ->with('success', 'Contrat créé avec succès.');
    }

    public function show(Contrat $contrat)
    {
        $contrat->load(['locataire', 'appartement.immeuble', 'paiements']);
        return view('contrats.show', compact('contrat'));
    }

    public function edit(Contrat $contrat)
    {
        $locataires = Locataire::all();
        $appartements = Appartement::all();

        return view('contrats.edit', compact('contrat', 'locataires', 'appartements'));
    }

    public function update(Request $request, Contrat $contrat)
    {
        $validated = $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'appartement_id' => 'required|exists:appartements,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'loyer_mensuel' => 'required|numeric|min:0',
            'depot_garantie' => 'required|numeric|min:0',
            'statut' => 'required|in:actif,resilie,expire',
            'conditions_speciales' => 'nullable|string',
        ]);

        $contrat->update($validated);

        return redirect()->route('contrats.index')
            ->with('success', 'Contrat modifié avec succès.');
    }

    public function destroy(Contrat $contrat)
    {
        // Libérer l'appartement
        $contrat->appartement->update(['statut' => 'libre']);

        $contrat->delete();

        return redirect()->route('contrats.index')
            ->with('success', 'Contrat supprimé avec succès.');
    }
}
