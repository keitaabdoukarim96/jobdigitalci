<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route temporaire pour la recherche (sera implémentée plus tard)
Route::get('/jobs/search', function () {
    return redirect()->route('home')->with('info', 'La recherche sera bientôt disponible');
})->name('jobs.search');
