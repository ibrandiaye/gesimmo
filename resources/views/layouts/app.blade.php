<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Loyers - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-building text-2xl"></i>
                    <h1 class="text-xl font-bold">Gestion des Loyers</h1>
                </div>

                <div class="flex items-center space-x-6">
                    @auth
                        <!-- Menu navigation pour utilisateurs connectés -->
                        <div class="flex space-x-6">
                            <a href="{{ route('dashboard') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('immeubles.index') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-building mr-2"></i>Immeubles
                            </a>
                            <a href="{{ route('appartements.index') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-home mr-2"></i>Appartements
                            </a>
                            <a href="{{ route('locataires.index') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-users mr-2"></i>Locataires
                            </a>
                            <a href="{{ route('contrats.index') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-file-contract mr-2"></i>Contrats
                            </a>
                            <a href="{{ route('paiements.index') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-money-bill-wave mr-2"></i>Paiements
                            </a>
                        </div>

                        <!-- Menu utilisateur -->
                        <div class="relative ml-4">
                            <button class="flex items-center space-x-2 hover:text-blue-200 transition">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Paramètres
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Menu pour utilisateurs non connectés -->
                        <div class="flex space-x-4">
                            <a href="{{ route('login') }}" class="hover:text-blue-200 transition">
                                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hover:text-blue-200 transition">
                                    <i class="fas fa-user-plus mr-2"></i>Inscription
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if(session('status'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-info-circle mr-2"></i>{{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Gestion des Loyers. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Script pour le dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.querySelector('button[class*="flex items-center space-x-2"]');
            const userMenu = document.querySelector('.absolute.right-0');

            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function() {
                    userMenu.classList.toggle('hidden');
                });

                // Fermer le menu en cliquant ailleurs
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
