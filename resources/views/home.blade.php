@extends('layouts.app')

@section('title', 'JobDigitalCI - Trouvez votre Emploi dans le Digital en Côte d\'Ivoire')

@section('content')

<!-- Error Messages -->
@if($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<!-- Banner Section Start -->
<div class="banner-section">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="banner-content text-center">
                    <p>Trouvez Emplois, Stages & Missions Freelance dans le Digital</p>
                    <h2>Déposez votre CV & Trouvez Votre Emploi de Rêve !</h2>

                    <form class="banner-form" action="{{ route('jobs.search') }}" method="GET">
                        <!-- Ligne 1: Champs de recherche principaux (Mot-clé et Localisation) -->
                        <div class="row form-row-1 justify-content-center">
                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="keyword"><i class='bx bx-search-alt'></i> Mot-clé</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Poste, compétence...">
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="location"><i class='bx bx-map'></i> Localisation</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Abidjan, Plateau...">
                                </div>
                            </div>
                        </div>

                        <!-- Ligne 2: Filtres Catégories -->
                        <div class="row form-filters">
                            <div class="col-12">
                                <div class="filter-group">
                                    <label class="filter-label"><i class='bx bx-briefcase-alt'></i> Catégories</label>
                                    <div class="filter-buttons">
                                        <input type="radio" id="cat-all" name="category" value="" checked>
                                        <label for="cat-all" class="filter-btn">Toutes</label>

                                        <input type="radio" id="cat-dev" name="category" value="developpement">
                                        <label for="cat-dev" class="filter-btn">Développement</label>

                                        <input type="radio" id="cat-design" name="category" value="design">
                                        <label for="cat-design" class="filter-btn">Design & UX/UI</label>

                                        <input type="radio" id="cat-data" name="category" value="data">
                                        <label for="cat-data" class="filter-btn">Data & IA</label>

                                        <input type="radio" id="cat-marketing" name="category" value="marketing">
                                        <label for="cat-marketing" class="filter-btn">Marketing Digital</label>

                                        <input type="radio" id="cat-devops" name="category" value="devops">
                                        <label for="cat-devops" class="filter-btn">DevOps & Cloud</label>

                                        <input type="radio" id="cat-cyber" name="category" value="cybersecurite">
                                        <label for="cat-cyber" class="filter-btn">Cybersécurité</label>

                                        <input type="radio" id="cat-support" name="category" value="support">
                                        <label for="cat-support" class="filter-btn">Support IT</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ligne 3: Filtres Type de contrat -->
                        <div class="row form-filters">
                            <div class="col-12">
                                <div class="filter-group">
                                    <label class="filter-label"><i class='bx bx-file'></i> Type de contrat</label>
                                    <div class="filter-buttons">
                                        <input type="radio" id="contract-all" name="contract" value="" checked>
                                        <label for="contract-all" class="filter-btn">Tous</label>

                                        <input type="radio" id="contract-cdi" name="contract" value="cdi">
                                        <label for="contract-cdi" class="filter-btn">CDI</label>

                                        <input type="radio" id="contract-cdd" name="contract" value="cdd">
                                        <label for="contract-cdd" class="filter-btn">CDD</label>

                                        <input type="radio" id="contract-stage" name="contract" value="stage">
                                        <label for="contract-stage" class="filter-btn">Stage</label>

                                        <input type="radio" id="contract-freelance" name="contract" value="freelance">
                                        <label for="contract-freelance" class="filter-btn">Freelance</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ligne 4: Bouton de recherche centré -->
                        <div class="row form-row-submit justify-content-center">
                            <div class="col-lg-6 col-md-8 col-12">
                                <button type="submit" class="find-btn">
                                    <i class='bx bx-search'></i>
                                    <span>Rechercher des Offres</span>
                                    <i class='bx bx-right-arrow-alt'></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<!-- Category Section Start -->
<section class="categories-section pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Parcourir par Catégories</h2>
            <p>Explorez les opportunités dans les métiers du digital les plus demandés en Côte d'Ivoire</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-code-alt'></i>
                        </div>
                        <h3>Développement Web</h3>
                        <p class="job-count">245 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-mobile-alt'></i>
                        </div>
                        <h3>Développement Mobile</h3>
                        <p class="job-count">127 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-palette'></i>
                        </div>
                        <h3>UI/UX Design</h3>
                        <p class="job-count">189 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-data'></i>
                        </div>
                        <h3>Data Science & BI</h3>
                        <p class="job-count">98 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-trending-up'></i>
                        </div>
                        <h3>Marketing Digital</h3>
                        <p class="job-count">156 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-camera'></i>
                        </div>
                        <h3>Création de Contenu</h3>
                        <p class="job-count">73 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-server'></i>
                        </div>
                        <h3>DevOps & Cloud</h3>
                        <p class="job-count">64 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <a href="#" class="category-link">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class='bx bx-briefcase-alt-2'></i>
                        </div>
                        <h3>Gestion de Projet IT</h3>
                        <p class="job-count">112 postes ouverts</p>
                        <div class="category-arrow">
                            <i class='bx bx-right-arrow-alt'></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Category Section End -->

<!-- Jobs Section Start -->
<section class="job-section pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Offres d'Emploi Récentes</h2>
            <p>Découvrez les dernières opportunités dans le secteur digital en Côte d'Ivoire</p>
        </div>

        <div class="row justify-content-center">
            @forelse($recentJobs as $job)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="job-card-vertical">
                        <div class="company-logo-top">
                            @if($job->recruiter && $job->recruiter->company_logo)
                                <img src="{{ Storage::url($job->recruiter->company_logo) }}" alt="{{ $job->company_name ?? $job->recruiter->name }}">
                            @else
                                <img src="{{ asset('assets/img/company-logo/default.png') }}" alt="Logo">
                            @endif
                        </div>
                        <h3>
                            <a href="{{ route('jobs.show.public', $job->id) }}">{{ $job->title }}</a>
                        </h3>
                        <div class="job-meta">
                            <span><i class='bx bx-briefcase'></i> {{ $job->company_name ?? $job->recruiter->name }}</span>
                            <span><i class='bx bx-location-plus'></i> {{ $job->location }}</span>
                            <span><i class='bx bx-filter-alt'></i>
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
                        <div class="job-footer">
                            <span class="job-time">Publié {{ $job->created_at->diffForHumans() }}</span>
                            <a href="{{ route('jobs.show.public', $job->id) }}" class="default-btn btn-small">Voir l'offre</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class='bx bx-info-circle' style="font-size: 48px;"></i>
                        <h5 class="mt-3">Aucune offre disponible pour le moment</h5>
                        <p>Revenez bientôt pour découvrir de nouvelles opportunités !</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Bouton Voir Toutes les Offres -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="#" class="default-btn">
                    Voir Toutes les Offres
                    <i class='bx bx-chevron-right'></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Jobs Section End -->

<!-- Way To Use Section Start -->
<section class="how-it-works-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Comment Ça Marche ?</h2>
            <p>Trouvez votre emploi en 4 étapes simples</p>
        </div>

        <div class="row justify-content-center">
            <!-- Étape 1 -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <h3>Créez votre Compte</h3>
                    <p>Inscrivez-vous gratuitement en quelques clics et complétez votre profil professionnel.</p>
                    <div class="step-connector"></div>
                </div>
            </div>

            <!-- Étape 2 -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class='bx bx-cloud-upload'></i>
                    </div>
                    <h3>Téléchargez votre CV</h3>
                    <p>Importez votre CV ou créez-le directement sur notre plateforme avec nos modèles.</p>
                    <div class="step-connector"></div>
                </div>
            </div>

            <!-- Étape 3 -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class='bx bx-search-alt-2'></i>
                    </div>
                    <h3>Recherchez des Offres</h3>
                    <p>Parcourez des centaines d'offres dans le digital et trouvez celle qui vous correspond.</p>
                    <div class="step-connector"></div>
                </div>
            </div>

            <!-- Étape 4 -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class='bx bx-send'></i>
                    </div>
                    <h3>Postulez en Un Clic</h3>
                    <p>Envoyez votre candidature instantanément et suivez son évolution en temps réel.</p>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="#" class="default-btn">
                    Commencer Maintenant
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Way To Use Section End -->

<!-- Why Choose Us Section Start -->
<section class="why-choose-section pt-100 pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="why-choose-content">
                    <div class="section-title">
                        <h2>Pourquoi Choisir JobDigitalCI ?</h2>
                        <p>La plateforme leader pour les talents du digital en Côte d'Ivoire</p>
                    </div>

                    <div class="why-choose-text">
                        <div class="why-item">
                            <div class="why-icon">
                                <i class='bx bx-check-circle'></i>
                            </div>
                            <div class="why-text">
                                <h3>Offres 100% Digitales</h3>
                                <p>Spécialisé exclusivement dans les métiers du numérique : développement, design, data, marketing digital et plus encore.</p>
                            </div>
                        </div>

                        <div class="why-item">
                            <div class="why-icon">
                                <i class='bx bx-check-circle'></i>
                            </div>
                            <div class="why-text">
                                <h3>Entreprises Vérifiées</h3>
                                <p>Toutes les entreprises sont vérifiées pour garantir des opportunités sérieuses et de qualité.</p>
                            </div>
                        </div>

                        <div class="why-item">
                            <div class="why-icon">
                                <i class='bx bx-check-circle'></i>
                            </div>
                            <div class="why-text">
                                <h3>Candidature Rapide</h3>
                                <p>Postulez en un clic avec votre profil pré-rempli et suivez vos candidatures en temps réel.</p>
                            </div>
                        </div>

                        <div class="why-item">
                            <div class="why-icon">
                                <i class='bx bx-check-circle'></i>
                            </div>
                            <div class="why-text">
                                <h3>Alertes Personnalisées</h3>
                                <p>Recevez des notifications pour les offres qui correspondent à votre profil et vos compétences.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="why-choose-img">
                    <img src="{{ asset('assets/img/why-choose-us.jpg') }}" alt="Développeur africain" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Us Section End -->

<!-- Companies Section Start -->
<section class="company-section pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Entreprises qui Recrutent</h2>
            <p>Rejoignez les meilleures entreprises tech de Côte d'Ivoire</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/1.png') }}" alt="TechCorp">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">TechCorp Africa</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Plateau
                        </p>
                        <a href="#" class="default-btn btn-small">
                            12 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/2.png') }}" alt="Digital Hub">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">Digital Innovation Hub</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Cocody
                        </p>
                        <a href="#" class="default-btn btn-small">
                            8 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/3.png') }}" alt="Banque Atlantique">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">Banque Atlantique CI</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Plateau
                        </p>
                        <a href="#" class="default-btn btn-small">
                            5 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/4.png') }}" alt="Orange">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">Orange Digital Center</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Marcory
                        </p>
                        <a href="#" class="default-btn btn-small">
                            15 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/5.png') }}" alt="MTN">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">MTN Côte d'Ivoire</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Cocody
                        </p>
                        <a href="#" class="default-btn btn-small">
                            10 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/6.png') }}" alt="Jumia">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">Jumia Côte d'Ivoire</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Yopougon
                        </p>
                        <a href="#" class="default-btn btn-small">
                            7 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/7.png') }}" alt="Wave">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">Wave Mobile Money</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Plateau
                        </p>
                        <a href="#" class="default-btn btn-small">
                            6 postes ouverts
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="company-card">
                    <div class="company-logo">
                        <a href="#">
                            <img src="{{ asset('assets/img/company-logo/8.png') }}" alt="Startup">
                        </a>
                    </div>
                    <div class="company-text">
                        <h3>
                            <a href="#">CinetPay</a>
                        </h3>
                        <p>
                            <i class='bx bx-location-plus'></i>
                            Abidjan, Marcory
                        </p>
                        <a href="#" class="default-btn btn-small">
                            4 postes ouverts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Companies Section End -->

<!-- Subscribe Section Start -->
<section class="subscribe-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="subscribe-text">
                    <h2>Recevez les Nouvelles Offres par Email</h2>
                    <p>Inscrivez-vous à notre newsletter et ne ratez aucune opportunité dans le digital</p>
                </div>
            </div>

            <div class="col-lg-6">
                <form class="newsletter-form">
                    <input type="email" class="form-control" placeholder="Votre adresse email" required>
                    <button class="default-btn" type="submit">
                        S'abonner
                        <i class='bx bx-envelope'></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Subscribe Section End -->

@endsection
