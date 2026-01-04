<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Box Icon CSS-->
        <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
        <!-- Auth Custom CSS - Design moderne et responsive -->
        <link rel="stylesheet" href="{{ asset('assets/css/auth-custom.css') }}">

        <!-- Title -->
        <title>@yield('title', 'Authentification') - JobDigitalCI</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

        @stack('styles')
    </head>

    <body>

        <!-- Simple Header with Logo Only -->
        <div class="auth-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 text-center py-4">
                        <a href="{{ route('home') }}" class="auth-logo">
                            <span class="logo-text">JobDigital<span class="text-red">CI</span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="auth-content">
            @yield('content')
        </main>

        <!-- Simple Footer -->
        <div class="auth-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center py-4">
                        <p class="mb-0">&copy; {{ date('Y') }} JobDigitalCI. Tous droits réservés</p>
                        <div class="mt-2">
                            <a href="{{ route('home') }}" class="text-muted me-3">Accueil</a>
                            <a href="#" class="text-muted me-3">CGU</a>
                            <a href="#" class="text-muted">Confidentialité</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jquery Min JS -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- Bootstrap Bundle Min JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Custom JS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>

        @stack('scripts')
    </body>
</html>
