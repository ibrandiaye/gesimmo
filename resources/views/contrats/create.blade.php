@extends('layouts.app')

@section('title', 'Nouveau Contrat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau Contrat de Location</h1>

        <form action="{{ route('contrats.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Locataire -->
                <div class="md:col-span-2">
                    <label for="locataire_id" class="block text-sm font-medium text-gray-700">Locataire *</label>
                    <select name="locataire_id" id="locataire_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un locataire</option>
                        @foreach($locataires as $locataire)
                            <option value="{{ $locataire->id }}"
                                {{ old('locataire_id', request('locataire_id')) == $locataire->id ? 'selected' : '' }}>
                                {{ $locataire->prenom }} {{ $locataire->nom }} - {{ $locataire->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('locataire_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Appartement -->
                <div class="md:col-span-2">
                    <label for="appartement_id" class="block text-sm font-medium text-gray-700">Appartement *</label>
                    <select name="appartement_id" id="appartement_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un appartement</option>
                        @foreach($appartements as $appartement)
                            <option value="{{ $appartement->id }}"
                                {{ old('appartement_id', request('appartement_id')) == $appartement->id ? 'selected' : '' }}>
                                {{ $appartement->numero }} - {{ $appartement->immeuble->nom }}
                                ({{ $appartement->surface }} m² - {{ number_format($appartement->loyer_mensuel, 2, ',', ' ') }} XOF)
                            </option>
                        @endforeach
                    </select>
                    @error('appartement_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début *</label>
                    <input type="date" name="date_debut" id="date_debut" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('date_debut') }}">
                    @error('date_debut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin *</label>
                    <input type="date" name="date_fin" id="date_fin" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('date_fin') }}">
                    @error('date_fin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Montants -->
                <div>
                    <label for="loyer_mensuel" class="block text-sm font-medium text-gray-700">Loyer mensuel (XOF) *</label>
                    <input type="number" step="0.01" name="loyer_mensuel" id="loyer_mensuel" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('loyer_mensuel') }}">
                    @error('loyer_mensuel')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="depot_garantie" class="block text-sm font-medium text-gray-700">Dépôt de garantie (XOF) *</label>
                    <input type="number" step="0.01" name="depot_garantie" id="depot_garantie" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('depot_garantie') }}">
                    @error('depot_garantie')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Conditions spéciales -->
                <div class="md:col-span-2">
                    <label for="conditions_speciales" class="block text-sm font-medium text-gray-700">Conditions spéciales</label>
                    <textarea name="conditions_speciales" id="conditions_speciales" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Charges incluses, modalités de paiement, conditions particulières...">{{ old('conditions_speciales') }}</textarea>
                    @error('conditions_speciales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('contrats.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Créer le Contrat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Remplir automatiquement le loyer mensuel basé sur l'appartement sélectionné
    document.getElementById('appartement_id').addEventListener('change', function() {
        const appartementId = this.value;
        if (appartementId) {
            // Dans une application réelle, vous feriez une requête AJAX pour récupérer les détails de l'appartement
            // Pour l'instant, nous allons simplement utiliser la valeur affichée dans l'option
            const selectedOption = this.options[this.selectedIndex];
            const text = selectedOption.text;
            const loyerMatch = text.match(/\(.*?(\d+,\d+) XOF\)/);
            if (loyerMatch) {
                const loyer = loyerMatch[1].replace(',', '.');
                document.getElementById('loyer_mensuel').value = loyer;

                // Définir le dépôt de garantie comme 1 mois de loyer
                document.getElementById('depot_garantie').value = loyer;
            }
        }
    });
</script>
@endsection
