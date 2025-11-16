@extends('layouts.app')

@section('title', 'Nouvel Appartement')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvel Appartement</h1>

        <form action="{{ route('appartements.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="immeuble_id" class="block text-sm font-medium text-gray-700">Immeuble *</label>
                    <select name="immeuble_id" id="immeuble_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un immeuble</option>
                        @foreach($immeubles as $immeuble)
                            <option value="{{ $immeuble->id }}" {{ old('immeuble_id') == $immeuble->id ? 'selected' : '' }}>
                                {{ $immeuble->nom }} - {{ $immeuble->adresse }}
                            </option>
                        @endforeach
                    </select>
                    @error('immeuble_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="numero" class="block text-sm font-medium text-gray-700">Numéro d'appartement *</label>
                    <input type="text" name="numero" id="numero" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('numero') }}">
                    @error('numero')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="surface" class="block text-sm font-medium text-gray-700">Surface (m²) *</label>
                        <input type="number" step="0.01" name="surface" id="surface" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('surface') }}">
                        @error('surface')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nombre_pieces" class="block text-sm font-medium text-gray-700">Nombre de pièces *</label>
                        <input type="number" name="nombre_pieces" id="nombre_pieces" required min="1"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('nombre_pieces') }}">
                        @error('nombre_pieces')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('appartements.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Créer l'Appartement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
