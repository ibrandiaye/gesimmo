@extends('layouts.app')

@section('title', 'Appartement ' . $appartement->numero)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Appartement {{ $appartement->numero }}</h1>
            <p class="text-gray-600">{{ $appartement->immeuble->nom }} - {{ $appartement->immeuble->adresse }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('appartements.edit', $appartement) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            @if($appartement->statut == 'libre')
                <a href="{{ route('contrats.create') }}?appartement_id={{ $appartement->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-file-contract mr-2"></i>Créer Contrat
                </a>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations de l'appartement -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations de l'appartement</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Surface</label>
                    <p class="mt-1 text-gray-900">{{ $appartement->surface }} m²</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nombre de pièces</label>
                    <p class="mt-1 text-gray-900">{{ $appartement->nombre_pieces }} pièces</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Loyer mensuel</label>
                    <p class="mt-1 text-gray-900 font-medium">{{ number_format($appartement->loyer_mensuel, 2, ',', ' ') }} XOF</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <p class="mt-1">
                        @if($appartement->statut == 'occupe')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Occupé</span>
                        @elseif($appartement->statut == 'libre')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Libre</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">En entretien</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($appartement->description)
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-600">Description</label>
                <p class="mt-1 text-gray-900">{{ $appartement->description }}</p>
            </div>
            @endif
        </div>

        <!-- Historique des contrats -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Historique des contrats</h2>

            @if($appartement->contrats->count() > 0)
            <div class="space-y-4">
                @foreach($appartement->contrats as $contrat)
                <div class="border rounded-lg p-4 {{ $contrat->statut == 'actif' ? 'bg-green-50 border-green-200' : 'bg-gray-50' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-gray-900">
                                {{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                Du {{ $contrat->date_debut->format('d/m/Y') }} au {{ $contrat->date_fin->format('d/m/Y') }}
                            </p>
                            <p class="text-sm text-gray-600">Loyer: {{ number_format($contrat->loyer_mensuel, 2, ',', ' ') }} XOF</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $contrat->statut == 'actif' ? 'bg-green-100 text-green-800' :
                                   ($contrat->statut == 'resilie' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $contrat->statut }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Aucun contrat pour cet appartement</p>
            @endif
        </div>
    </div>

    <!-- Contrat actuel -->
    <div class="lg:col-span-1">
        @if($appartement->contratActif)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contrat Actuel</h2>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Locataire</label>
                    <p class="mt-1 text-gray-900 font-medium">
                        {{ $appartement->contratActif->locataire->prenom }} {{ $appartement->contratActif->locataire->nom }}
                    </p>
                    <p class="text-sm text-gray-600">{{ $appartement->contratActif->locataire->email }}</p>
                    <p class="text-sm text-gray-600">{{ $appartement->contratActif->locataire->telephone }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Période</label>
                    <p class="mt-1 text-gray-900">
                        Du {{ $appartement->contratActif->date_debut->format('d/m/Y') }}<br>
                        Au {{ $appartement->contratActif->date_fin->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Loyer</label>
                    <p class="mt-1 text-gray-900 font-medium">{{ number_format($appartement->contratActif->loyer_mensuel, 2, ',', ' ') }} XOF</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Dépôt de garantie</label>
                    <p class="mt-1 text-gray-900">{{ number_format($appartement->contratActif->depot_garantie, 2, ',', ' ') }} XOF</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('contrats.show', $appartement->contratActif) }}" class="w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition block">
                        Voir le contrat
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contrat Actuel</h2>
            <p class="text-gray-500 text-center py-4">Aucun contrat actif</p>
            <a href="{{ route('contrats.create') }}?appartement_id={{ $appartement->id }}" class="w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition block">
                Créer un contrat
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
