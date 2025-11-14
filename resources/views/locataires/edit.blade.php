@extends('layouts.app')

@section('title', 'Modifier Locataire')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Locataire</h1>

        <form action="{{ route('locataires.update', $locataire) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom *</label>
                        <input type="text" name="prenom" id="prenom" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('prenom', $locataire->prenom) }}">
                        @error('prenom')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" name="nom" id="nom" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('nom', $locataire->nom) }}">
                        @error('nom')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('email', $locataire->email) }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                    <input type="text" name="telephone" id="telephone" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('telephone', $locataire->telephone) }}">
                    @error('telephone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse *</label>
                    <textarea name="adresse" id="adresse" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('adresse', $locataire->adresse) }}</textarea>
                    @error('adresse')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="piece_identite" class="block text-sm font-medium text-gray-700">Pièce d'identité</label>
                    <input type="text" name="piece_identite" id="piece_identite"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('piece_identite', $locataire->piece_identite) }}"
                           placeholder="Numéro de carte d'identité ou passeport">
                    @error('piece_identite')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('locataires.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Modifier le Locataire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
