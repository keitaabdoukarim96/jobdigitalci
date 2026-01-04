@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="auth-container">
                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('register.selection') }}" class="text-primary d-inline-flex align-items-center gap-2">
                            <i class='bx bx-arrow-back'></i>
                            Retour à la sélection
                        </a>
                    </div>

                    <!-- Header -->
                    <div class="auth-header-content text-center mb-4">
                        @if($type === 'candidat')
                            <div class="mb-3">
                                <i class='bx bx-user-circle' style="font-size: 64px; color: var(--primary-red);"></i>
                            </div>
                            <h2>Créer mon Profil Candidat</h2>
                            <p class="text-muted">Rejoignez JobDigitalCI et postulez aux meilleures offres du digital en Côte d'Ivoire</p>
                        @else
                            <div class="mb-3">
                                <i class='bx bx-briefcase' style="font-size: 64px; color: var(--primary-red);"></i>
                            </div>
                            <h2>Créer mon Compte Recruteur</h2>
                            <p class="text-muted">
                                @switch($type)
                                    @case('tpe')
                                        Inscription pour TPE / Association (moins de 11 salariés)
                                        @break
                                    @case('pme')
                                        Inscription pour PME / ETI (11 à 250 salariés)
                                        @break
                                    @case('grande-entreprise')
                                        Inscription pour Grande Entreprise (plus de 250 salariés)
                                        @break
                                    @case('cabinet-recrutement')
                                        Inscription pour Cabinet de Recrutement
                                        @break
                                    @case('ecole')
                                        Inscription pour École / Centre de Formation
                                        @break
                                    @case('administration')
                                        Inscription pour Administration Publique
                                        @break
                                @endswitch
                            </p>
                        @endif
                    </div>

                    <!-- Registration Form -->
                    <div class="auth-form-container">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- Hidden Fields -->
                            <input type="hidden" name="role" value="{{ $role }}">
                            <input type="hidden" name="user_type" value="{{ $type }}">

                            @if($type === 'candidat')
                                <!-- FORMULAIRE CANDIDAT -->

                                <!-- Nom et Prénom -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">
                                                <i class='bx bx-user'></i>
                                                Prénom
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('first_name') is-invalid @enderror"
                                                   id="first_name"
                                                   name="first_name"
                                                   placeholder="Ex: Jean"
                                                   value="{{ old('first_name') }}"
                                                   required>
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">
                                                <i class='bx bx-user'></i>
                                                Nom
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   id="last_name"
                                                   name="last_name"
                                                   placeholder="Ex: Kouassi"
                                                   value="{{ old('last_name') }}"
                                                   required>
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

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
                                           required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="form-group">
                                    <label for="phone">
                                        <i class='bx bx-phone'></i>
                                        Téléphone
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           placeholder="Ex: +225 07 XX XX XX XX"
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            @else
                                <!-- FORMULAIRE RECRUTEUR -->

                                <!-- Nom de l'entreprise / Structure -->
                                <div class="form-group">
                                    <label for="company_name">
                                        <i class='bx bx-buildings'></i>
                                        @if($type === 'administration')
                                            Nom de l'Administration / Organisme
                                        @elseif($type === 'ecole')
                                            Nom de l'École / Centre de Formation
                                        @elseif($type === 'cabinet-recrutement')
                                            Nom du Cabinet de Recrutement
                                        @else
                                            Nom de l'Entreprise
                                        @endif
                                    </label>
                                    <input type="text"
                                           class="form-control @error('company_name') is-invalid @enderror"
                                           id="company_name"
                                           name="company_name"
                                           placeholder="Ex: Orange Côte d'Ivoire"
                                           value="{{ old('company_name') }}"
                                           required>
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contact Principal -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_name">
                                                <i class='bx bx-user'></i>
                                                Nom du Contact
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('contact_name') is-invalid @enderror"
                                                   id="contact_name"
                                                   name="contact_name"
                                                   placeholder="Ex: Marie Koné"
                                                   value="{{ old('contact_name') }}"
                                                   required>
                                            @error('contact_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_title">
                                                <i class='bx bx-briefcase-alt'></i>
                                                Fonction
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('contact_title') is-invalid @enderror"
                                                   id="contact_title"
                                                   name="contact_title"
                                                   placeholder="Ex: DRH"
                                                   value="{{ old('contact_title') }}"
                                                   required>
                                            @error('contact_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Email professionnel -->
                                <div class="form-group">
                                    <label for="email">
                                        <i class='bx bx-envelope'></i>
                                        Email Professionnel
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           placeholder="Ex: recrutement@entreprise.ci"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="form-group">
                                    <label for="phone">
                                        <i class='bx bx-phone'></i>
                                        Téléphone Professionnel
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           placeholder="Ex: +225 27 XX XX XX XX"
                                           value="{{ old('phone') }}"
                                           required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Ville / Localisation -->
                                <div class="form-group">
                                    <label for="city">
                                        <i class='bx bx-map'></i>
                                        Ville
                                    </label>
                                    <select class="form-control @error('city') is-invalid @enderror"
                                            id="city"
                                            name="city"
                                            required>
                                        <option value="">Sélectionnez une ville</option>
                                        <option value="Abidjan" {{ old('city') === 'Abidjan' ? 'selected' : '' }}>Abidjan</option>
                                        <option value="Yamoussoukro" {{ old('city') === 'Yamoussoukro' ? 'selected' : '' }}>Yamoussoukro</option>
                                        <option value="Bouaké" {{ old('city') === 'Bouaké' ? 'selected' : '' }}>Bouaké</option>
                                        <option value="San-Pédro" {{ old('city') === 'San-Pédro' ? 'selected' : '' }}>San-Pédro</option>
                                        <option value="Daloa" {{ old('city') === 'Daloa' ? 'selected' : '' }}>Daloa</option>
                                        <option value="Korhogo" {{ old('city') === 'Korhogo' ? 'selected' : '' }}>Korhogo</option>
                                        <option value="Man" {{ old('city') === 'Man' ? 'selected' : '' }}>Man</option>
                                        <option value="Autre">Autre ville</option>
                                    </select>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <!-- Password (commun aux deux) -->
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>

                                <div class="col-md-6">
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
                                                   placeholder="Confirmer"
                                                   required>
                                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                                <i class='bx bx-show'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input @error('terms') is-invalid @enderror"
                                       type="checkbox"
                                       id="terms"
                                       name="terms"
                                       required>
                                <label class="form-check-label" for="terms">
                                    J'accepte les <a href="#" class="text-primary">Conditions Générales d'Utilisation</a>
                                    et la <a href="#" class="text-primary">Politique de Confidentialité</a>
                                </label>
                                @error('terms')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="default-btn w-100 mb-3">
                                Créer mon compte
                                <i class='bx bx-right-arrow-alt'></i>
                            </button>

                            <!-- Login Link -->
                            <div class="text-center mt-4">
                                <p class="mb-0">
                                    Vous avez déjà un compte?
                                    <a href="{{ route('login') }}" class="text-primary fw-bold">Se connecter</a>
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
