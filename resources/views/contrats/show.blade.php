@extends('layouts.app')

@section('title', 'Contrat ' . $contrat->id)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Contrat de Location #{{ $contrat->id }}</h1>
            <p class="text-gray-600">
                {{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }} -
                {{ $contrat->appartement->numero }} ({{ $contrat->appartement->immeuble->nom }})
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('contrats.edit', $contrat) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('paiements.create') }}?contrat_id={{ $contrat->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-money-bill-wave mr-2"></i>Nouveau Paiement
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations principales -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations du Contrat</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-md font-medium text-gray-700 mb-3">Locataire</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm text-gray-600">Nom complet</label>
                            <p class="text-gray-900 font-medium">{{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Email</label>
                            <p class="text-gray-900">{{ $contrat->locataire->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Téléphone</label>
                            <p class="text-gray-900">{{ $contrat->locataire->telephone }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Adresse</label>
                            <p class="text-gray-900 text-sm">{{ $contrat->locataire->adresse }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-md font-medium text-gray-700 mb-3">Appartement</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm text-gray-600">Numéro</label>
                            <p class="text-gray-900 font-medium">{{ $contrat->appartement->numero }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Immeuble</label>
                            <p class="text-gray-900">{{ $contrat->appartement->immeuble->nom }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Adresse</label>
                            <p class="text-gray-900 text-sm">{{ $contrat->appartement->immeuble->adresse }}, {{ $contrat->appartement->immeuble->code_postal }} {{ $contrat->appartement->immeuble->ville }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Surface</label>
                            <p class="text-gray-900">{{ $contrat->appartement->surface }} m² - {{ $contrat->appartement->nombre_pieces }} pièces</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de début</label>
                    <p class="mt-1 text-gray-900">{{ $contrat->date_debut->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de fin</label>
                    <p class="mt-1 text-gray-900">{{ $contrat->date_fin->format('d/m/Y') }}</p>
                    @if($contrat->date_fin->isPast())
                        <span class="text-xs text-red-600">Contrat expiré</span>
                    @elseif($contrat->date_fin->diffInDays(now()) < 30)
                        <span class="text-xs text-orange-600">Expire dans {{ $contrat->date_fin->diffInDays(now()) }} jours</span>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <p class="mt-1">
                        @if($contrat->statut == 'actif')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Actif</span>
                        @elseif($contrat->statut == 'resilie')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Résilié</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Expiré</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Loyer mensuel</label>
                    <p class="mt-1 text-gray-900 font-medium text-xl">{{ number_format($contrat->loyer_mensuel, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Dépôt de garantie</label>
                    <p class="mt-1 text-gray-900">{{ number_format($contrat->depot_garantie, 2, ',', ' ') }} €</p>
                </div>
            </div>

            @if($contrat->conditions_speciales)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-600">Conditions spéciales</label>
                <p class="mt-1 text-gray-900 bg-gray-50 p-3 rounded">{{ $contrat->conditions_speciales }}</p>
            </div>
            @endif
        </div>

        <!-- Historique des paiements -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Historique des Paiements</h2>

            @if($contrat->paiements->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois/Année</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date paiement</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contrat->paiements->sortByDesc('created_at') as $paiement)
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
                                <div class="text-sm text-gray-900">{{ $paiement->mode_paiement }}</div>
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
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('paiements.show', $paiement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('quittances.generer', $paiement) }}" class="text-green-600 hover:text-green-900" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-4">Aucun paiement enregistré pour ce contrat</p>
            @endif
        </div>
    </div>

    <!-- Statistiques et actions -->
    <div class="lg:col-span-1">
        <!-- Statistiques -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Total payé:</span>
                    <span class="text-sm font-medium text-gray-900">
                        {{ number_format($contrat->paiements->where('statut', 'paye')->sum('montant'), 2, ',', ' ') }} €
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Paiements enregistrés:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $contrat->paiements->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Paiements en retard:</span>
                    <span class="text-sm font-medium text-red-600">{{ $contrat->paiements->where('statut', 'en_retard')->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Durée restante:</span>
                    <span class="text-sm font-medium text-gray-900">
                        @if($contrat->date_fin->isFuture())
                            {{ $contrat->date_fin->diffInMonths(now()) }} mois
                        @else
                            Terminé
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h2>

            <div class="space-y-3">
                <a href="{{ route('paiements.create') }}?contrat_id={{ $contrat->id }}" class="w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition block">
                    <i class="fas fa-money-bill-wave mr-2"></i>Nouveau Paiement
                </a>
                <a href="{{ route('locataires.show', $contrat->locataire) }}" class="w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition block">
                    <i class="fas fa-user mr-2"></i>Fiche Locataire
                </a>
                <a href="{{ route('appartements.show', $contrat->appartement) }}" class="w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition block">
                    <i class="fas fa-home mr-2"></i>Fiche Appartement
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
