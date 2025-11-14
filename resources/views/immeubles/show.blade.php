@extends('layouts.app')

@section('title', $immeuble->nom)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $immeuble->nom }}</h1>
            <p class="text-gray-600">{{ $immeuble->adresse }}, {{ $immeuble->code_postal }} {{ $immeuble->ville }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('immeubles.edit', $immeuble) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('appartements.create') }}?immeuble_id={{ $immeuble->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Ajouter Appartement
            </a>
        </div>
    </div>
</div>

<!-- Statistiques de l'immeuble -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-home text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Appartements</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $immeuble->appartements->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-user-check text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Occupés</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $immeuble->appartements->where('statut', 'occupe')->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gray-100 rounded-lg">
                <i class="fas fa-door-open text-gray-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Libres</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $immeuble->appartements->where('statut', 'libre')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des appartements -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">Appartements de l'immeuble</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surface</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pièces</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loyer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($immeuble->appartements as $appartement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $appartement->numero }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900">{{ $appartement->surface }} m²</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900">{{ $appartement->nombre_pieces }} pièces</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900 font-medium">{{ number_format($appartement->loyer_mensuel, 2, ',', ' ') }} €</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($appartement->statut == 'occupe')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Occupé</span>
                        @elseif($appartement->statut == 'libre')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Libre</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">En entretien</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($appartement->contratActif)
                            <div class="text-sm text-gray-900">
                                {{ $appartement->contratActif->locataire->prenom }} {{ $appartement->contratActif->locataire->nom }}
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">Aucun locataire</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('appartements.show', $appartement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('appartements.edit', $appartement) }}" class="text-green-600 hover:text-green-900">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
