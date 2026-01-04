@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container">
                    <!-- Header -->
                    <div class="auth-header-content text-center mb-4">
                        <h2>Bienvenue sur JobDigitalCI</h2>
                        <p class="text-muted">Connectez-vous pour accéder à votre espace personnel</p>
                    </div>

                    <!-- Login Form -->
                    <div class="auth-form-container">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">
                                    <i class='bx bx-envelope'></i>
                                    Adresse Email
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       placeholder="Ex: jean.kouassi@exemple.com"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">
                                    <i class='bx bx-lock-alt'></i>
                                    Mot de Passe
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Votre mot de passe"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remember"
                                           name="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-primary">
                                    Mot de passe oublié?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="default-btn w-100 mb-3">
                                Se connecter
                                <i class='bx bx-right-arrow-alt'></i>
                            </button>

                            <!-- Divider -->
                            <div class="auth-divider">
                                <span>OU</span>
                            </div>

                            <!-- Social Login -->
                            <div class="social-login-buttons">
                                <button type="button" class="social-btn google-btn">
                                    <i class='bx bxl-google'></i>
                                    Se connecter avec Google
                                </button>
                                <button type="button" class="social-btn linkedin-btn">
                                    <i class='bx bxl-linkedin'></i>
                                    Se connecter avec LinkedIn
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center mt-4">
                                <p class="mb-0">
                                    Vous n'avez pas encore de compte?
                                    <a href="{{ route('register') }}" class="text-primary fw-bold">S'inscrire</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.closest('.password-input-wrapper').querySelector('.password-toggle');
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    } else {
        input.type = 'password';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    }
}
</script>
@endpush
