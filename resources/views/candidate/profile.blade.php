@extends('layouts.dashboard')

@section('title', 'Mon Profil')

@section('profile-route', route('candidate.profile'))

@section('sidebar')
    <div class="nav-item">
        <a href="{{ route('candidate.dashboard') }}" class="nav-link">
            <i class='bx bx-home-alt'></i>
            <span>Tableau de bord</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-search'></i>
            <span>Rechercher un emploi</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-file'></i>
            <span>Mes candidatures</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class='bx bx-bookmark'></i>
            <span>Offres sauvegardées</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('candidate.profile') }}" class="nav-link active">
            <i class='bx bx-user'></i>
            <span>Mon profil</span>
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Mon Profil</h1>
            <p class="text-muted mb-0">Complétez votre profil pour maximiser vos chances</p>
        </div>
        <div>
            <span class="badge bg-{{ $profile->profile_completeness >= 80 ? 'success' : ($profile->profile_completeness >= 50 ? 'warning' : 'danger') }} px-3 py-2">
                <i class='bx bx-pie-chart-alt-2'></i>
                Profil complété à {{ $profile->profile_completeness }}%
            </span>
        </div>
    </div>

    <div class="row">
        <!-- Colonne Principale -->
        <div class="col-lg-8">
            <!-- Informations Personnelles -->
            <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-user'></i>
                            Informations Personnelles
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name" name="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       placeholder="Votre prénom">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name" name="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
                                       placeholder="Votre nom">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                       id="date_of_birth" name="date_of_birth"
                                       value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Genre</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Sélectionnez...</option>
                                    <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Homme</option>
                                    <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Femme</option>
                                    <option value="other" {{ old('gender', $profile->gender) == 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone"
                                       value="{{ old('phone', $profile->phone) }}"
                                       placeholder="+225 XX XX XX XX XX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nationality" class="form-label">Nationalité</label>
                                <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                       id="nationality" name="nationality"
                                       value="{{ old('nationality', $profile->nationality) }}"
                                       placeholder="Ex: Ivoirienne">
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="address" class="form-label">Adresse</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       id="address" name="address"
                                       value="{{ old('address', $profile->address) }}"
                                       placeholder="Rue, quartier">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                       id="city" name="city"
                                       value="{{ old('city', $profile->city) }}"
                                       placeholder="Abidjan">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton Enregistrer pour Informations Personnelles -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Profil Professionnel -->
            <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-briefcase'></i>
                            Profil Professionnel
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="title" class="form-label">Titre Professionnel *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title"
                                       value="{{ old('title', $profile->title) }}"
                                       placeholder="Ex: Développeur Full Stack, Designer UI/UX">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="bio" class="form-label">Biographie</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror"
                                          id="bio" name="bio" rows="4"
                                          placeholder="Présentez-vous en quelques lignes...">{{ old('bio', $profile->bio) }}</textarea>
                                <small class="text-muted">Maximum 1000 caractères</small>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="experience_level" class="form-label">Niveau d'expérience</label>
                                <select class="form-select @error('experience_level') is-invalid @enderror"
                                        id="experience_level" name="experience_level">
                                    <option value="">Sélectionnez...</option>
                                    <option value="junior" {{ old('experience_level', $profile->experience_level) == 'junior' ? 'selected' : '' }}>Junior (0-2 ans)</option>
                                    <option value="intermediate" {{ old('experience_level', $profile->experience_level) == 'intermediate' ? 'selected' : '' }}>Intermédiaire (2-5 ans)</option>
                                    <option value="senior" {{ old('experience_level', $profile->experience_level) == 'senior' ? 'selected' : '' }}>Senior (5-10 ans)</option>
                                    <option value="expert" {{ old('experience_level', $profile->experience_level) == 'expert' ? 'selected' : '' }}>Expert (10+ ans)</option>
                                </select>
                                @error('experience_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expected_salary" class="form-label">Salaire Attendu (FCFA/mois)</label>
                                <input type="number" class="form-control @error('expected_salary') is-invalid @enderror"
                                       id="expected_salary" name="expected_salary"
                                       value="{{ old('expected_salary', $profile->expected_salary) }}"
                                       placeholder="Ex: 500000">
                                @error('expected_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="availability" class="form-label">Disponibilité</label>
                                <select class="form-select @error('availability') is-invalid @enderror"
                                        id="availability" name="availability">
                                    <option value="immediately" {{ old('availability', $profile->availability) == 'immediately' ? 'selected' : '' }}>Immédiatement</option>
                                    <option value="1month" {{ old('availability', $profile->availability) == '1month' ? 'selected' : '' }}>Sous 1 mois</option>
                                    <option value="2months" {{ old('availability', $profile->availability) == '2months' ? 'selected' : '' }}>Sous 2 mois</option>
                                    <option value="3months" {{ old('availability', $profile->availability) == '3months' ? 'selected' : '' }}>Sous 3 mois</option>
                                </select>
                                @error('availability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Préférences</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="open_to_remote"
                                           name="open_to_remote" value="1"
                                           {{ old('open_to_remote', $profile->open_to_remote) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="open_to_remote">
                                        <i class='bx bx-home'></i> Télétravail
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="open_to_relocation"
                                           name="open_to_relocation" value="1"
                                           {{ old('open_to_relocation', $profile->open_to_relocation) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="open_to_relocation">
                                        <i class='bx bx-map'></i> Mobilité
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton Enregistrer pour Profil Professionnel -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Réseaux Sociaux -->
            <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-link'></i>
                            Liens Professionnels
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="linkedin_url" class="form-label">
                                    <i class='bx bxl-linkedin-square'></i> LinkedIn
                                </label>
                                <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                       id="linkedin_url" name="linkedin_url"
                                       value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                                       placeholder="https://linkedin.com/in/...">
                                @error('linkedin_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="github_url" class="form-label">
                                    <i class='bx bxl-github'></i> GitHub
                                </label>
                                <input type="url" class="form-control @error('github_url') is-invalid @enderror"
                                       id="github_url" name="github_url"
                                       value="{{ old('github_url', $profile->github_url) }}"
                                       placeholder="https://github.com/...">
                                @error('github_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="portfolio_url" class="form-label">
                                    <i class='bx bx-globe'></i> Portfolio
                                </label>
                                <input type="url" class="form-control @error('portfolio_url') is-invalid @enderror"
                                       id="portfolio_url" name="portfolio_url"
                                       value="{{ old('portfolio_url', $profile->portfolio_url) }}"
                                       placeholder="https://monportfolio.com">
                                @error('portfolio_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="twitter_url" class="form-label">
                                    <i class='bx bxl-twitter'></i> Twitter / X
                                </label>
                                <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                                       id="twitter_url" name="twitter_url"
                                       value="{{ old('twitter_url', $profile->twitter_url) }}"
                                       placeholder="https://twitter.com/...">
                                @error('twitter_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton Enregistrer pour Réseaux Sociaux -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save'></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Compétences -->
            @include('candidate.partials.skills-section')

                <!-- Expériences -->
                @include('candidate.partials.experiences-section')

                <!-- Formations -->
                @include('candidate.partials.educations-section')
            </div>

            <!-- Colonne Latérale -->
            <div class="col-lg-4">
                <!-- Photo de Profil -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-image'></i>
                            Photo de Profil
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($profile->profile_photo)
                                <img src="{{ asset('storage/' . $profile->profile_photo) }}" id="preview-photo"
                                     alt="Photo de profil"
                                     class="rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" id="preview-photo"
                                     style="width: 150px; height: 150px;">
                                    <i class='bx bx-user' style="font-size: 64px; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <form id="photo-upload-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control @error('profile_photo') is-invalid @enderror"
                                   id="profile_photo_input" name="profile_photo" accept="image/*">
                            <small class="text-muted d-block mt-1">Max: 2MB (JPG, PNG, GIF)</small>
                            @error('profile_photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div id="photo-upload-status" class="mt-2"></div>
                        </form>
                    </div>
                </div>

                <!-- CV -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class='bx bx-file'></i>
                            Mon CV
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($profile->cv_file)
                            <div class="alert alert-success mb-3" id="cv-status">
                                <i class='bx bx-check-circle'></i>
                                CV téléchargé
                                <a href="{{ asset('storage/' . $profile->cv_file) }}"
                                   target="_blank" class="alert-link d-block mt-1">
                                    <i class='bx bx-download'></i> Télécharger
                                </a>
                            </div>
                        @else
                            <div id="cv-status"></div>
                        @endif
                        <form id="cv-upload-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" class="form-control @error('cv_file') is-invalid @enderror"
                                   id="cv_file_input" name="cv_file" accept=".pdf,.doc,.docx">
                            <small class="text-muted d-block mt-1">Max: 5MB (PDF, DOC, DOCX)</small>
                            @error('cv_file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div id="cv-upload-status" class="mt-2"></div>
                        </form>
                    </div>
                </div>

                <!-- Bouton Retour au dashboard -->
                <a href="{{ route('candidate.dashboard') }}" class="btn btn-outline-secondary w-100">
                    <i class='bx bx-arrow-back'></i>
                    Retour au dashboard
                </a>
            </div>
        </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.card-header {
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    padding: 1.25rem 1.5rem;
}

.card-title {
    font-weight: 600;
    color: var(--primary-dark, #001935);
}

.card-title i {
    color: var(--primary-red, #fd1616);
    margin-right: 8px;
}

.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #e0e0e0;
    padding: 0.625rem 0.875rem;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-red, #fd1616);
    box-shadow: 0 0 0 0.2rem rgba(253, 22, 22, 0.1);
}

.btn-primary {
    background-color: var(--primary-red, #fd1616);
    border-color: var(--primary-red, #fd1616);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #e01414;
    border-color: #e01414;
}

.btn-outline-secondary {
    border-color: #ddd;
    color: #666;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #ddd;
    color: #333;
}

.badge {
    font-weight: 500;
    font-size: 0.875rem;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.form-check-input:checked {
    background-color: var(--primary-red, #fd1616);
    border-color: var(--primary-red, #fd1616);
}
</style>

@push('scripts')
<script>
    // Upload automatique de la photo de profil
    document.getElementById('profile_photo_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Vérifier la taille (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            document.getElementById('photo-upload-status').innerHTML =
                '<div class="alert alert-danger">La photo ne doit pas dépasser 2MB</div>';
            return;
        }

        // Afficher un loader
        document.getElementById('photo-upload-status').innerHTML =
            '<div class="text-primary"><i class="bx bx-loader-alt bx-spin"></i> Upload en cours...</div>';

        // Créer FormData et envoyer via AJAX
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("candidate.profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('photo-upload-status').innerHTML =
                    '<div class="alert alert-success"><i class="bx bx-check-circle"></i> Photo mise à jour!</div>';

                // Actualiser l'aperçu de la photo
                if (data.photo_url) {
                    const preview = document.getElementById('preview-photo');
                    preview.outerHTML = `<img src="${data.photo_url}" id="preview-photo"
                        alt="Photo de profil" class="rounded-circle"
                        style="width: 150px; height: 150px; object-fit: cover;">`;
                }

                // Masquer le message après 3 secondes
                setTimeout(() => {
                    document.getElementById('photo-upload-status').innerHTML = '';
                }, 3000);
            } else {
                document.getElementById('photo-upload-status').innerHTML =
                    '<div class="alert alert-danger">Erreur lors de l\'upload</div>';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('photo-upload-status').innerHTML =
                '<div class="alert alert-danger">Erreur lors de l\'upload</div>';
        });
    });

    // Upload automatique du CV
    document.getElementById('cv_file_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Vérifier la taille (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            document.getElementById('cv-upload-status').innerHTML =
                '<div class="alert alert-danger">Le CV ne doit pas dépasser 5MB</div>';
            return;
        }

        // Afficher un loader
        document.getElementById('cv-upload-status').innerHTML =
            '<div class="text-primary"><i class="bx bx-loader-alt bx-spin"></i> Upload en cours...</div>';

        // Créer FormData et envoyer via AJAX
        const formData = new FormData();
        formData.append('cv_file', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("candidate.profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cv-upload-status').innerHTML =
                    '<div class="alert alert-success"><i class="bx bx-check-circle"></i> CV mis à jour!</div>';

                // Actualiser l'affichage du CV
                if (data.cv_url) {
                    document.getElementById('cv-status').innerHTML =
                        `<div class="alert alert-success mb-3">
                            <i class='bx bx-check-circle'></i> CV téléchargé
                            <a href="${data.cv_url}" target="_blank" class="alert-link d-block mt-1">
                                <i class='bx bx-download'></i> Télécharger
                            </a>
                        </div>`;
                }

                // Masquer le message après 3 secondes
                setTimeout(() => {
                    document.getElementById('cv-upload-status').innerHTML = '';
                }, 3000);
            } else {
                document.getElementById('cv-upload-status').innerHTML =
                    '<div class="alert alert-danger">Erreur lors de l\'upload</div>';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('cv-upload-status').innerHTML =
                '<div class="alert alert-danger">Erreur lors de l\'upload</div>';
        });
    });
</script>
@endpush
@endsection
