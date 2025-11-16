@extends('layouts.app')

@section('title', 'Nouveau Paiement')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Paiement</h1>

        <form action="{{ route('paiements.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Contrat -->
                <div>
                    <label for="contrat_id" class="block text-sm font-medium text-gray-700">Contrat *</label>
                    <select name="contrat_id" id="contrat_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un contrat</option>
                        @foreach($contrats as $contrat)
                            <option value="{{ $contrat->id }}"
                                {{ old('contrat_id', request('contrat_id')) == $contrat->id ? 'selected' : '' }}>
                                {{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom }} -
                                {{ $contrat->appartement->numero }} ({{ number_format($contrat->loyer_mensuel, 2, ',', ' ') }} XOF)
                            </option>
                        @endforeach
                    </select>
                    @error('contrat_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Période -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="mois" class="block text-sm font-medium text-gray-700">Mois *</label>
                        <select name="mois" id="mois" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sélectionner un mois</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('mois', date('n')) == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        @error('mois')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="annee" class="block text-sm font-medium text-gray-700">Année *</label>
                        <select name="annee" id="annee" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sélectionner une année</option>
                            @for($i = 2020; $i <= now()->year + 1; $i++)
                                <option value="{{ $i }}" {{ old('annee', date('Y')) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('annee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Montant et date -->
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700">Montant (XOF) *</label>
                    <input type="number" step="0.01" name="montant" id="montant" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('montant') }}">
                    @error('montant')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date_paiement" class="block text-sm font-medium text-gray-700">Date de paiement *</label>
                    <input type="date" name="date_paiement" id="date_paiement" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('date_paiement', date('Y-m-d')) }}">
                    @error('date_paiement')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mode de paiement -->
                <div>
                    <label for="mode_paiement" class="block text-sm font-medium text-gray-700">Mode de paiement *</label>
                    <select name="mode_paiement" id="mode_paiement" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un mode</option>
                        <option value="Virement" {{ old('mode_paiement') == 'Virement' ? 'selected' : '' }}>Virement</option>
                        <option value="Chèque" {{ old('mode_paiement') == 'Chèque' ? 'selected' : '' }}>Chèque</option>
                        <option value="Espèces" {{ old('mode_paiement') == 'Espèces' ? 'selected' : '' }}>Espèces</option>
                        <option value="Carte" {{ old('mode_paiement') == 'Carte' ? 'selected' : '' }}>Carte bancaire</option>
                        <option value="Prélèvement" {{ old('mode_paiement') == 'Prélèvement' ? 'selected' : '' }}>Prélèvement</option>
                    </select>
                    @error('mode_paiement')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Informations complémentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('paiements.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Enregistrer le Paiement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Remplir automatiquement le montant basé sur le contrat sélectionné
    document.getElementById('contrat_id').addEventListener('change', function() {
        const contratId = this.value;
        if (contratId) {
            // Dans une application réelle, vous feriez une requête AJAX pour récupérer le loyer
            // Pour l'instant, nous allons simplement utiliser la valeur affichée dans l'option
            const selectedOption = this.options[this.selectedIndex];
            const text = selectedOption.text;
            const montantMatch = text.match(/\(.*?(\d+,\d+) XOF\)/);
            if (montantMatch) {
                const montant = montantMatch[1].replace(',', '.');
                document.getElementById('montant').value = montant;
            }
        }
    });
</script>
@endsection
