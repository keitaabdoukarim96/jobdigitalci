@extends('layouts.app')

@section('title', 'Recherche d\'emplois')

@section('content')
<div class="container my-5">
    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('jobs.search') }}">
                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="keyword" class="form-label fw-bold">
                            <i class='bx bx-search-alt'></i> Mot-clé
                        </label>
                        <input type="text" name="keyword" id="keyword" class="form-control"
                               placeholder="Titre du poste, entreprise, mots-clés..."
                               value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-5">
                        <label for="location" class="form-label fw-bold">
                            <i class='bx bx-map'></i> Localisation
                        </label>
                        <input type="text" name="location" id="location" class="form-control"
                               placeholder="Ville, quartier..."
                               value="{{ request('location') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class='bx bx-search'></i> Rechercher
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Catégorie</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="employment_type" class="form-label">Type de contrat</label>
                        <select name="employment_type" id="employment_type" class="form-select">
                            <option value="">Tous les types</option>
                            <option value="full-time" {{ request('employment_type') == 'full-time' ? 'selected' : '' }}>Temps plein</option>
                            <option value="part-time" {{ request('employment_type') == 'part-time' ? 'selected' : '' }}>Temps partiel</option>
                            <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contrat</option>
                            <option value="internship" {{ request('employment_type') == 'internship' ? 'selected' : '' }}>Stage</option>
                            <option value="freelance" {{ request('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <a href="{{ route('jobs.search') }}" class="btn btn-outline-secondary w-100">
                            <i class='bx bx-x'></i> Réinitialiser
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4">
                {{ $jobs->total() }} offre{{ $jobs->total() > 1 ? 's' : '' }} trouvée{{ $jobs->total() > 1 ? 's' : '' }}
            </h2>
        </div>
    </div>

    <!-- Job Listings -->
    @if($jobs->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class='bx bx-search-alt' style="font-size: 64px; color: #6b7280;"></i>
                <h4 class="mt-3">Aucune offre trouvée</h4>
                <p class="text-muted mb-4">Essayez de modifier vos critères de recherche.</p>
                <a href="{{ route('jobs.search') }}" class="btn btn-primary">
                    <i class='bx bx-refresh'></i> Nouvelle recherche
                </a>
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
                                        <a href="{{ route('jobs.show.public', $job->id) }}" class="text-decoration-none text-dark">
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

                                <div class="col-md-3 text-end d-flex align-items-center justify-content-end">
                                    <!-- View Button -->
                                    <a href="{{ route('jobs.show.public', $job->id) }}" class="default-btn">
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
                {{ $jobs->appends(request()->query())->links() }}
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
