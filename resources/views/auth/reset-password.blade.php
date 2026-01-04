@extends('layouts.auth')

@section('title', 'Réinitialiser le Mot de Passe')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="auth-container">
                    <!-- Header with Icon -->
                    <div class="auth-header-content text-center mb-4">
                        <div class="mb-3">
                            <i class='bx bx-key' style="font-size: 64px; color: var(--primary-red);"></i>
                        </div>
                        <h2>Réinitialiser le Mot de Passe</h2>
                        <p class="text-muted">Choisissez un nouveau mot de passe sécurisé pour votre compte</p>
                    </div>

                    <!-- Reset Password Form -->
                    <div class="auth-form-container">
                        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

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
                                       value="{{ old('email', $email) }}"
                                       required
                                       autofocus>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group">
                                <label for="password">
                                    <i class='bx bx-lock-alt'></i>
                                    Nouveau Mot de Passe
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Min. 8 caractères"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation">
                                    <i class='bx bx-lock-alt'></i>
                                    Confirmer le Mot de Passe
                                </label>
                                <div class="password-input-wrapper">
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="Confirmer le mot de passe"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="default-btn w-100 mb-3">
                                Réinitialiser le Mot de Passe
                                <i class='bx bx-check'></i>
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
