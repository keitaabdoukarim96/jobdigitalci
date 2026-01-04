@extends('layouts.dashboard')

@section('title', 'Tableau de bord Recruteur')

@section('profile-route', route('recruiter.profile'))

@section('sidebar')
    <div class="nav-item">
        <a href="{{ route('recruiter.dashboard') }}" class="nav-link active">
            <i class='bx bx-home-alt'></i>
            <span>Tableau de bord</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('recruiter.jobs.index') }}" class="nav-link">
            <i class='bx bx-briefcase'></i>
            <span>Mes offres</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('recruiter.jobs.create') }}" class="nav-link">
            <i class='bx bx-plus-circle'></i>
            <span>Publier une offre</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-file'></i>
            <span>Candidatures reçues</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('recruiter.profile') }}" class="nav-link">
            <i class='bx bx-building'></i>
            <span>Profil entreprise</span>
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Bienvenue, {{ $user->name }} !</h1>
            <p class="text-muted">Gérez vos offres d'emploi et vos candidatures</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stats-card red">
                <div class="icon">
                    <i class='bx bx-briefcase'></i>
                </div>
                <div class="number">{{ $stats['active_jobs'] }}</div>
                <div class="label">Offres actives</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card blue">
                <div class="icon">
                    <i class='bx bx-file'></i>
                </div>
                <div class="number">{{ $stats['total_applications'] }}</div>
                <div class="label">Candidatures reçues</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card green">
                <div class="icon">
                    <i class='bx bx-file-blank'></i>
                </div>
                <div class="number">{{ $stats['new_applications'] }}</div>
                <div class="label">Nouvelles candidatures</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card orange">
                <div class="icon">
                    <i class='bx bx-show'></i>
                </div>
                <div class="number">{{ $stats['profile_views'] }}</div>
                <div class="label">Vues du profil</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Actions rapides</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('recruiter.jobs.create') }}" class="btn btn-primary w-100">
                                <i class='bx bx-plus-circle'></i> Publier une offre
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('recruiter.jobs.index') }}" class="btn btn-outline-primary w-100">
                                <i class='bx bx-briefcase'></i> Mes offres
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class='bx bx-file'></i> Candidatures
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('recruiter.profile') }}" class="btn btn-outline-primary w-100">
                                <i class='bx bx-building'></i> Mon profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mes offres d'emploi</h5>
                    <a href="{{ route('recruiter.jobs.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="text-center py-5 text-muted">
                        <i class='bx bx-briefcase' style="font-size: 48px;"></i>
                        <p class="mt-3">Vous n'avez pas encore publié d'offres</p>
                        <a href="{{ route('recruiter.jobs.create') }}" class="btn btn-primary mt-2">
                            <i class='bx bx-plus-circle'></i> Publier ma première offre
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Récentes candidatures</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4 text-muted">
                        <i class='bx bx-file' style="font-size: 36px;"></i>
                        <p class="mt-2 mb-0 small">Aucune candidature pour le moment</p>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Conseils</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success'></i>
                            <small>Complétez votre profil entreprise</small>
                        </li>
                        <li class="mb-2">
                            <i class='bx bx-check-circle text-success'></i>
                            <small>Rédigez des offres claires et précises</small>
                        </li>
                        <li class="mb-0">
                            <i class='bx bx-check-circle text-success'></i>
                            <small>Répondez rapidement aux candidats</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-primary {
    background: #fd1616 !important;
    border-color: #fd1616 !important;
}

.btn-primary:hover {
    background: #001935 !important;
    border-color: #001935 !important;
}

.btn-outline-primary {
    color: #fd1616 !important;
    border-color: #fd1616 !important;
}

.btn-outline-primary:hover {
    background: #fd1616 !important;
    border-color: #fd1616 !important;
    color: white !important;
}
</style>
@endsection
