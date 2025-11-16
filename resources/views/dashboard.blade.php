@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
            <p class="text-gray-600">Vue d'ensemble de votre gestion immobilière</p>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" action="{{ route('dashboard') }}" class="flex space-x-4 items-end">
                @csrf

                <!-- Filtre Mois -->
                <div>
                    <label for="mois" class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
                    <select name="mois" id="mois"
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-32">
                        @php
                            $moisOptions = [
                                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                            ];
                        @endphp
                        @foreach($moisOptions as $value => $label)
                            <option value="{{ $value }}" {{ $moisActuel == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Année -->
                <div>
                    <label for="annee" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                    <select name="annee" id="annee"
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-24">
                        @php
                            $anneeDebut = 2020;
                            $anneeFin = now()->year + 1;
                        @endphp
                        @for($i = $anneeDebut; $i <= $anneeFin; $i++)
                            <option value="{{ $i }}" {{ $anneeActuelle == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex space-x-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                    <a href="{{ route('dashboard') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-redo mr-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Indicateur de période sélectionnée -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">
                        Période sélectionnée : {{ \Carbon\Carbon::createFromDate($anneeActuelle, $moisActuel, 1)->locale('fr')->isoFormat('MMMM YYYY') }}
                    </h3>
                    <p class="text-blue-600 text-sm">
                        Affichage des paiements et statistiques pour cette période
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-800">
                    {{ $locatairesCollection->where('a_paye', true)->count() }}/{{ $locatairesCollection->count() }}
                </div>
                <div class="text-sm text-blue-600">Paiements effectués</div>
            </div>
        </div>
    </div>
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
                <h3 class="text-sm font-medium text-gray-600">Loyers {{ \Carbon\Carbon::createFromDate($anneeActuelle, $moisActuel, 1)->locale('fr')->isoFormat('MMMM') }}</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['paiements_du_mois'], 2, ',', ' ') }} XOF</p>
                <p class="text-sm text-gray-500">
                    {{ $locatairesCollection->where('a_paye', true)->count() }}/{{ $locatairesCollection->count() }} payés
                </p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Statut des paiements du mois -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>
                Statut des Paiements - {{ \Carbon\Carbon::createFromDate($anneeActuelle, $moisActuel, 1)->locale('fr')->isoFormat('MMMM YYYY') }}
            </h2>
            <div class="flex space-x-2">
                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                    {{ $locatairesCollection->where('a_paye', true)->count() }} Payés
                </span>
                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">
                    {{ $locatairesCollection->where('a_paye', false)->count() }} Impayés
                </span>
            </div>
        </div>
        <div class="p-6">
            @if($locatairesCollection->count() > 0)
                <div class="space-y-4">
                    @foreach($locatairesCollection as $locataire)
                    <div class="flex justify-between items-center p-4 rounded-lg border {{ $locataire['a_paye'] ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center {{ $locataire['a_paye'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    <i class="fas {{ $locataire['a_paye'] ? 'fa-check' : 'fa-times' }}"></i>
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $locataire['nom_complet'] }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $locataire['appartement'] }} - {{ $locataire['immeuble'] }}
                                </p>
                                @if($locataire['a_paye'])
                                    <p class="text-xs text-green-600">
                                        Payé le {{ $locataire['date_paiement']->format('d/m/Y') }} -
                                        {{ number_format($locataire['montant_paye'], 2, ',', ' ') }} XOF
                                    </p>
                                @else
                                    <p class="text-xs text-red-600">
                                        Loyer : {{ number_format($locataire['loyer'], 2, ',', ' ') }} XOF
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if($locataire['a_paye'])
                                <a href="{{ route('paiements.show', ['paiement' => $locataire['contrat_id'], 'mois' => $moisActuel, 'annee' => $anneeActuelle]) }}"
                                   class="text-blue-600 hover:text-blue-900 text-sm bg-white px-3 py-1 rounded border border-blue-200 hover:bg-blue-50 transition">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            @else
                                <a href="{{ route('paiements.create') }}?contrat_id={{ $locataire['contrat_id'] }}&mois={{ $moisActuel }}&annee={{ $anneeActuelle }}"
                                   class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                    <i class="fas fa-money-bill-wave mr-1"></i>Enregistrer
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucun contrat actif</p>
            @endif
        </div>
    </div>

    <!-- Alertes -->
    <div class="space-y-6">
        <!-- Paiements en retard -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-red-600">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Paiements en Retard (Tous mois)
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
                                <p class="text-xs text-red-600">
                                    {{ \Carbon\Carbon::createFromDate($paiement->annee, $paiement->mois, 1)->locale('fr')->isoFormat('MMMM YYYY') }} -
                                    Payé le {{ $paiement->date_paiement->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-red-600">{{ number_format($paiement->montant, 2, ',', ' ') }} XOF</p>
                                <a href="{{ route('paiements.edit', $paiement) }}" class="text-sm text-blue-600 hover:text-blue-900">
                                    Corriger
                                </a>
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
                                <p class="text-xs text-gray-500">
                                    Dans {{ $contrat->date_fin->diffInDays(now()) }} jours
                                </p>
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
</div>

<!-- Résumé financier -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">
        Résumé Financier - {{ \Carbon\Carbon::createFromDate($anneeActuelle, $moisActuel, 1)->locale('fr')->isoFormat('MMMM YYYY') }}
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-2xl font-bold text-green-600">
                {{ number_format($stats['paiements_du_mois'], 2, ',', ' ') }} XOF
            </div>
            <p class="text-sm text-green-800">Total perçu</p>
            <p class="text-xs text-green-600">
                {{ $locatairesCollection->where('a_paye', true)->count() }} paiements
            </p>
        </div>

        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-2xl font-bold text-blue-600">
                {{ number_format($locatairesCollection->sum('loyer'), 2, ',', ' ') }} XOF
            </div>
            <p class="text-sm text-blue-800">Loyers attendus</p>
            <p class="text-xs text-blue-600">
                {{ $locatairesCollection->count() }} contrats actifs
            </p>
        </div>

        <div class="text-center p-4 bg-red-50 rounded-lg">
            @php
                $resteAPercevoir = $locatairesCollection->sum('loyer') - $stats['paiements_du_mois'];
            @endphp
            <div class="text-2xl font-bold {{ $resteAPercevoir > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ number_format($resteAPercevoir, 2, ',', ' ') }} XOF
            </div>
            <p class="text-sm {{ $resteAPercevoir > 0 ? 'text-red-800' : 'text-green-800' }}">
                {{ $resteAPercevoir > 0 ? 'Reste à percevoir' : 'Excédent' }}
            </p>
            <p class="text-xs {{ $resteAPercevoir > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $locatairesCollection->where('a_paye', false)->count() }} impayés
            </p>
        </div>
    </div>
</div>

<!-- Script pour améliorer l'UX des filtres -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit quand on change les selects (optionnel)
    const moisSelect = document.getElementById('mois');
    const anneeSelect = document.getElementById('annee');

    // Décommenter si vous voulez un auto-submit
    /*
    moisSelect.addEventListener('change', function() {
        this.form.submit();
    });

    anneeSelect.addEventListener('change', function() {
        this.form.submit();
    });
    */
});
</script>
@endsection
