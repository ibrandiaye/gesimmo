@extends('layouts.app')

@section('title', 'Paiement ' . $paiement->id)

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Paiement #{{ $paiement->id }}</h1>
            <p class="text-gray-600">
                {{ $paiement->contrat->locataire->prenom }} {{ $paiement->contrat->locataire->nom }} -
                {{ $paiement->mois }}/{{ $paiement->annee }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('paiements.edit', $paiement) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('quittances.generer', $paiement) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" target="_blank">
                <i class="fas fa-file-pdf mr-2"></i>Générer Quittance
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations du paiement -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Détails du Paiement</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informations Locataire</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm text-gray-600">Locataire</label>
                            <p class="text-gray-900 font-medium">
                                {{ $paiement->contrat->locataire->prenom }} {{ $paiement->contrat->locataire->nom }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Email</label>
                            <p class="text-gray-900">{{ $paiement->contrat->locataire->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Téléphone</label>
                            <p class="text-gray-900">{{ $paiement->contrat->locataire->telephone }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-md font-medium text-gray-700 mb-3">Informations Appartement</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-sm text-gray-600">Appartement</label>
                            <p class="text-gray-900 font-medium">{{ $paiement->contrat->appartement->numero }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Immeuble</label>
                            <p class="text-gray-900">{{ $paiement->contrat->appartement->immeuble->nom }}</p>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Adresse</label>
                            <p class="text-gray-900 text-sm">
                                {{ $paiement->contrat->appartement->immeuble->adresse }},
                                {{ $paiement->contrat->appartement->immeuble->code_postal }}
                                {{ $paiement->contrat->appartement->immeuble->ville }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Période</label>
                    <p class="mt-1 text-gray-900 font-medium">
                        {{ DateTime::createFromFormat('!m', $paiement->mois)->format('F') }} {{ $paiement->annee }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Montant</label>
                    <p class="mt-1 text-gray-900 font-medium text-xl">{{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Date de paiement</label>
                    <p class="mt-1 text-gray-900">{{ $paiement->date_paiement->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Mode de paiement</label>
                    <p class="mt-1 text-gray-900">{{ $paiement->mode_paiement }}</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Statut</label>
                    <p class="mt-1">
                        @if($paiement->statut == 'paye')
                            <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">Payé</span>
                        @elseif($paiement->statut == 'en_retard')
                            <span class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded-full">En retard</span>
                        @else
                            <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">Partiel</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Contrat associé</label>
                    <p class="mt-1">
                        <a href="{{ route('contrats.show', $paiement->contrat) }}" class="text-blue-600 hover:text-blue-900">
                            Contrat #{{ $paiement->contrat->id }}
                        </a>
                    </p>
                </div>
            </div>

            @if($paiement->notes)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-600">Notes</label>
                <p class="mt-1 text-gray-900 bg-gray-50 p-3 rounded">{{ $paiement->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Actions et informations complémentaires -->
    <div class="lg:col-span-1">
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>

            <div class="space-y-3">
                <a href="{{ route('quittances.generer', $paiement) }}" class="w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition block" target="_blank">
                    <i class="fas fa-file-pdf mr-2"></i>Générer Quittance
                </a>
                <a href="{{ route('paiements.edit', $paiement) }}" class="w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition block">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('contrats.show', $paiement->contrat) }}" class="w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition block">
                    <i class="fas fa-file-contract mr-2"></i>Voir le Contrat
                </a>
                <a href="{{ route('locataires.show', $paiement->contrat->locataire) }}" class="w-full bg-orange-600 text-white text-center px-4 py-2 rounded-lg hover:bg-orange-700 transition block">
                    <i class="fas fa-user mr-2"></i>Fiche Locataire
                </a>
            </div>
        </div>

        <!-- Informations du contrat -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Contrat Associé</h2>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Loyer mensuel:</span>
                    <span class="text-sm font-medium text-gray-900">
                        {{ number_format($paiement->contrat->loyer_mensuel, 2, ',', ' ') }} €
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Date début:</span>
                    <span class="text-sm text-gray-900">{{ $paiement->contrat->date_debut->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Date fin:</span>
                    <span class="text-sm text-gray-900">{{ $paiement->contrat->date_fin->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Statut:</span>
                    <span class="text-sm">
                        @if($paiement->contrat->statut == 'actif')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Actif</span>
                        @elseif($paiement->contrat->statut == 'resilie')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Résilié</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Expiré</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Métadonnées</h2>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Créé le:</span>
                    <span class="text-sm text-gray-900">{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Modifié le:</span>
                    <span class="text-sm text-gray-900">{{ $paiement->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
