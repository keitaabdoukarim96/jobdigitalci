<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer;
use App\Models\JobCategory;

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

        // Récupérer toutes les catégories pour le formulaire de recherche
        $categories = JobCategory::orderBy('name')->get();

        // Récupérer les villes disponibles
        $cities = JobOffer::where('status', 'active')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

        return view('home', compact('recentJobs', 'categories', 'cities'));
    }

    /**
     * Affiche les résultats de recherche
     */
    public function search(Request $request)
    {
        $query = JobOffer::with(['category', 'recruiter'])
            ->where('status', 'active');

        // Recherche par mot-clé
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('company_name', 'like', "%{$keyword}%");
            });
        }

        // Recherche par localisation
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                  ->orWhere('city', 'like', "%{$location}%");
            });
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filtre par type d'emploi
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->input('employment_type'));
        }

        // Trier par date (plus récent en premier)
        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        // Récupérer les catégories et villes pour les filtres
        $categories = JobCategory::orderBy('name')->get();
        $cities = JobOffer::where('status', 'active')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

        return view('jobs-search', compact('jobs', 'categories', 'cities'));
    }
}
