@extends('layouts.auth')

@section('title', 'Inscription - Sélection du profil')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="auth-container">
                    <!-- Header -->
                    <div class="auth-header-content text-center mb-5">
                        <h2>Besoin de recruter ?</h2>
                        <p class="text-muted">Recevez un maximum de candidatures en diffusant vos offres sur JobDigitalCI.</p>
                        <p class="text-muted mt-3">Selon le type de votre entreprise, vous serez soit redirigé vers une page pour publier votre annonce, soit rappelé par un consultant.</p>
                    </div>

                    <!-- User Type Selection Grid -->
                    <div class="user-type-selection">
                        <!-- Candidate Option First -->
                        <div class="candidate-option text-center mb-5">
                            <h3 class="selection-subtitle mb-4">Vous cherchez un emploi ?</h3>
                            <a href="{{ route('register.form', 'candidat') }}" class="type-card type-card-highlight mx-auto" style="max-width: 450px;">
                                <div class="type-card-content">
                                    <i class='bx bx-user-circle type-icon'></i>
                                    <h4>Candidat en recherche d'emploi</h4>
                                    <p>Créez votre profil et postulez aux offres</p>
                                    <button type="button" class="candidate-cta-btn mt-3">
                                        Créer mon compte candidat
                                        <i class='bx bx-right-arrow-alt'></i>
                                    </button>
                                </div>
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="auth-divider my-5">
                            <span>OU</span>
                        </div>

                        <h3 class="selection-subtitle mb-4">Vous représentez un(e) *</h3>

                        <div class="row g-3">
                            <!-- TPE / Association -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'tpe') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-store-alt type-icon'></i>
                                        <h4>TPE / Association</h4>
                                        <p>Moins de 11 salariés</p>
                                    </div>
                                </a>
                            </div>

                            <!-- PME / ETI -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'pme') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-buildings type-icon'></i>
                                        <h4>PME / ETI</h4>
                                        <p>11 à 250 salariés</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Grande Entreprise -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'grande-entreprise') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-building type-icon'></i>
                                        <h4>Grande Entreprise</h4>
                                        <p>Plus de 250 salariés</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Pro du Recrutement -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'cabinet-recrutement') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-briefcase-alt type-icon'></i>
                                        <h4>Cabinet de Recrutement</h4>
                                        <p>Professionnel RH</p>
                                    </div>
                                </a>
                            </div>

                            <!-- École / Centre de Formation -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'ecole') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-book-reader type-icon'></i>
                                        <h4>École / Centre de Formation</h4>
                                        <p>Établissement d'enseignement</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Administration Publique -->
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('register.form', 'administration') }}" class="type-card">
                                    <div class="type-card-content">
                                        <i class='bx bx-landmark type-icon'></i>
                                        <h4>Administration Publique</h4>
                                        <p>Collectivité / Organisme public</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-5">
                            <p class="mb-0">
                                Vous avez déjà un compte ?
                                <a href="{{ route('login') }}" class="text-primary fw-bold">Se connecter</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Selection Subtitle */
.selection-subtitle {
    font-size: 20px !important;
    font-weight: 600 !important;
    color: var(--dark-text) !important;
    text-align: center;
}

/* User Type Cards */
.user-type-selection {
    margin-top: 0;
}

.type-card {
    display: block;
    background: var(--gray-light);
    border: 2px solid var(--gray-border);
    border-radius: 16px;
    padding: 32px 20px;
    text-align: center;
    text-decoration: none !important;
    transition: all 0.3s ease;
    height: 100%;
    min-height: 200px;
}

.type-card:focus,
.type-card:active {
    text-decoration: none !important;
    outline: none;
}

.type-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-red);
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.03) 0%, rgba(59, 130, 246, 0.03) 100%);
}

.type-card-highlight {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
    border-color: var(--primary-red);
}

.type-card-highlight:hover {
    border-color: var(--primary-red-dark);
}

.type-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.type-icon {
    font-size: 48px;
    color: var(--primary-red);
    margin-bottom: 16px;
    transition: all 0.3s ease;
}

.type-card:hover .type-icon {
    transform: scale(1.1);
    color: var(--secondary-blue);
}

.type-card h4 {
    font-size: 18px !important;
    font-weight: 600 !important;
    color: var(--dark-text) !important;
    margin-bottom: 8px !important;
}

.type-card p {
    font-size: 14px !important;
    color: var(--gray-text) !important;
    margin-bottom: 0 !important;
}

/* Responsive */
@media only screen and (max-width: 991px) {
    .type-card {
        padding: 28px 16px;
        min-height: 180px;
    }

    .type-icon {
        font-size: 42px;
    }

    .type-card h4 {
        font-size: 17px !important;
    }
}

@media only screen and (max-width: 767px) {
    .type-card {
        padding: 24px 16px;
        min-height: 160px;
    }

    .type-icon {
        font-size: 38px;
        margin-bottom: 12px;
    }

    .type-card h4 {
        font-size: 16px !important;
    }

    .type-card p {
        font-size: 13px !important;
    }

    .selection-subtitle {
        font-size: 18px !important;
    }
}

/* Candidate CTA Button - Style Homepage */
.candidate-cta-btn {
    width: auto !important;
    height: auto !important;
    padding: 10px 25px !important;
    font-size: 18px !important;
    font-weight: 500 !important;
    font-family: "Catamaran", sans-serif !important;
    color: #ffffff !important;
    background: #fd1616 !important;
    border: 1px solid transparent !important;
    border-radius: 0 !important;
    cursor: pointer;
    transition: all 0.3s ease !important;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    pointer-events: none; /* Parent <a> handles click */
}

.candidate-cta-btn i {
    font-size: 20px;
    transition: transform 0.3s ease;
}

.type-card-highlight:hover .candidate-cta-btn {
    background: #001935 !important;
    border: 1px solid #ffffff !important;
    color: #ffffff !important;
}

.type-card-highlight:hover .candidate-cta-btn i {
    transform: translateX(4px);
}

@media only screen and (max-width: 767px) {
    .candidate-cta-btn {
        padding: 8px 20px !important;
        font-size: 16px !important;
    }
}

@media only screen and (max-width: 375px) {
    .candidate-cta-btn {
        padding: 8px 18px !important;
        font-size: 15px !important;
    }
}
</style>
@endsection
