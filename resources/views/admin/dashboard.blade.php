@extends('layouts.dashboard')

@section('title', 'Tableau de bord Admin')

@section('profile-route', '#')

@section('sidebar')
    <div class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
            <i class='bx bx-home-alt'></i>
            <span>Tableau de bord</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link">
            <i class='bx bx-group'></i>
            <span>Utilisateurs</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.recruiters.pending') }}" class="nav-link">
            <i class='bx bx-time-five'></i>
            <span>Recruteurs en attente</span>
            @if($stats['pending_recruiters'] > 0)
                <span class="badge bg-danger ms-auto">{{ $stats['pending_recruiters'] }}</span>
            @endif
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-briefcase'></i>
            <span>Offres d'emploi</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-file'></i>
            <span>Candidatures</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-cog'></i>
            <span>Paramètres</span>
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-2">Tableau de bord Administrateur</h1>
            <p class="text-muted">Vue d'ensemble de la plateforme JobDigitalCI</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stats-card red">
                <div class="icon">
                    <i class='bx bx-group'></i>
                </div>
                <div class="number">{{ $stats['total_users'] }}</div>
                <div class="label">Total utilisateurs</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card blue">
                <div class="icon">
                    <i class='bx bx-user'></i>
                </div>
                <div class="number">{{ $stats['total_candidates'] }}</div>
                <div class="label">Candidats</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card green">
                <div class="icon">
                    <i class='bx bx-building'></i>
                </div>
                <div class="number">{{ $stats['total_recruiters'] }}</div>
                <div class="label">Recruteurs</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card orange">
                <div class="icon">
                    <i class='bx bx-time-five'></i>
                </div>
                <div class="number">{{ $stats['pending_recruiters'] }}</div>
                <div class="label">En attente de validation</div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stats-card blue">
                <div class="icon">
                    <i class='bx bx-briefcase'></i>
                </div>
                <div class="number">{{ $stats['total_jobs'] }}</div>
                <div class="label">Offres d'emploi</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stats-card green">
                <div class="icon">
                    <i class='bx bx-file'></i>
                </div>
                <div class="number">{{ $stats['total_applications'] }}</div>
                <div class="label">Candidatures</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if($stats['pending_recruiters'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class='bx bx-info-circle fs-4 me-3'></i>
                <div class="flex-grow-1">
                    <strong>Action requise !</strong>
                    Vous avez {{ $stats['pending_recruiters'] }} recruteur(s) en attente de validation.
                </div>
                <a href="{{ route('admin.recruiters.pending') }}" class="btn btn-warning btn-sm">
                    Voir les demandes
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recruteurs en attente de validation</h5>
                    <a href="{{ route('admin.recruiters.pending') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @if($stats['pending_recruiters'] > 0)
                        <div class="text-center py-4">
                            <i class='bx bx-time-five' style="font-size: 48px; color: #f97316;"></i>
                            <p class="mt-3 mb-3">{{ $stats['pending_recruiters'] }} demande(s) en attente</p>
                            <a href="{{ route('admin.recruiters.pending') }}" class="btn btn-primary">
                                <i class='bx bx-check-circle'></i> Traiter les demandes
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class='bx bx-check-circle' style="font-size: 48px;"></i>
                            <p class="mt-3 mb-0">Aucune demande en attente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                            <i class='bx bx-group'></i> Gérer les utilisateurs
                        </a>
                        <a href="{{ route('admin.recruiters.pending') }}" class="btn btn-outline-primary">
                            <i class='bx bx-time-five'></i> Valider les recruteurs
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class='bx bx-briefcase'></i> Gérer les offres
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class='bx bx-cog'></i> Paramètres
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistiques rapides</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Candidats</span>
                            <span class="fw-bold small">{{ $stats['total_candidates'] }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $stats['total_users'] > 0 ? ($stats['total_candidates'] / $stats['total_users'] * 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Recruteurs</span>
                            <span class="fw-bold small">{{ $stats['total_recruiters'] }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $stats['total_users'] > 0 ? ($stats['total_recruiters'] / $stats['total_users'] * 100) : 0 }}%"></div>
                        </div>
                    </div>
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

.sidebar-nav .nav-link .badge {
    font-size: 11px;
    padding: 3px 6px;
}
</style>
@endsection
