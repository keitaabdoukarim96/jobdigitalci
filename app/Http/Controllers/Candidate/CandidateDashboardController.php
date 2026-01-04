<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord du candidat
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        // Créer le profil s'il n'existe pas
        if (!$profile) {
            $profile = CandidateProfile::create(['user_id' => $user->id]);
        }

        // Statistiques du candidat
        $stats = [
            'applications' => 0, // Nombre de candidatures envoyées
            'saved_jobs' => 0,   // Offres sauvegardées
            'profile_views' => $profile->profile_views ?? 0,
            'new_jobs' => 0,     // Nouvelles offres correspondant au profil
        ];

        // Calculer la complétion du profil
        $profileCompleteness = $profile->calculateCompleteness();
        $profile->update(['profile_completeness' => $profileCompleteness]);

        return view('candidate.dashboard', compact('user', 'stats', 'profile'));
    }

    /**
     * Afficher le profil du candidat
     */
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        // Créer le profil s'il n'existe pas
        if (!$profile) {
            $profile = CandidateProfile::create([
                'user_id' => $user->id,
                'phone' => $user->phone,
            ]);
        }

        $skills = $user->skills;
        $experiences = $user->experiences()->orderBy('start_date', 'desc')->get();
        $educations = $user->educations()->orderBy('start_date', 'desc')->get();

        return view('candidate.profile', compact('user', 'profile', 'skills', 'experiences', 'educations'));
    }

    /**
     * Mettre à jour le profil du candidat
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->candidateProfile ?? CandidateProfile::create(['user_id' => $user->id]);

        // Validation conditionnelle basée sur les champs présents
        $rules = [
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'experience_level' => ['nullable', 'string', 'in:junior,intermediate,senior,expert'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'availability' => ['nullable', 'string', 'in:immediately,1month,2months,3months'],
            'open_to_remote' => ['nullable', 'boolean'],
            'open_to_relocation' => ['nullable', 'boolean'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'cv_file' => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'], // Max 5MB
        ];

        // Ajouter des validations requises seulement si les champs sont présents dans la requête
        if ($request->has('first_name')) {
            $rules['first_name'] = ['required', 'string', 'max:255'];
        }
        if ($request->has('last_name')) {
            $rules['last_name'] = ['required', 'string', 'max:255'];
        }
        if ($request->has('phone')) {
            $rules['phone'] = ['required', 'string', 'max:20'];
        }
        if ($request->has('title')) {
            $rules['title'] = ['required', 'string', 'max:255'];
        }

        // Messages d'erreur en français
        $messages = [
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'last_name.required' => 'Le nom est obligatoire.',
            'last_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'title.required' => 'Le titre professionnel est obligatoire.',
            'title.max' => 'Le titre professionnel ne peut pas dépasser 255 caractères.',
            'date_of_birth.date' => 'La date de naissance doit être une date valide.',
            'gender.in' => 'Le genre sélectionné est invalide.',
            'bio.max' => 'La biographie ne peut pas dépasser 1000 caractères.',
            'experience_level.in' => 'Le niveau d\'expérience sélectionné est invalide.',
            'expected_salary.numeric' => 'Le salaire attendu doit être un nombre.',
            'expected_salary.min' => 'Le salaire attendu doit être positif.',
            'availability.in' => 'La disponibilité sélectionnée est invalide.',
            'linkedin_url.url' => 'L\'URL LinkedIn doit être une URL valide.',
            'github_url.url' => 'L\'URL GitHub doit être une URL valide.',
            'portfolio_url.url' => 'L\'URL du portfolio doit être une URL valide.',
            'twitter_url.url' => 'L\'URL Twitter doit être une URL valide.',
            'profile_photo.image' => 'Le fichier doit être une image.',
            'profile_photo.max' => 'La photo ne peut pas dépasser 2 Mo.',
            'cv_file.mimes' => 'Le CV doit être un fichier PDF, DOC ou DOCX.',
            'cv_file.max' => 'Le CV ne peut pas dépasser 5 Mo.',
        ];

        $validated = $request->validate($rules, $messages);

        // Gérer les checkboxes: si non cochées, elles ne sont pas dans la requête
        if ($request->has('open_to_remote') || $request->has('availability')) {
            $validated['open_to_remote'] = $request->has('open_to_remote') ? 1 : 0;
            $validated['open_to_relocation'] = $request->has('open_to_relocation') ? 1 : 0;
        }

        // Gérer l'upload de la photo de profil
        if ($request->hasFile('profile_photo')) {
            // Supprimer l'ancienne photo
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles/photos', 'public');
        }

        // Gérer l'upload du CV
        if ($request->hasFile('cv_file')) {
            // Supprimer l'ancien CV
            if ($profile->cv_file) {
                Storage::disk('public')->delete($profile->cv_file);
            }
            $validated['cv_file'] = $request->file('cv_file')->store('profiles/cvs', 'public');
        }

        // Séparer les données: certaines vont dans users, d'autres dans candidate_profiles
        $userFields = ['first_name', 'last_name'];
        $userData = [];
        $profileData = [];

        foreach ($validated as $key => $value) {
            if (in_array($key, $userFields)) {
                $userData[$key] = $value;
            } else {
                $profileData[$key] = $value;
            }
        }

        // Mettre à jour les informations de l'utilisateur (first_name, last_name)
        if (!empty($userData)) {
            $user->update($userData);
            // Mettre à jour aussi le nom complet
            if (isset($userData['first_name']) || isset($userData['last_name'])) {
                $user->update(['name' => ($userData['first_name'] ?? $user->first_name) . ' ' . ($userData['last_name'] ?? $user->last_name)]);
            }
        }

        // Mettre à jour le profil
        $profile->update($profileData);

        // Recalculer la complétion
        $profile->update(['profile_completeness' => $profile->calculateCompleteness()]);

        // Si c'est une requête AJAX (upload de photo ou CV), retourner JSON
        if ($request->ajax() || $request->wantsJson()) {
            $response = ['success' => true];

            if ($request->hasFile('profile_photo')) {
                $response['photo_url'] = asset('storage/' . $profileData['profile_photo']);
            }

            if ($request->hasFile('cv_file')) {
                $response['cv_url'] = asset('storage/' . $profileData['cv_file']);
            }

            return response()->json($response);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    // ===========================
    // GESTION DES COMPÉTENCES
    // ===========================

    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['user_id'] = Auth::id();
        Auth::user()->skills()->create($validated);

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Compétence ajoutée avec succès.');
    }

    public function updateSkill(Request $request, $skillId)
    {
        $skill = Auth::user()->skills()->findOrFail($skillId);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
        ]);

        $skill->update($validated);

        return back()->with('success', 'Compétence modifiée avec succès.');
    }

    public function deleteSkill($skillId)
    {
        $skill = Auth::user()->skills()->findOrFail($skillId);
        $skill->delete();

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Compétence supprimée avec succès.');
    }

    // ===========================
    // GESTION DES EXPÉRIENCES
    // ===========================

    public function storeExperience(Request $request)
    {
        $validated = $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        Auth::user()->experiences()->create($validated);

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Expérience ajoutée avec succès.');
    }

    public function updateExperience(Request $request, $experienceId)
    {
        $experience = Auth::user()->experiences()->findOrFail($experienceId);

        $validated = $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $experience->update($validated);

        return back()->with('success', 'Expérience modifiée avec succès.');
    }

    public function deleteExperience($experienceId)
    {
        $experience = Auth::user()->experiences()->findOrFail($experienceId);
        $experience->delete();

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Expérience supprimée avec succès.');
    }

    // ===========================
    // GESTION DES FORMATIONS
    // ===========================

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        Auth::user()->educations()->create($validated);

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Formation ajoutée avec succès.');
    }

    public function updateEducation(Request $request, $educationId)
    {
        $education = Auth::user()->educations()->findOrFail($educationId);

        $validated = $request->validate([
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $education->update($validated);

        return back()->with('success', 'Formation modifiée avec succès.');
    }

    public function deleteEducation($educationId)
    {
        $education = Auth::user()->educations()->findOrFail($educationId);
        $education->delete();

        // Recalculer la complétion du profil
        $this->updateProfileCompleteness();

        return back()->with('success', 'Formation supprimée avec succès.');
    }

    // ===========================
    // HELPER METHOD
    // ===========================

    /**
     * Recalculer et mettre à jour la complétion du profil
     */
    private function updateProfileCompleteness()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        if ($profile) {
            $completeness = $profile->calculateCompleteness();
            $profile->update(['profile_completeness' => $completeness]);
        }
    }
}
