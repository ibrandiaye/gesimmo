<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Loyers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
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
                Gestion des Loyers
            </h2>
            <p class="mt-2 text-purple-100">
                Connectez-vous à votre espace gestion
            </p>
        </div>

        <!-- Carte de connexion -->
        <div class="login-card rounded-2xl shadow-xl p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

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
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
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
                            autocomplete="current-password"
                            required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150"
                            placeholder="Votre mot de passe">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-purple-600 hover:text-purple-500 transition duration-150">
                            Mot de passe oublié ?
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 font-medium">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-purple-300 group-hover:text-purple-200"></i>
                        </span>
                        Se connecter
                    </button>
                </div>

                <!-- Messages d'erreur -->
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Erreur de connexion
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Message de succès -->
                @if (session('status'))
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('status') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </form>

            <!-- Informations de démo (optionnel) -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Application de démonstration
                    </p>
                    <div class="mt-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                        <p class="font-medium">Compte de test :</p>
                        <p>Email: <span class="font-mono">admin@example.com</span></p>
                        <p>Mot de passe: <span class="font-mono">password</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-purple-200 text-sm">
                &copy; {{ date('Y') }} Gestion des Loyers. Tous droits réservés.
            </p>
        </div>
    </div>

    <script>
        // Animation simple pour les inputs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-purple-200');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-purple-200');
                });
            });
        });
    </script>
</body>
</html>
