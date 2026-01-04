@extends('layouts.dashboard')

@section('title', 'Rechercher un emploi')

@section('profile-route', route('candidate.profile'))

@section('sidebar')
    <div class="nav-item">
        <a href="{{ route('candidate.dashboard') }}" class="nav-link {{ request()->routeIs('candidate.dashboard') ? 'active' : '' }}">
            <i class='bx bx-home-alt'></i>
            <span>Tableau de bord</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('candidate.jobs.index') }}" class="nav-link {{ request()->routeIs('candidate.jobs.*') ? 'active' : '' }}">
            <i class='bx bx-search'></i>
            <span>Rechercher un emploi</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('candidate.applications.index') }}" class="nav-link {{ request()->routeIs('candidate.applications.*') ? 'active' : '' }}">
            <i class='bx bx-file'></i>
            <span>Mes candidatures</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('candidate.favorites.index') }}" class="nav-link {{ request()->routeIs('candidate.favorites.*') ? 'active' : '' }}">
            <i class='bx bx-bookmark'></i>
            <span>Offres sauvegardées</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('candidate.profile') }}" class="nav-link {{ request()->routeIs('candidate.profile') ? 'active' : '' }}">
            <i class='bx bx-user'></i>
            <span>Mon profil</span>
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Rechercher un emploi</h1>
            <p class="text-muted">Trouvez l'emploi qui vous correspond parmi {{ $jobs->total() }} offres disponibles</p>
        </div>
    </div>

    <!-- Search and Filters Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('candidate.jobs.index') }}">
                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control"
                               placeholder="Titre du poste, entreprise, mots-clés..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class='bx bx-search'></i> Rechercher
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="city" class="form-select">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="employment_type" class="form-select">
                            <option value="">Tous les types</option>
                            <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Temps plein</option>
                            <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Temps partiel</option>
                            <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contrat</option>
                            <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Stage</option>
                            <option value="freelance" {{ request('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="experience_level" class="form-select">
                            <option value="">Tous les niveaux</option>
                            <option value="junior" {{ request('experience_level') == 'junior' ? 'selected' : '' }}>Junior</option>
                            <option value="intermediate" {{ request('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermédiaire</option>
                            <option value="senior" {{ request('experience_level') == 'senior' ? 'selected' : '' }}>Senior</option>
                            <option value="expert" {{ request('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                </div>

                <!-- Remote Work Checkbox -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_remote" value="1" id="is_remote"
                                   {{ request('is_remote') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_remote">
                                Télétravail possible
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class='bx bx-filter-alt'></i> Appliquer les filtres
                        </button>
                        <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-secondary">
                            <i class='bx bx-x'></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Job Listings -->
    @if($jobs->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class='bx bx-search-alt' style="font-size: 64px; color: #6b7280;"></i>
                <h4 class="mt-3">Aucune offre trouvée</h4>
                <p class="text-muted">Essayez de modifier vos critères de recherche.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($jobs as $job)
                <div class="col-12">
                    <div class="card h-100 job-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <!-- Job Title -->
                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('candidate.jobs.show', $job->id) }}" class="text-decoration-none text-dark">
                                            {{ $job->title }}
                                        </a>
                                    </h5>

                                    <!-- Company -->
                                    <p class="text-muted mb-3">
                                        <i class='bx bx-buildings'></i>
                                        {{ $job->company_name ?? $job->recruiter->name }}
                                    </p>

                                    <!-- Badges -->
                                    <div class="mb-3">
                                        @if($job->category)
                                            <span class="badge bg-primary me-2">
                                                <i class='bx {{ $job->category->icon }}'></i>
                                                {{ $job->category->name }}
                                            </span>
                                        @endif

                                        <span class="badge bg-secondary me-2">
                                            <i class='bx bx-map'></i>
                                            {{ $job->location }}
                                        </span>

                                        @if($job->is_remote)
                                            <span class="badge bg-success me-2">
                                                <i class='bx bx-laptop'></i>
                                                Télétravail
                                            </span>
                                        @endif

                                        <span class="badge bg-light text-dark me-2">
                                            {{ match($job->employment_type) {
                                                'full-time' => 'Temps plein',
                                                'part-time' => 'Temps partiel',
                                                'contract' => 'Contrat',
                                                'internship' => 'Stage',
                                                'freelance' => 'Freelance',
                                                default => $job->employment_type
                                            } }}
                                        </span>

                                        @if($job->experience_level)
                                            <span class="badge bg-light text-dark">
                                                {{ match($job->experience_level) {
                                                    'junior' => 'Junior',
                                                    'intermediate' => 'Intermédiaire',
                                                    'senior' => 'Senior',
                                                    'expert' => 'Expert',
                                                    default => $job->experience_level
                                                } }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <p class="text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $job->description }}
                                    </p>

                                    <!-- Meta Information -->
                                    <div class="text-muted small">
                                        <i class='bx bx-time'></i> Publié {{ $job->created_at->diffForHumans() }}
                                        @if($job->application_deadline)
                                            • Date limite: {{ $job->application_deadline->format('d/m/Y') }}
                                        @endif
                                        <span class="ms-3"><i class='bx bx-show'></i> {{ $job->views_count }} vues</span>
                                        <span class="ms-2"><i class='bx bx-user'></i> {{ $job->applications_count }} candidatures</span>
                                    </div>
                                </div>

                                <div class="col-md-3 text-end">
                                    <!-- Salary -->
                                    @if($job->salary_min || $job->salary_max)
                                        <div class="h5 text-primary mb-3">
                                            @if($job->salary_min && $job->salary_max)
                                                {{ number_format($job->salary_min, 0, ',', ' ') }} - {{ number_format($job->salary_max, 0, ',', ' ') }}
                                            @elseif($job->salary_min)
                                                À partir de {{ number_format($job->salary_min, 0, ',', ' ') }}
                                            @else
                                                Jusqu'à {{ number_format($job->salary_max, 0, ',', ' ') }}
                                            @endif
                                            FCFA
                                            <br><small class="text-muted">/ {{ $job->salary_period === 'month' ? 'mois' : 'an' }}</small>
                                        </div>
                                    @endif

                                    <!-- View Button -->
                                    <a href="{{ route('candidate.jobs.show', $job->id) }}" class="btn btn-primary">
                                        Voir l'offre <i class='bx bx-right-arrow-alt'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                {{ $jobs->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.job-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.job-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}
</style>
@endsection
