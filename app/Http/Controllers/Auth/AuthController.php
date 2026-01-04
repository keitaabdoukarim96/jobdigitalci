<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Afficher la page de sélection du type d'utilisateur
     */
    public function showRegisterSelection()
    {
        return view('auth.register-selection');
    }

    /**
     * Afficher le formulaire d'inscription selon le type
     */
    public function showRegisterForm($type = null)
    {
        // Types valides
        $validTypes = ['tpe', 'pme', 'grande-entreprise', 'cabinet-recrutement', 'ecole', 'administration', 'candidat'];

        // Si pas de type ou type invalide, rediriger vers la sélection
        if (!$type || !in_array($type, $validTypes)) {
            return redirect()->route('register.selection');
        }

        // Déterminer le rôle basé sur le type
        $role = $type === 'candidat' ? 'candidate' : 'recruiter';

        return view('auth.register', compact('type', 'role'));
    }

    /**
     * Traiter l'inscription
     */
    public function register(Request $request)
    {
        // Déterminer les règles de validation selon le rôle
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', 'in:candidate,recruiter'],
            'user_type' => ['required', 'string'],
            'terms' => ['accepted'],
        ];

        // Règles spécifiques pour les candidats
        if ($request->role === 'candidate') {
            $rules['first_name'] = ['required', 'string', 'max:255'];
            $rules['last_name'] = ['required', 'string', 'max:255'];
            $rules['phone'] = ['nullable', 'string', 'max:20'];
        }

        // Règles spécifiques pour les recruteurs
        if ($request->role === 'recruiter') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['contact_name'] = ['required', 'string', 'max:255'];
            $rules['contact_title'] = ['required', 'string', 'max:255'];
            $rules['phone'] = ['required', 'string', 'max:20'];
            $rules['city'] = ['required', 'string', 'max:255'];
        }

        // Messages de validation
        $messages = [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'company_name.required' => 'Le nom de l\'entreprise est obligatoire.',
            'contact_name.required' => 'Le nom du contact est obligatoire.',
            'contact_title.required' => 'La fonction est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ];

        // Validation
        $validated = $request->validate($rules, $messages);

        // Construire le nom complet selon le type
        if ($validated['role'] === 'candidate') {
            $fullName = $validated['first_name'] . ' ' . $validated['last_name'];
        } else {
            $fullName = $validated['company_name'];
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $fullName,
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'is_validated' => $validated['role'] === 'candidate' ? true : false,
        ]);

        // Si c'est un candidat, créer son profil avec les informations de base
        if ($validated['role'] === 'candidate') {
            $user->candidateProfile()->create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
            ]);
        }

        // Connecter l'utilisateur automatiquement
        Auth::login($user);

        // Régénérer la session pour éviter les problèmes de fixation de session
        $request->session()->regenerate();

        // Redirection selon le rôle
        if ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard')
                ->with('success', 'Inscription réussie ! Votre compte recruteur est en attente de validation par un administrateur.');
        } else {
            return redirect()->route('candidate.dashboard')
                ->with('success', 'Inscription réussie ! Bienvenue sur JobDigitalCI.');
        }
    }

    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si le compte est validé (pour les recruteurs)
            if ($user->role === 'recruiter' && !$user->is_validated) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte recruteur est en attente de validation par un administrateur.',
                ])->onlyInput('email');
            }

            // Redirection selon le rôle
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            } elseif ($user->role === 'recruiter') {
                return redirect()->route('recruiter.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            } else {
                return redirect()->route('candidate.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            }
        }

        // Échec de connexion
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
