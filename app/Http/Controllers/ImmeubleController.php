<?php

namespace App\Http\Controllers;

use App\Models\Immeuble;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ImmeubleController extends Controller
{
    public function index()
    {
        $immeubles = Immeuble::withCount('appartements')->latest()->get();
        return view('immeubles.index', compact('immeubles'));
    }

    public function create()
    {
        return view('immeubles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
        ]);

        Immeuble::create($validated);

        return redirect()->route('immeubles.index')
            ->with('success', 'Immeuble créé avec succès.');
    }

    public function show(Immeuble $immeuble)
    {
        $immeuble->load('appartements.contratActif.locataire');
        return view('immeubles.show', compact('immeuble'));
    }

    public function edit(Immeuble $immeuble)
    {
        return view('immeubles.edit', compact('immeuble'));
    }

    public function update(Request $request, Immeuble $immeuble)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
        ]);

        $immeuble->update($validated);

        return redirect()->route('immeubles.index')
            ->with('success', 'Immeuble modifié avec succès.');
    }

    public function destroy(Immeuble $immeuble)
    {
        if ($immeuble->appartements()->count() > 0) {
            return redirect()->route('immeubles.index')
                ->with('error', 'Impossible de supprimer un immeuble avec des appartements.');
        }

        $immeuble->delete();

        return redirect()->route('immeubles.index')
            ->with('success', 'Immeuble supprimé avec succès.');
    }
}
