<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion des Loyers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- En-tête -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4">
                <i class="fas fa-building text-3xl text-purple-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-white">
                Créer un compte
            </h2>
            <p class="mt-2 text-purple-100">
                Rejoignez notre plateforme de gestion
            </p>
        </div>

        <!-- Carte d'inscription -->
        <div class="register-card rounded-2xl shadow-xl p-8">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        Nom complet
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            value="{{ old('name') }}"
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150"
                            placeholder="Votre nom complet">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2 text-purple-500"></i>
                        Adresse email
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150"
                            placeholder="votre@email.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Mot de passe
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150"
                            placeholder="Votre mot de passe">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2 text-purple-500"></i>
                        Confirmer le mot de passe
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150"
                            placeholder="Confirmez votre mot de passe">
                    </div>
                </div>

                <!-- Bouton d'inscription -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 font-medium">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-purple-300 group-hover:text-purple-200"></i>
                        </span>
                        Créer mon compte
                    </button>
                </div>

                <!-- Lien vers connexion -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500 transition duration-150">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-purple-200 text-sm">
                &copy; {{ date('Y') }} Gestion des Loyers. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>
