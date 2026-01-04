<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\JobCategory;
use App\Models\Application;
use App\Models\Favorite;
use App\Models\User;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
     * Afficher les détails d'une offre (pour candidats connectés)
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
     * Afficher les détails d'une offre (accessible aux invités)
     */
    public function showPublic($id)
    {
        $job = JobOffer::with(['category', 'recruiter'])->findOrFail($id);

        // Incrémenter le compteur de vues
        $job->increment('views_count');

        // Vérifier si l'utilisateur est connecté
        $isAuthenticated = Auth::check();
        $hasApplied = false;
        $isFavorited = false;

        if ($isAuthenticated && Auth::user()->isCandidate()) {
            $hasApplied = $job->hasApplied(Auth::id());
            $isFavorited = $job->isFavoritedBy(Auth::id());
        }

        return view('candidate.jobs.show-public', compact('job', 'isAuthenticated', 'hasApplied', 'isFavorited'));
    }

    /**
     * Afficher le formulaire de candidature pour les invités
     */
    public function showGuestApplicationForm($id)
    {
        $job = JobOffer::with(['category', 'recruiter'])->findOrFail($id);

        // Si l'utilisateur est déjà connecté, rediriger vers la page normale
        if (Auth::check()) {
            return redirect()->route('candidate.jobs.show', $id);
        }

        // Vérifier que l'offre est active
        if (!$job->isActive()) {
            return redirect()->route('jobs.show.public', $id)
                ->with('error', 'Cette offre n\'est plus disponible.');
        }

        // Stocker l'ID de l'offre dans la session
        session(['guest_application_job_id' => $id]);

        return view('candidate.jobs.guest-application', compact('job'));
    }

    /**
     * Soumettre la candidature d'un invité (inscription + candidature)
     */
    public function submitGuestApplication(Request $request, $id)
    {
        $job = JobOffer::findOrFail($id);

        // Vérifier que l'offre est active
        if (!$job->isActive()) {
            return redirect()->route('jobs.show.public', $id)
                ->with('error', 'Cette offre n\'est plus disponible.');
        }

        // Validation
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cv_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'cover_letter' => ['nullable', 'string', 'min:50'],
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'cv_file.required' => 'Le CV est obligatoire.',
            'cv_file.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv_file.max' => 'Le CV ne peut pas dépasser 5 Mo.',
            'cover_letter.min' => 'La lettre de motivation doit contenir au moins 50 caractères.',
        ]);

        try {
            // Utiliser une transaction pour garantir que tout se passe bien
            DB::beginTransaction();

            // 1. Créer l'utilisateur
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'candidate',
            ]);

            // 2. Créer le profil candidat
            $profile = CandidateProfile::create([
                'user_id' => $user->id,
                'profile_completeness' => 20, // Profil de base
            ]);

            // 3. Uploader le CV
            $cvPath = $request->file('cv_file')->store('applications/cvs', 'public');

            // 4. Créer la candidature
            Application::create([
                'candidate_id' => $user->id,
                'job_offer_id' => $job->id,
                'cover_letter' => $validated['cover_letter'] ?? 'Aucune lettre de motivation fournie.',
                'cv_file' => $cvPath,
                'status' => 'pending',
            ]);

            // 5. Incrémenter le compteur de candidatures
            $job->increment('applications_count');

            // 6. Connecter automatiquement l'utilisateur
            Auth::login($user);

            // 7. Nettoyer la session
            session()->forget('guest_application_job_id');

            DB::commit();

            // 8. Rediriger vers le dashboard avec message de succès
            return redirect()->route('candidate.dashboard')
                ->with('success', 'Félicitations! Votre candidature a été envoyée avec succès. Vous êtes maintenant connecté à votre compte.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue lors de l\'envoi de votre candidature. Veuillez réessayer.'])
                ->withInput();
        }
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
            'cv_choice' => ['nullable', 'string', 'in:existing,new'],
            'cv_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
        ], [
            'cover_letter.required' => 'La lettre de motivation est obligatoire.',
            'cover_letter.min' => 'La lettre de motivation doit contenir au moins 50 caractères.',
            'cv_file.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv_file.max' => 'Le CV ne peut pas dépasser 5 Mo.',
        ]);

        // Déterminer quel CV utiliser
        $cvPath = null;
        $cvChoice = $request->input('cv_choice', 'new');

        if ($cvChoice === 'existing') {
            // Utiliser le CV du profil
            $profile = Auth::user()->candidateProfile;
            if ($profile && $profile->cv_file) {
                // Copier le CV du profil pour cette candidature
                $originalPath = $profile->cv_file;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $newFilename = 'application_' . time() . '_' . uniqid() . '.' . $extension;

                // Copier le fichier dans le dossier des candidatures
                Storage::disk('public')->copy($originalPath, 'applications/cvs/' . $newFilename);
                $cvPath = 'applications/cvs/' . $newFilename;
            } else {
                return redirect()->back()
                    ->withErrors(['cv_file' => 'Vous n\'avez pas de CV dans votre profil. Veuillez en télécharger un.'])
                    ->withInput();
            }
        } else {
            // Upload d'un nouveau CV
            if ($request->hasFile('cv_file')) {
                $cvPath = $request->file('cv_file')->store('applications/cvs', 'public');
            } else {
                // Si pas de CV uploadé et pas de CV dans le profil
                $profile = Auth::user()->candidateProfile;
                if (!$profile || !$profile->cv_file) {
                    return redirect()->back()
                        ->withErrors(['cv_file' => 'Veuillez télécharger un CV pour cette candidature.'])
                        ->withInput();
                }
            }
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
