@extends('layouts.app')

@section('title', 'Postuler à ' . $job->title)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('jobs.show.public', $job->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class='bx bx-left-arrow-alt'></i> Retour à l'offre
                </a>
            </div>

            <!-- Job Summary Card -->
            <div class="card mb-4 border-primary">
                <div class="card-body">
                    <h5 class="mb-2">
                        <i class='bx bx-briefcase text-primary'></i> {{ $job->title }}
                    </h5>
                    <p class="text-muted mb-0">
                        <i class='bx bx-buildings'></i> {{ $job->company_name ?? $job->recruiter->name }}
                        <span class="ms-3"><i class='bx bx-map'></i> {{ $job->location }}</span>
                    </p>
                </div>
            </div>

            <!-- Application Form Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class='bx bx-user-plus'></i> Créer votre compte et postuler
                    </h4>
                    <p class="mb-0 small mt-2">Remplissez ce formulaire pour créer votre compte et envoyer votre candidature en une seule étape</p>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erreur:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('jobs.apply.guest.submit', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Informations Personnelles -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class='bx bx-user text-primary'></i> Vos informations personnelles
                            </h5>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        Nom complet <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required placeholder="Ex: Jean Kouassi">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        Adresse email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required placeholder="exemple@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class='bx bx-info-circle'></i> Cette adresse sera utilisée pour vous connecter
                                    </small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">
                                        Téléphone <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" required placeholder="+225 XX XX XX XX XX">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">
                                        Mot de passe <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                           required placeholder="Minimum 8 caractères">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        Confirmer le mot de passe <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                           required placeholder="Retapez votre mot de passe">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Votre Candidature -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class='bx bx-file text-primary'></i> Votre candidature
                            </h5>

                            <!-- CV Upload -->
                            <div class="mb-3">
                                <label for="cv_file" class="form-label fw-bold">
                                    <i class='bx bx-file-blank text-primary'></i> Votre CV <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx"
                                       class="form-control @error('cv_file') is-invalid @enderror" required>
                                @error('cv_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class='bx bx-info-circle'></i> Format PDF, DOC ou DOCX - Maximum 5 Mo
                                </small>
                            </div>

                            <!-- Cover Letter -->
                            <div class="mb-3">
                                <label for="cover_letter" class="form-label fw-bold">
                                    <i class='bx bx-edit-alt text-primary'></i> Lettre de motivation (optionnel)
                                </label>
                                <textarea name="cover_letter" id="cover_letter" rows="6"
                                          class="form-control @error('cover_letter') is-invalid @enderror"
                                          placeholder="Expliquez pourquoi vous êtes le candidat idéal pour ce poste...&#10;&#10;Parlez de vos compétences, votre expérience et votre motivation pour rejoindre cette entreprise.">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class='bx bx-info-circle'></i> Recommandé mais non obligatoire - Minimum 50 caractères si fournie
                                </small>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-success" role="alert">
                            <i class='bx bx-check-circle'></i>
                            <strong>Ce qui va se passer ensuite :</strong>
                            <ul class="mb-0 mt-2">
                                <li>Votre compte sera créé automatiquement</li>
                                <li>Votre candidature sera envoyée au recruteur</li>
                                <li>Vous serez connecté à votre espace personnel</li>
                                <li>Vous pourrez suivre l'évolution de votre candidature</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('jobs.show.public', $job->id) }}" class="btn btn-outline-secondary" style="border-radius: 8px; padding: 12px 24px; font-weight: 600;">
                                <i class='bx bx-x'></i> Annuler
                            </a>
                            <button type="submit" class="default-btn">
                                <i class='bx bx-send'></i> Créer mon compte et postuler
                            </button>
                        </div>
                    </form>

                    <!-- Already have account link -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-primary fw-bold">
                                <i class='bx bx-log-in'></i> Connectez-vous
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header.bg-primary {
    background: linear-gradient(135deg, #052c65 0%, #0a4395 100%) !important;
}
</style>
@endsection
