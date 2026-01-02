<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil publique
     */
    public function index()
    {
        // Pour l'instant, on retourne simplement la vue
        // Plus tard, on ajoutera les données réelles (offres, stats, etc.)
        return view('home');
    }
}
