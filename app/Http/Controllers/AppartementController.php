<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Http\Request;

class AppartementController extends Controller
{
    public function index()
    {
        $appartements = Appartement::with(['immeuble', 'contratActif.locataire'])->latest()->get();
        return view('appartements.index', compact('appartements'));
    }

    public function create()
    {
        $immeubles = Immeuble::all();
        return view('appartements.create', compact('immeubles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'numero' => 'required|string|max:50',
            'surface' => 'required|numeric|min:0',
            'nombre_pieces' => 'required|integer|min:1',
            'loyer_mensuel' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Appartement::create($validated);

        return redirect()->route('appartements.index')
            ->with('success', 'Appartement créé avec succès.');
    }

    public function show(Appartement $appartement)
    {
        $appartement->load(['immeuble', 'contrats.locataire', 'contratActif.locataire']);
        return view('appartements.show', compact('appartement'));
    }

    public function edit(Appartement $appartement)
    {
        $immeubles = Immeuble::all();
        return view('appartements.edit', compact('appartement', 'immeubles'));
    }

    public function update(Request $request, Appartement $appartement)
    {
        $validated = $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'numero' => 'required|string|max:50',
            'surface' => 'required|numeric|min:0',
            'nombre_pieces' => 'required|integer|min:1',
            'loyer_mensuel' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $appartement->update($validated);

        return redirect()->route('appartements.index')
            ->with('success', 'Appartement modifié avec succès.');
    }

    public function destroy(Appartement $appartement)
    {
        if ($appartement->contrats()->count() > 0) {
            return redirect()->route('appartements.index')
                ->with('error', 'Impossible de supprimer un appartement avec des contrats.');
        }

        $appartement->delete();

        return redirect()->route('appartements.index')
            ->with('success', 'Appartement supprimé avec succès.');
    }
}
