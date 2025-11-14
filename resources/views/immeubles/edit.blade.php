@extends('layouts.app')

@section('title', 'Modifier Immeuble')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier l'Immeuble</h1>

        <form action="{{ route('immeubles.update', $immeuble) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom de l'immeuble *</label>
                    <input type="text" name="nom" id="nom" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('nom', $immeuble->nom) }}">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse *</label>
                    <input type="text" name="adresse" id="adresse" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('adresse', $immeuble->adresse) }}">
                    @error('adresse')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="code_postal" class="block text-sm font-medium text-gray-700">Code Postal *</label>
                        <input type="text" name="code_postal" id="code_postal" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('code_postal', $immeuble->code_postal) }}">
                        @error('code_postal')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ville" class="block text-sm font-medium text-gray-700">Ville *</label>
                        <input type="text" name="ville" id="ville" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('ville', $immeuble->ville) }}">
                        @error('ville')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('immeubles.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Modifier l'Immeuble
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
