@extends('layouts.dashboard')

@section('title', $job->title)

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
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class='bx bx-left-arrow-alt'></i> Retour aux offres
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content - Job Details -->
        <div class="col-lg-8 mb-4">
            <!-- Job Header Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="h2 mb-3">{{ $job->title }}</h1>

                    <p class="h5 text-muted mb-4">
                        <i class='bx bx-buildings'></i>
                        {{ $job->company_name ?? $job->recruiter->name }}
                    </p>

                    <!-- Badges -->
                    <div class="mb-4">
                        @if($job->category)
                            <span class="badge bg-primary me-2 mb-2">
                                <i class='bx {{ $job->category->icon }}'></i>
                                {{ $job->category->name }}
                            </span>
                        @endif

                        <span class="badge bg-secondary me-2 mb-2">
                            <i class='bx bx-map'></i>
                            {{ $job->location }}
                        </span>

                        @if($job->is_remote)
                            <span class="badge bg-success me-2 mb-2">
                                <i class='bx bx-laptop'></i>
                                Télétravail possible
                            </span>
                        @endif
                    </div>

                    <!-- Job Info Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <small class="text-muted">Type:</small>
                            <p class="fw-bold mb-0">
                                {{ match($job->employment_type) {
                                    'full-time' => 'Temps plein',
                                    'part-time' => 'Temps partiel',
                                    'contract' => 'Contrat',
                                    'internship' => 'Stage',
                                    'freelance' => 'Freelance',
                                    default => $job->employment_type
                                } }}
                            </p>
                        </div>

                        @if($job->experience_level)
                            <div class="col-md-3">
                                <small class="text-muted">Niveau:</small>
                                <p class="fw-bold mb-0">
                                    {{ match($job->experience_level) {
                                        'junior' => 'Junior',
                                        'intermediate' => 'Intermédiaire',
                                        'senior' => 'Senior',
                                        'expert' => 'Expert',
                                        default => $job->experience_level
                                    } }}
                                </p>
                            </div>
                        @endif

                        @if($job->salary_min || $job->salary_max)
                            <div class="col-md-3">
                                <small class="text-muted">Salaire:</small>
                                <p class="fw-bold text-primary mb-0">
                                    @if($job->salary_min && $job->salary_max)
                                        {{ number_format($job->salary_min, 0, ',', ' ') }} - {{ number_format($job->salary_max, 0, ',', ' ') }}
                                    @elseif($job->salary_min)
                                        {{ number_format($job->salary_min, 0, ',', ' ') }}+
                                    @else
                                        {{ number_format($job->salary_max, 0, ',', ' ') }}
                                    @endif
                                    FCFA
                                </p>
                            </div>
                        @endif

                        @if($job->application_deadline)
                            <div class="col-md-3">
                                <small class="text-muted">Date limite:</small>
                                <p class="fw-bold mb-0">{{ $job->application_deadline->format('d/m/Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="d-flex gap-4 pt-3 border-top">
                        <small class="text-muted"><i class='bx bx-show'></i> {{ $job->views_count }} vues</small>
                        <small class="text-muted"><i class='bx bx-user'></i> {{ $job->applications_count }} candidatures</small>
                        <small class="text-muted"><i class='bx bx-time'></i> Publié {{ $job->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Description du poste</h5>
                </div>
                <div class="card-body">
                    <p>{{ $job->description }}</p>
                </div>
            </div>

            <!-- Responsibilities -->
            @if($job->responsibilities)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Responsabilités</h5>
                    </div>
                    <div class="card-body">
                        <p style="white-space: pre-line;">{{ $job->responsibilities }}</p>
                    </div>
                </div>
            @endif

            <!-- Requirements -->
            @if($job->requirements)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Exigences</h5>
                    </div>
                    <div class="card-body">
                        <p style="white-space: pre-line;">{{ $job->requirements }}</p>
                    </div>
                </div>
            @endif

            <!-- Benefits -->
            @if($job->benefits)
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Avantages</h5>
                    </div>
                    <div class="card-body">
                        <p style="white-space: pre-line;">{{ $job->benefits }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - Actions -->
        <div class="col-lg-4">
            <div class="card mb-4 sticky-top" style="top: 90px;">
                <div class="card-body">
                    @if($hasApplied)
                        <div class="alert alert-success">
                            <i class='bx bx-check-circle' style="font-size: 24px;"></i>
                            <h6 class="fw-bold mt-2">Candidature envoyée</h6>
                            <small>Vous avez déjà postulé à cette offre</small>
                        </div>
                        <a href="{{ route('candidate.applications.index') }}" class="btn btn-outline-primary w-100">
                            <i class='bx bx-list-ul'></i> Voir mes candidatures
                        </a>
                    @else
                        <button type="button" class="btn btn-primary w-100 btn-lg mb-3" data-bs-toggle="modal" data-bs-target="#applicationModal">
                            <i class='bx bx-send'></i> Postuler maintenant
                        </button>
                    @endif

                    <!-- Favorite Button -->
                    <form action="{{ route('candidate.jobs.toggleFavorite', $job->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            @if($isFavorited)
                                <i class='bx bxs-heart text-danger'></i> Retirer des favoris
                            @else
                                <i class='bx bx-heart'></i> Sauvegarder l'offre
                            @endif
                        </button>
                    </form>

                    <!-- Share Button -->
                    <button type="button" class="btn btn-outline-secondary w-100">
                        <i class='bx bx-share-alt'></i> Partager
                    </button>
                </div>
            </div>

            <!-- Company Info -->
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">À propos de l'entreprise</h6>
                </div>
                <div class="card-body">
                    <p class="fw-bold">{{ $job->company_name ?? $job->recruiter->name }}</p>

                    @if($job->company_website)
                        <a href="{{ $job->company_website }}" target="_blank" class="btn btn-link p-0">
                            <i class='bx bx-link-external'></i> Visiter le site web
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalLabel">Postuler à {{ $job->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('candidate.jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Cover Letter -->
                    <div class="mb-3">
                        <label for="cover_letter" class="form-label fw-bold">
                            Lettre de motivation <span class="text-danger">*</span>
                        </label>
                        <textarea name="cover_letter" id="cover_letter" rows="8"
                                  class="form-control @error('cover_letter') is-invalid @enderror"
                                  placeholder="Expliquez pourquoi vous êtes le candidat idéal pour ce poste..." required>{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Minimum 50 caractères</small>
                    </div>

                    <!-- CV Upload -->
                    <div class="mb-3">
                        <label for="cv_file" class="form-label fw-bold">CV (optionnel)</label>
                        <input type="file" name="cv_file" id="cv_file" accept=".pdf"
                               class="form-control @error('cv_file') is-invalid @enderror">
                        @error('cv_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format PDF uniquement, max 5 Mo. Si vous ne téléchargez pas de CV, celui de votre profil sera utilisé.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-send'></i> Envoyer ma candidature
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    <script>
        // Open modal automatically if validation errors
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('applicationModal'));
            myModal.show();
        });
    </script>
@endif

@endsection
