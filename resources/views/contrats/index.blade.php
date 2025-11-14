@extends('layouts.app')

@section('title', 'Contrats')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des Contrats</h1>
    <a href="{{ route('contrats.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Nouveau Contrat
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loyer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($contrats as $contrat)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ substr($contrat->locataire->prenom, 0, 1) }}{{ substr($contrat->locataire->nom, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }}</div>
                                <div class="text-sm text-gray-500">{{ $contrat->locataire->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $contrat->appartement->numero }}</div>
                        <div class="text-sm text-gray-500">{{ $contrat->appartement->immeuble->nom }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            Du {{ $contrat->date_debut->format('d/m/Y') }}<br>
                            Au {{ $contrat->date_fin->format('d/m/Y') }}
                        </div>
                        @if($contrat->date_fin->isPast())
                            <span class="text-xs text-red-600">Expiré</span>
                        @elseif($contrat->date_fin->diffInDays(now()) < 30)
                            <span class="text-xs text-orange-600">Expire bientôt</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($contrat->loyer_mensuel, 2, ',', ' ') }} €</div>
                        <div class="text-sm text-gray-500">Garantie: {{ number_format($contrat->depot_garantie, 2, ',', ' ') }} €</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($contrat->statut == 'actif')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Actif</span>
                        @elseif($contrat->statut == 'resilie')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Résilié</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Expiré</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('contrats.show', $contrat) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('contrats.edit', $contrat) }}" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('contrats.destroy', $contrat) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
