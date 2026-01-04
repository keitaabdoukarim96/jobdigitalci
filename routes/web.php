<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use App\Http\Controllers\Candidate\JobOfferController;
use App\Http\Controllers\Recruiter\RecruiterDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route temporaire pour la recherche (sera implémentée plus tard)
Route::get('/jobs/search', function () {
    return redirect()->route('home')->with('info', 'La recherche sera bientôt disponible');
})->name('jobs.search');

// ===========================
// Routes d'Authentification
// ===========================

// Routes pour les invités (non connectés)
Route::middleware('guest')->group(function () {
    // Inscription - Sélection du type d'utilisateur
    Route::get('/register', [AuthController::class, 'showRegisterSelection'])->name('register.selection');
    Route::get('/register/{type}', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Connexion
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Mot de passe oublié
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

    // Réinitialisation du mot de passe
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

// Routes pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (redirection selon le rôle)
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard');
        } else {
            return redirect()->route('candidate.dashboard');
        }
    })->name('dashboard');
});

// ===========================
// Routes Candidat
// ===========================
Route::middleware(['auth', 'role:candidate'])->prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [CandidateDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [CandidateDashboardController::class, 'updateProfile'])->name('profile.update');

    // Gestion des compétences
    Route::post('/skills', [CandidateDashboardController::class, 'storeSkill'])->name('skills.store');
    Route::put('/skills/{skill}', [CandidateDashboardController::class, 'updateSkill'])->name('skills.update');
    Route::delete('/skills/{skill}', [CandidateDashboardController::class, 'deleteSkill'])->name('skills.delete');

    // Gestion des expériences
    Route::post('/experiences', [CandidateDashboardController::class, 'storeExperience'])->name('experiences.store');
    Route::put('/experiences/{experience}', [CandidateDashboardController::class, 'updateExperience'])->name('experiences.update');
    Route::delete('/experiences/{experience}', [CandidateDashboardController::class, 'deleteExperience'])->name('experiences.delete');

    // Gestion des formations
    Route::post('/educations', [CandidateDashboardController::class, 'storeEducation'])->name('educations.store');
    Route::put('/educations/{education}', [CandidateDashboardController::class, 'updateEducation'])->name('educations.update');
    Route::delete('/educations/{education}', [CandidateDashboardController::class, 'deleteEducation'])->name('educations.delete');

    // Recherche et visualisation des offres d'emploi
    Route::get('/jobs', [JobOfferController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}', [JobOfferController::class, 'show'])->name('jobs.show');

    // Candidatures
    Route::post('/jobs/{id}/apply', [JobOfferController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [JobOfferController::class, 'myApplications'])->name('applications.index');

    // Favoris
    Route::post('/jobs/{id}/favorite', [JobOfferController::class, 'toggleFavorite'])->name('jobs.toggleFavorite');
    Route::get('/my-favorites', [JobOfferController::class, 'myFavorites'])->name('favorites.index');
});

// ===========================
// Routes Recruteur
// ===========================
Route::middleware(['auth', 'role:recruiter'])->prefix('recruiter')->name('recruiter.')->group(function () {
    Route::get('/dashboard', [RecruiterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [RecruiterDashboardController::class, 'profile'])->name('profile');

    // Gestion des offres
    Route::get('/jobs', [RecruiterDashboardController::class, 'jobs'])->name('jobs.index');
    Route::get('/jobs/create', [RecruiterDashboardController::class, 'createJob'])->name('jobs.create');
});

// ===========================
// Routes Admin
// ===========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestion des utilisateurs
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');

    // Validation des recruteurs
    Route::get('/recruiters/pending', [AdminDashboardController::class, 'pendingRecruiters'])->name('recruiters.pending');
    Route::post('/recruiters/{id}/validate', [AdminDashboardController::class, 'validateRecruiter'])->name('recruiters.validate');
});
