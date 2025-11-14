@extends('layouts.app')

@section('title', 'Locataires')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des Locataires</h1>
    <a href="{{ route('locataires.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Nouveau Locataire
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immeuble</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($locataires as $locataire)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ substr($locataire->prenom, 0, 1) }}{{ substr($locataire->nom, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $locataire->prenom }} {{ $locataire->nom }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $locataire->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $locataire->email }}</div>
                        <div class="text-sm text-gray-500">{{ $locataire->telephone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($locataire->contratActif)
                            <div class="text-sm text-gray-900">{{ $locataire->contratActif->appartement->numero }}</div>
                            <div class="text-sm text-gray-500">{{ $locataire->contratActif->appartement->surface }} m²</div>
                        @else
                            <span class="text-gray-400 text-sm">Aucun appartement</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($locataire->contratActif)
                            <div class="text-sm text-gray-900">{{ $locataire->contratActif->appartement->immeuble->nom }}</div>
                            <div class="text-sm text-gray-500">{{ $locataire->contratActif->appartement->immeuble->ville }}</div>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($locataire->contratActif)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Actif</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Inactif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('locataires.show', $locataire) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('locataires.edit', $locataire) }}" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('locataires.destroy', $locataire) }}" method="POST" class="inline">
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
