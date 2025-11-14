@extends('layouts.app')

@section('title', 'Appartements')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des Appartements</h1>
    <a href="{{ route('appartements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Nouvel Appartement
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immeuble</th>
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
                @foreach($appartements as $appartement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $appartement->immeuble->nom }}</div>
                    </td>
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
                        <a href="{{ route('appartements.edit', $appartement) }}" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('appartements.destroy', $appartement) }}" method="POST" class="inline">
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
