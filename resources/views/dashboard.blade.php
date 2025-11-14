@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
    <p class="text-gray-600">Vue d'ensemble de votre gestion immobilière</p>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-building text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Immeubles</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_immeubles'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-home text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Appartements</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_appartements'] }}</p>
                <p class="text-sm text-gray-500">{{ $stats['appartements_occupes'] }} occupés</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-file-contract text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Contrats Actifs</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['contrats_actifs'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Loyers ce mois</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['paiements_du_mois'], 2, ',', ' ') }} €</p>
            </div>
        </div>
    </div>
</div>

<!-- Alertes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Paiements en retard -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-red-600">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Paiements en Retard
            </h2>
        </div>
        <div class="p-6">
            @if($paiements_en_retard->count() > 0)
                <div class="space-y-4">
                    @foreach($paiements_en_retard as $paiement)
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $paiement->contrat->locataire->prenom }} {{ $paiement->contrat->locataire->nom }}</p>
                            <p class="text-sm text-gray-600">{{ $paiement->contrat->appartement->numero }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-red-600">{{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
                            <p class="text-sm text-gray-600">Mois: {{ $paiement->mois }}/{{ $paiement->annee }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucun paiement en retard</p>
            @endif
        </div>
    </div>

    <!-- Contrats bientôt expirés -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-orange-600">
                <i class="fas fa-clock mr-2"></i>
                Contrats Bientôt Expirés
            </h2>
        </div>
        <div class="p-6">
            @if($contrats_bientot_expires->count() > 0)
                <div class="space-y-4">
                    @foreach($contrats_bientot_expires as $contrat)
                    <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                        <div>
                            <p class="font-medium">{{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }}</p>
                            <p class="text-sm text-gray-600">{{ $contrat->appartement->numero }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium">Expire le</p>
                            <p class="text-orange-600">{{ $contrat->date_fin->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucun contrat à expirer</p>
            @endif
        </div>
    </div>
</div>
@endsection
