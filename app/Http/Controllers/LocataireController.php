<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use Illuminate\Http\Request;

class LocataireController extends Controller
{
    public function index()
    {
        $locataires = Locataire::with('contratActif.appartement.immeuble')->latest()->get();
        return view('locataires.index', compact('locataires'));
    }

    public function create()
    {
        return view('locataires.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:locataires,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'piece_identite' => 'nullable|string',
        ]);

        Locataire::create($validated);

        return redirect()->route('locataires.index')
            ->with('success', 'Locataire créé avec succès.');
    }

    public function show(Locataire $locataire)
    {
        $locataire->load(['contrats.appartement.immeuble', 'paiements.contrat']);
        return view('locataires.show', compact('locataire'));
    }

    public function edit(Locataire $locataire)
    {
        return view('locataires.edit', compact('locataire'));
    }

    public function update(Request $request, Locataire $locataire)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:locataires,email,' . $locataire->id,
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'piece_identite' => 'nullable|string',
        ]);

        $locataire->update($validated);

        return redirect()->route('locataires.index')
            ->with('success', 'Locataire modifié avec succès.');
    }

    public function destroy(Locataire $locataire)
    {
        if ($locataire->contrats()->count() > 0) {
            return redirect()->route('locataires.index')
                ->with('error', 'Impossible de supprimer un locataire avec des contrats.');
        }

        $locataire->delete();

        return redirect()->route('locataires.index')
            ->with('success', 'Locataire supprimé avec succès.');
    }
}
