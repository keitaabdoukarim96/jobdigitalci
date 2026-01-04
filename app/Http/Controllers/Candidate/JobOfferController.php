<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\JobCategory;
use App\Models\Application;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobOfferController extends Controller
{
    /**
     * Afficher la liste des offres d'emploi
     */
    public function index(Request $request)
    {
        $query = JobOffer::with(['category', 'recruiter'])
            ->where('status', 'active');

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filtre par ville
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // Filtre par type d'emploi
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->input('employment_type'));
        }

        // Filtre par niveau d'expérience
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->input('experience_level'));
        }

        // Filtre télétravail
        if ($request->filled('is_remote')) {
            $query->where('is_remote', true);
        }

        // Trier par date (plus récent en premier)
        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        // Récupérer toutes les catégories pour les filtres
        $categories = JobCategory::orderBy('name')->get();

        // Récupérer les villes disponibles
        $cities = JobOffer::where('status', 'active')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

        return view('candidate.jobs.index', compact('jobs', 'categories', 'cities'));
    }

    /**
     * Afficher les détails d'une offre
     */
    public function show($id)
    {
        $job = JobOffer::with(['category', 'recruiter'])->findOrFail($id);

        // Incrémenter le compteur de vues
        $job->increment('views_count');

        // Vérifier si le candidat a déjà postulé ou sauvegardé
        $hasApplied = false;
        $isFavorited = false;

        if (Auth::check() && Auth::user()->isCandidate()) {
            $hasApplied = $job->hasApplied(Auth::id());
            $isFavorited = $job->isFavoritedBy(Auth::id());
        }

        return view('candidate.jobs.show', compact('job', 'hasApplied', 'isFavorited'));
    }

    /**
     * Afficher les candidatures du candidat
     */
    public function myApplications()
    {
        $applications = Application::with(['jobOffer.category', 'jobOffer.recruiter'])
            ->where('candidate_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('candidate.applications.index', compact('applications'));
    }

    /**
     * Afficher les favoris du candidat
     */
    public function myFavorites()
    {
        $favorites = Favorite::with(['jobOffer.category', 'jobOffer.recruiter'])
            ->where('candidate_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('candidate.favorites.index', compact('favorites'));
    }

    /**
     * Postuler à une offre
     */
    public function apply(Request $request, $id)
    {
        $job = JobOffer::findOrFail($id);

        // Vérifier que l'offre est active
        if (!$job->isActive()) {
            return redirect()->back()->with('error', 'Cette offre n\'est plus disponible.');
        }

        // Vérifier que l'utilisateur n'a pas déjà postulé
        if ($job->hasApplied(Auth::id())) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        // Validation
        $validated = $request->validate([
            'cover_letter' => ['required', 'string', 'min:50'],
            'cv_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB max
        ], [
            'cover_letter.required' => 'La lettre de motivation est obligatoire.',
            'cover_letter.min' => 'La lettre de motivation doit contenir au moins 50 caractères.',
            'cv_file.mimes' => 'Le CV doit être au format PDF.',
            'cv_file.max' => 'Le CV ne peut pas dépasser 5 Mo.',
        ]);

        // Gérer l'upload du CV si fourni
        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('applications/cvs', 'public');
        }

        // Créer la candidature
        Application::create([
            'candidate_id' => Auth::id(),
            'job_offer_id' => $job->id,
            'cover_letter' => $validated['cover_letter'],
            'cv_file' => $cvPath,
            'status' => 'pending',
        ]);

        // Incrémenter le compteur de candidatures
        $job->increment('applications_count');

        return redirect()->route('candidate.jobs.show', $job->id)
            ->with('success', 'Votre candidature a été envoyée avec succès!');
    }

    /**
     * Ajouter/Retirer une offre des favoris
     */
    public function toggleFavorite($id)
    {
        $job = JobOffer::findOrFail($id);

        $favorite = Favorite::where('candidate_id', Auth::id())
            ->where('job_offer_id', $job->id)
            ->first();

        if ($favorite) {
            // Retirer des favoris
            $favorite->delete();
            return redirect()->back()->with('success', 'Offre retirée de vos favoris.');
        } else {
            // Ajouter aux favoris
            Favorite::create([
                'candidate_id' => Auth::id(),
                'job_offer_id' => $job->id,
            ]);
            return redirect()->back()->with('success', 'Offre ajoutée à vos favoris.');
        }
    }
}
