<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruiterDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord du recruteur
     */
    public function index()
    {
        $user = auth()->user();

        // Statistiques du recruteur
        $stats = [
            'active_jobs' => 0,      // Offres actives
            'total_applications' => 0, // Total candidatures reçues
            'new_applications' => 0,  // Nouvelles candidatures
            'profile_views' => 0,     // Vues du profil entreprise
        ];

        return view('recruiter.dashboard', compact('user', 'stats'));
    }

    /**
     * Afficher la liste des offres du recruteur
     */
    public function jobs()
    {
        $user = auth()->user();
        // TODO: Récupérer les offres du recruteur
        $jobs = [];

        return view('recruiter.jobs.index', compact('jobs'));
    }

    /**
     * Afficher le formulaire de création d'offre
     */
    public function createJob()
    {
        return view('recruiter.jobs.create');
    }

    /**
     * Afficher le profil de l'entreprise
     */
    public function profile()
    {
        $user = auth()->user();
        return view('recruiter.profile', compact('user'));
    }
}
