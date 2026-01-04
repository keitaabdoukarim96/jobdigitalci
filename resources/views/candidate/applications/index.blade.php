@extends('layouts.dashboard')

@section('title', 'Mes candidatures')

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
            <h1 class="h3 mb-2">Mes candidatures</h1>
            <p class="text-muted">Suivez l'état de vos {{ $applications->total() }} candidatures</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if($applications->total() > 0)
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card red">
                    <div class="icon">
                        <i class='bx bx-file'></i>
                    </div>
                    <div class="number">{{ $applications->total() }}</div>
                    <div class="label">Total candidatures</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card orange">
                    <div class="icon">
                        <i class='bx bx-time-five'></i>
                    </div>
                    <div class="number">{{ auth()->user()->applications()->where('status', 'pending')->count() }}</div>
                    <div class="label">En attente</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card blue">
                    <div class="icon">
                        <i class='bx bx-star'></i>
                    </div>
                    <div class="number">{{ auth()->user()->applications()->where('status', 'shortlisted')->count() }}</div>
                    <div class="label">Présélectionnées</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card green">
                    <div class="icon">
                        <i class='bx bx-check'></i>
                    </div>
                    <div class="number">{{ auth()->user()->applications()->where('status', 'accepted')->count() }}</div>
                    <div class="label">Acceptées</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Applications List -->
    @if($applications->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class='bx bx-folder-open' style="font-size: 64px; color: #6b7280;"></i>
                <h4 class="mt-3">Aucune candidature pour le moment</h4>
                <p class="text-muted mb-4">Commencez à postuler aux offres qui vous intéressent</p>
                <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary">
                    <i class='bx bx-search'></i> Rechercher des emplois
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($applications as $application)
                <div class="col-12">
                    <div class="card application-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Job Title -->
                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('candidate.jobs.show', $application->jobOffer->id) }}" class="text-decoration-none text-dark">
                                            {{ $application->jobOffer->title }}
                                        </a>
                                    </h5>

                                    <!-- Company -->
                                    <p class="text-muted mb-3">
                                        <i class='bx bx-buildings'></i>
                                        {{ $application->jobOffer->company_name ?? $application->jobOffer->recruiter->name }}
                                    </p>

                                    <!-- Badges -->
                                    <div class="mb-3">
                                        @if($application->jobOffer->category)
                                            <span class="badge bg-primary me-2">
                                                <i class='bx {{ $application->jobOffer->category->icon }}'></i>
                                                {{ $application->jobOffer->category->name }}
                                            </span>
                                        @endif

                                        <span class="badge bg-secondary me-2">
                                            <i class='bx bx-map'></i>
                                            {{ $application->jobOffer->location }}
                                        </span>

                                        <!-- Status Badge -->
                                        <span class="badge {{ match($application->status) {
                                            'pending' => 'bg-warning',
                                            'reviewed' => 'bg-info',
                                            'shortlisted' => 'bg-primary',
                                            'rejected' => 'bg-danger',
                                            'accepted' => 'bg-success',
                                            default => 'bg-secondary'
                                        } }}">
                                            @switch($application->status)
                                                @case('pending')
                                                    <i class='bx bx-time-five'></i> En attente
                                                    @break
                                                @case('reviewed')
                                                    <i class='bx bx-show'></i> Examinée
                                                    @break
                                                @case('shortlisted')
                                                    <i class='bx bx-star'></i> Présélectionnée
                                                    @break
                                                @case('rejected')
                                                    <i class='bx bx-x'></i> Rejetée
                                                    @break
                                                @case('accepted')
                                                    <i class='bx bx-check'></i> Acceptée
                                                    @break
                                            @endswitch
                                        </span>
                                    </div>

                                    <!-- Collapse for Cover Letter -->
                                    @if($application->cover_letter)
                                        <div class="accordion" id="accordion{{ $application->id }}">
                                            <div class="accordion-item border-0">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $application->id }}">
                                                        <small>Voir ma lettre de motivation</small>
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $application->id }}" class="accordion-collapse collapse" data-bs-parent="#accordion{{ $application->id }}">
                                                    <div class="accordion-body bg-light">
                                                        <small style="white-space: pre-line;">{{ $application->cover_letter }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Recruiter Notes -->
                                    @if($application->recruiter_notes && in_array($application->status, ['reviewed', 'shortlisted', 'rejected', 'accepted']))
                                        <div class="alert alert-info mt-3 mb-0">
                                            <strong><i class='bx bx-info-circle'></i> Notes du recruteur:</strong>
                                            <p class="mb-0 mt-2">{{ $application->recruiter_notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4 text-end">
                                    <!-- Application Date -->
                                    <div class="text-muted small mb-2">
                                        <i class='bx bx-time'></i> Postulé {{ $application->created_at->diffForHumans() }}
                                    </div>

                                    @if($application->reviewed_at)
                                        <div class="text-muted small mb-3">
                                            <i class='bx bx-check-double'></i> Examiné {{ $application->reviewed_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    <!-- CV Link -->
                                    @if($application->cv_file)
                                        <a href="{{ Storage::url($application->cv_file) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2 w-100">
                                            <i class='bx bx-download'></i> Mon CV
                                        </a>
                                    @endif

                                    <!-- View Job Button -->
                                    <a href="{{ route('candidate.jobs.show', $application->jobOffer->id) }}" class="btn btn-primary btn-sm w-100">
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
                {{ $applications->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.application-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.application-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
