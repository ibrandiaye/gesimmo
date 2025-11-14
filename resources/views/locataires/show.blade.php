@extends('layouts.app')

@section('title', $locataire->prenom . ' ' . $locataire->nom)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                <span class="text-blue-600 font-bold text-xl">
                    {{ substr($locataire->prenom, 0, 1) }}{{ substr($locataire->nom, 0, 1) }}
                </span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $locataire->prenom }} {{ $locataire->nom }}</h1>
                <p class="text-gray-600">Locataire #{{ $locataire->id }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('locataires.edit', $locataire) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            @if(!$locataire->contratActif)
                <a href="{{ route('contrats.create') }}?locataire_id={{ $locataire->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-file-contract mr-2"></i>Créer Contrat
                </a>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations personnelles -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations Personnelles</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Email</label>
                    <p class="mt-1 text-gray-900">{{ $locataire->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Téléphone</label>
                    <p class="mt-1 text-gray-900">{{ $locataire->telephone }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Adresse</label>
                    <p class="mt-1 text-gray-900">{{ $locataire->adresse }}</p>
                </div>
                @if($locataire->piece_identite)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Pièce d'identité</label>
                    <p class="mt-1 text-gray-900">{{ $locataire->piece_identite }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Historique des contrats -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Historique des Contrats</h2>

            @if($locataire->contrats->count() > 0)
            <div class="space-y-4">
                @foreach($locataire->contrats as $contrat)
                <div class="border rounded-lg p-4 {{ $contrat->statut == 'actif' ? 'bg-green-50 border-green-200' : 'bg-gray-50' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-900">
                                    {{ $contrat->appartement->numero }} - {{ $contrat->appartement->immeuble->nom }}
                                </h3>
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $contrat->statut == 'actif' ? 'bg-green-100 text-green-800' :
                                       ($contrat->statut == 'resilie' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $contrat->statut }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Du:</span>
                                    <p class="text-gray-900">{{ $contrat->date_debut->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Au:</span>
                                    <p class="text-gray-900">{{ $contrat->date_fin->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Loyer:</span>
                                    <p class="text-gray-900 font-medium">{{ number_format($contrat->loyer_mensuel, 2, ',', ' ') }} €</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Garantie:</span>
                                    <p class="text-gray-900">{{ number_format($contrat->depot_garantie, 2, ',', ' ') }} €</p>
                                </div>
                            </div>
                            @if($contrat->conditions_speciales)
                            <div class="mt-2">
                                <span class="text-gray-600 text-sm">Conditions spéciales:</span>
                                <p class="text-gray-900 text-sm">{{ $contrat->conditions_speciales }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="ml-4 flex space-x-2">
                            <a href="{{ route('contrats.show', $contrat) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Aucun contrat pour ce locataire</p>
            @endif
        </div>

        <!-- Historique des paiements -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Derniers Paiements</h2>

            @if($locataire->paiements->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois/Année</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($locataire->paiements->take(10) as $paiement)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paiement->mois }}/{{ $paiement->annee }}</div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($paiement->montant, 2, ',', ' ') }} €</div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @if($paiement->statut == 'paye')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Payé</span>
                                @elseif($paiement->statut == 'en_retard')
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">En retard</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Partiel</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paiement->contrat->appartement->numero }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Aucun paiement enregistré</p>
            @endif
        </div>
    </div>

    <!-- Contrat actuel et statistiques -->
    <div class="lg:col-span-1">
        @if($locataire->contratActif)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contrat Actuel</h2>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Appartement</label>
                    <p class="mt-1 text-gray-900 font-medium">
                        {{ $locataire->contratActif->appartement->numero }}
                    </p>
                    <p class="text-sm text-gray-600">{{ $locataire->contratActif->appartement->immeuble->nom }}</p>
                    <p class="text-sm text-gray-600">{{ $locataire->contratActif->appartement->surface }} m² - {{ $locataire->contratActif->appartement->nombre_pieces }} pièces</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Période</label>
                    <p class="mt-1 text-gray-900">
                        Du {{ $locataire->contratActif->date_debut->format('d/m/Y') }}<br>
                        Au {{ $locataire->contratActif->date_fin->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Loyer mensuel</label>
                    <p class="mt-1 text-gray-900 font-medium">{{ number_format($locataire->contratActif->loyer_mensuel, 2, ',', ' ') }} €</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Dépôt de garantie</label>
                    <p class="mt-1 text-gray-900">{{ number_format($locataire->contratActif->depot_garantie, 2, ',', ' ') }} €</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('contrats.show', $locataire->contratActif) }}" class="w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition block mb-2">
                        Voir le contrat
                    </a>
                    <a href="{{ route('paiements.create') }}?contrat_id={{ $locataire->contratActif->id }}" class="w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition block">
                        Enregistrer un paiement
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contrat Actuel</h2>
            <p class="text-gray-500 text-center py-4">Aucun contrat actif</p>
            <a href="{{ route('contrats.create') }}?locataire_id={{ $locataire->id }}" class="w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition block">
                Créer un contrat
            </a>
        </div>
        @endif

        <!-- Statistiques -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total des contrats:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $locataire->contrats->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Paiements enregistrés:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $locataire->paiements->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Paiements en retard:</span>
                    <span class="text-sm font-medium text-red-600">{{ $locataire->paiements->where('statut', 'en_retard')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
