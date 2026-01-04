@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container my-5">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                <i class='bx bx-left-arrow-alt'></i> Retour à l'accueil
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
                    @if($isAuthenticated)
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
                            <a href="{{ route('candidate.jobs.show', $job->id) }}" class="default-btn w-100 mb-3">
                                <i class='bx bx-send'></i> Postuler maintenant
                            </a>
                        @endif
                    @else
                        <!-- Pour les invités -->
                        <div class="alert alert-info mb-3">
                            <i class='bx bx-info-circle'></i>
                            <p class="mb-0 small"><strong>Vous n'êtes pas connecté</strong><br>
                            Postulez en créant votre compte gratuitement</p>
                        </div>

                        <a href="{{ route('jobs.apply.guest', $job->id) }}" class="default-btn w-100 mb-3">
                            <i class='bx bx-send'></i> Postuler à cette offre
                        </a>

                        <p class="text-center small text-muted mb-0">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-primary">Connectez-vous</a>
                        </p>
                    @endif
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
@endsection
