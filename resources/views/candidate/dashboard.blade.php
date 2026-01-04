@extends('layouts.dashboard')

@section('title', 'Tableau de bord Candidat')

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
            <h1 class="h3 mb-2">Bienvenue, {{ $user->name }} !</h1>
            <p class="text-muted">Voici un aperçu de votre activité sur JobDigitalCI</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stats-card red">
                <div class="icon">
                    <i class='bx bx-file'></i>
                </div>
                <div class="number">{{ $stats['applications'] }}</div>
                <div class="label">Candidatures envoyées</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card blue">
                <div class="icon">
                    <i class='bx bx-bookmark'></i>
                </div>
                <div class="number">{{ $stats['saved_jobs'] }}</div>
                <div class="label">Offres sauvegardées</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card green">
                <div class="icon">
                    <i class='bx bx-show'></i>
                </div>
                <div class="number">{{ $stats['profile_views'] }}</div>
                <div class="label">Vues de profil</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card orange">
                <div class="icon">
                    <i class='bx bx-briefcase'></i>
                </div>
                <div class="number">{{ $stats['new_jobs'] }}</div>
                <div class="label">Nouvelles offres</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Offres recommandées pour vous</h5>
                    <a href="{{ route('candidate.jobs.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($recommendedJobs->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class='bx bx-briefcase' style="font-size: 48px;"></i>
                            <p class="mt-3">Aucune offre recommandée pour le moment</p>
                            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary mt-2">
                                <i class='bx bx-search'></i> Rechercher des emplois
                            </a>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recommendedJobs as $job)
                                <a href="{{ route('candidate.jobs.show', $job->id) }}" class="list-group-item list-group-item-action border-0 px-0 py-3">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 fw-bold">{{ $job->title }}</h6>
                                            <p class="mb-2 text-muted small">
                                                <i class='bx bx-buildings'></i> {{ $job->company_name ?? $job->recruiter->name }}
                                                <span class="ms-3"><i class='bx bx-map'></i> {{ $job->location }}</span>
                                            </p>
                                            <div>
                                                @if($job->category)
                                                    <span class="badge bg-primary me-2">
                                                        <i class='bx {{ $job->category->icon }}'></i> {{ $job->category->name }}
                                                    </span>
                                                @endif
                                                <span class="badge bg-light text-dark">
                                                    {{ match($job->employment_type) {
                                                        'full-time' => 'Temps plein',
                                                        'part-time' => 'Temps partiel',
                                                        'contract' => 'Contrat',
                                                        'internship' => 'Stage',
                                                        'freelance' => 'Freelance',
                                                        default => $job->employment_type
                                                    } }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-end ms-3">
                                            <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Complétez votre profil</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Progression</span>
                            <span class="fw-bold">{{ $profile->profile_completeness }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar {{ $profile->profile_completeness >= 80 ? 'bg-success' : ($profile->profile_completeness >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                 role="progressbar"
                                 style="width: {{ $profile->profile_completeness }}%"></div>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">
                        <a href="{{ route('candidate.profile') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class='bx bx-user-circle text-primary'></i> Ajouter une photo
                        </a>
                        <a href="{{ route('candidate.profile') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class='bx bx-file text-primary'></i> Télécharger votre CV
                        </a>
                        <a href="{{ route('candidate.profile') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class='bx bx-briefcase text-primary'></i> Ajouter votre expérience
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
