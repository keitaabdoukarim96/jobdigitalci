<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <!-- Owl Carousel Theme Default CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
        <!-- Box Icon CSS-->
        <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
        <!-- Flaticon CSS-->
        <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/flaticon.css') }}">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <!-- Custom JobDigitalCI CSS - REMPLACE les couleurs du template -->
        <link rel="stylesheet" href="{{ asset('assets/css/jobdigitalci-custom.css') }}">
        <!-- Dark CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/dark.css') }}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

        <!-- Title -->
        <title>@yield('title', 'JobDigitalCI - Plateforme d\'Emploi Digital en Côte d\'Ivoire')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

        @stack('styles')
    </head>

    <body>

        <!-- Pre-loader Start -->
        <div class="loader-content">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="sk-circle">
                        <div class="sk-circle1 sk-child"></div>
                        <div class="sk-circle2 sk-child"></div>
                        <div class="sk-circle3 sk-child"></div>
                        <div class="sk-circle4 sk-child"></div>
                        <div class="sk-circle5 sk-child"></div>
                        <div class="sk-circle6 sk-child"></div>
                        <div class="sk-circle7 sk-child"></div>
                        <div class="sk-circle8 sk-child"></div>
                        <div class="sk-circle9 sk-child"></div>
                        <div class="sk-circle10 sk-child"></div>
                        <div class="sk-circle11 sk-child"></div>
                        <div class="sk-circle12 sk-child"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader End -->

        <!-- Navbar Area Start -->
        <div class="navbar-area">
            <!-- Menu For Mobile Device -->
            <div class="mobile-nav">
                <a href="{{ route('home') }}" class="logo logo-text">
                    JobDigital<span>CI</span>
                </a>
            </div>

            <!-- Menu For Desktop Device -->
            <div class="main-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand navbar-brand-text" href="{{ route('home') }}">
                            JobDigital<span>CI</span>
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                        Accueil
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link dropdown-toggle">Offres D'Emploi</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Trouver un Emploi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Publier une Offre</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link dropdown-toggle">Entreprises</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Toutes les Entreprises</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Espace Recruteur</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">Nos Tarifs</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">À Propos</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">Contact</a>
                                </li>
                            </ul>

                            <div class="other-option">
                                <a href="#" class="default-btn btn-outline">S'inscrire</a>
                                <a href="#" class="default-btn">Connexion</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar Area End -->

        <!-- Main Content -->
        @yield('content')
        <!-- End Main Content -->

        <!-- Footer Area Start -->
        <footer class="footer-area pt-100 pb-70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}" class="logo-text">
                                    JobDigital<span>CI</span>
                                </a>
                            </div>

                            <p style="margin-top: 20px;">JobDigitalCI est la première plateforme dédiée aux métiers du digital en Côte d'Ivoire. Trouvez votre emploi de rêve dans la tech africaine.</p>

                            <div class="footer-social">
                                <a href="https://www.facebook.com/" target="_blank"><i class='bx bxl-facebook'></i></a>
                                <a href="https://twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a>
                                <a href="https://www.linkedin.com/" target="_blank"><i class='bx bxl-linkedin'></i></a>
                                <a href="https://www.instagram.com/" target="_blank"><i class='bx bxl-instagram'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget pl-60">
                            <h3>Pour les Candidats</h3>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Parcourir les Offres
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Mon Compte
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Catégories d'Emploi
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Créer mon CV
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Alertes Emploi
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Conseils Carrière
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget pl-60">
                            <h3>Pour les Recruteurs</h3>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Publier une Offre
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Parcourir les CV
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Nos Tarifs
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Espace Entreprise
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        FAQ Recruteurs
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Nous Contacter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="footer-widget">
                            <h3>Informations</h3>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        À Propos
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Contactez-nous
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Blog & Actualités
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Conditions d'Utilisation
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Politique de Confidentialité
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bx-chevrons-right bx-tada'></i>
                                        Mentions Légales
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Area End -->

        <!-- Copy Right Area Start -->
        <div class="copyright-area">
            <div class="container">
                <div class="copyright-item">
                    <p>&copy; {{ date('Y') }} JobDigitalCI. Tous droits réservés - Propulsé par <a href="https://www.jobdigitalci.com" target="_blank">JobDigitalCI</a></p>
                </div>
            </div>
        </div>
        <!-- Copy Right Area End -->

        <!-- Jquery Min JS -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Meanmenu JS -->
        <script src="{{ asset('assets/js/meanmenu.js') }}"></script>
        <!-- Owl Carousel JS -->
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <!-- Nice Select JS -->
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <!-- Magnific Popup JS -->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!-- Form Validator JS -->
        <script src="{{ asset('assets/js/form-validator.min.js') }}"></script>
        <!-- Contact JS -->
        <script src="{{ asset('assets/js/contact-form-script.js') }}"></script>
        <!-- Ajaxchimp JS -->
        <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
        <!-- Custom JS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        <!-- Fix Preloader - Force Hide -->
        <script>
            // Force hide preloader after page load
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const loader = document.querySelector('.loader-content');
                    if (loader) {
                        loader.style.display = 'none';
                    }
                }, 500);
            });

            // Backup: Hide after 3 seconds max
            setTimeout(function() {
                const loader = document.querySelector('.loader-content');
                if (loader) {
                    loader.style.display = 'none';
                }
            }, 3000);
        </script>

        @stack('scripts')
    </body>
</html>
