@extends('layouts.auth')

@section('title', 'Mot de Passe Oublié')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container">
                    <!-- Header with Icon -->
                    <div class="auth-header-content text-center mb-4">
                        <div class="mb-3">
                            <i class='bx bx-lock-open' style="font-size: 64px; color: var(--primary-red);"></i>
                        </div>
                        <h2>Mot de Passe Oublié?</h2>
                        <p class="text-muted">
                            Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons
                            un lien de réinitialisation de mot de passe.
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            <i class='bx bx-check-circle'></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Forgot Password Form -->
                    <div class="auth-form-container">
                        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
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

                            <!-- Submit Button -->
                            <button type="submit" class="default-btn w-100 mb-4">
                                Envoyer le Lien de Réinitialisation
                                <i class='bx bx-paper-plane'></i>
                            </button>

                            <!-- Back to Login Link -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-primary d-inline-flex align-items-center gap-2">
                                    <i class='bx bx-arrow-back'></i>
                                    Retour à la connexion
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
