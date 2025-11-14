<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Routes pour les ressources
Route::resource('immeubles', ImmeubleController::class);
Route::resource('appartements', AppartementController::class);
Route::resource('locataires', LocataireController::class);
Route::resource('contrats', ContratController::class);
Route::resource('paiements', PaiementController::class);

// Routes supplémentaires
Route::get('/rapports', [DashboardController::class, 'rapports'])->name('rapports');
Route::get('/quittances/{paiement}', [PaiementController::class, 'genererQuittance'])->name('quittances.generer');
});
require_once 'auth.php';
