<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil publique
     */
    public function index()
    {
        // Récupérer les 6 offres les plus récentes
        $recentJobs = JobOffer::with(['category', 'recruiter'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('home', compact('recentJobs'));
    }
}
