@extends('layouts.app')

@section('title', 'Paiements')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Gestion des Paiements</h1>
    <a href="{{ route('paiements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Nouveau Paiement
    </a>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex flex-wrap gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option>Tous les mois</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option>Toutes les années</option>
                @for($i = 2020; $i <= now()->year; $i++)
                    <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option>Tous les statuts</option>
                <option value="paye">Payé</option>
                <option value="en_retard">En retard</option>
                <option value="partiel">Partiel</option>
            </select>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Paiement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($paiements as $paiement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ substr($paiement->contrat->locataire->prenom, 0, 1) }}{{ substr($paiement->contrat->locataire->nom, 0, 1) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $paiement->contrat->locataire->prenom }} {{ $paiement->contrat->locataire->nom }}</div>
                                <div class="text-sm text-gray-500">Contrat #{{ $paiement->contrat->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $paiement->contrat->appartement->numero }}</div>
                        <div class="text-sm text-gray-500">{{ $paiement->contrat->appartement->immeuble->nom }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $paiement->mois }}/{{ $paiement->annee }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ number_format($paiement->montant, 2, ',', ' ') }} XOF</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $paiement->mode_paiement }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($paiement->statut == 'paye')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Payé</span>
                        @elseif($paiement->statut == 'en_retard')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">En retard</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Partiel</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('paiements.show', $paiement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('paiements.edit', $paiement) }}" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('quittances.generer', $paiement) }}" class="text-purple-600 hover:text-purple-900 mr-3" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" class="inline">
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
