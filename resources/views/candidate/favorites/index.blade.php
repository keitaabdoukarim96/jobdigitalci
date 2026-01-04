@extends('layouts.dashboard')

@section('title', 'Offres sauvegardées')

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
            <h1 class="h3 mb-2">Offres sauvegardées</h1>
            <p class="text-muted">{{ $favorites->total() }} offres dans vos favoris</p>
        </div>
    </div>

    <!-- Favorites List -->
    @if($favorites->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class='bx bx-heart' style="font-size: 64px; color: #6b7280;"></i>
                <h4 class="mt-3">Aucune offre sauvegardée</h4>
                <p class="text-muted mb-4">Sauvegardez vos offres préférées pour les retrouver facilement</p>
                <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary">
                    <i class='bx bx-search'></i> Rechercher des emplois
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($favorites as $favorite)
                @php
                    $job = $favorite->jobOffer;
                    $hasApplied = $job->hasApplied(auth()->id());
                @endphp

                <div class="col-12">
                    <div class="card favorite-card">
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
                                            <span class="badge bg-light text-dark me-2">
                                                {{ match($job->experience_level) {
                                                    'junior' => 'Junior',
                                                    'intermediate' => 'Intermédiaire',
                                                    'senior' => 'Senior',
                                                    'expert' => 'Expert',
                                                    default => $job->experience_level
                                                } }}
                                            </span>
                                        @endif

                                        @if($hasApplied)
                                            <span class="badge bg-success">
                                                <i class='bx bx-check'></i> Candidature envoyée
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <p class="text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $job->description }}
                                    </p>

                                    <!-- Meta Information -->
                                    <div class="text-muted small">
                                        <i class='bx bx-time'></i> Sauvegardé {{ $favorite->created_at->diffForHumans() }}
                                        @if($job->application_deadline)
                                            • Date limite: {{ $job->application_deadline->format('d/m/Y') }}
                                        @endif
                                        <span class="ms-3"><i class='bx bx-show'></i> {{ $job->views_count }} vues</span>
                                        <span class="ms-2"><i class='bx bx-user'></i> {{ $job->applications_count }} candidatures</span>
                                    </div>
                                </div>

                                <div class="col-md-3 text-end d-flex flex-column gap-2 justify-content-center">
                                    <!-- Action Buttons avec style personnalisé -->
                                    <a href="{{ route('candidate.jobs.show', $job->id) }}" class="default-btn">
                                        Voir l'offre <i class='bx bx-right-arrow-alt'></i>
                                    </a>

                                    <form action="{{ route('candidate.jobs.toggleFavorite', $job->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100" style="border-radius: 8px; padding: 12px 20px; font-weight: 600; transition: all 0.3s ease;">
                                            <i class='bx bx-trash'></i> Retirer des favoris
                                        </button>
                                    </form>
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
                {{ $favorites->links() }}
            </div>
        </div>

        <!-- Quick Actions Card -->
        @if($favorites->total() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-1">Actions rapides</h5>
                                    <p class="text-muted mb-0">Gérez vos offres sauvegardées</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-primary me-2">
                                        <i class='bx bx-search'></i> Trouver plus d'offres
                                    </a>
                                    <a href="{{ route('candidate.applications.index') }}" class="btn btn-primary">
                                        <i class='bx bx-list-ul'></i> Mes candidatures
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

<style>
.favorite-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.favorite-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}
</style>
@endsection
