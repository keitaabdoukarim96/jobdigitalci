<!-- Section Expériences -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class='bx bx-briefcase'></i>
            Expériences Professionnelles
        </h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
            <i class='bx bx-plus'></i> Ajouter
        </button>
    </div>
    <div class="card-body">
        @if($experiences->count() > 0)
            @foreach($experiences as $exp)
                <div class="experience-item mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $exp->job_title }}</h6>
                            <p class="mb-1 text-primary">{{ $exp->company_name }}</p>
                            <p class="mb-1 text-muted small">
                                <i class='bx bx-calendar'></i> {{ $exp->period }}
                                @if($exp->location)
                                    | <i class='bx bx-map'></i> {{ $exp->location }}
                                @endif
                            </p>
                            @if($exp->employment_type)
                                <span class="badge bg-secondary mb-2">{{ $exp->employment_type }}</span>
                            @endif
                            @if($exp->description)
                                <p class="mb-0 mt-2 text-muted small">{{ $exp->description }}</p>
                            @endif
                        </div>
                        <div class="ms-2">
                            <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                    onclick="deleteExperience({{ $exp->id }})">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4 text-muted">
                <i class='bx bx-briefcase' style="font-size: 48px;"></i>
                <p class="mt-2">Aucune expérience ajoutée</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
                    <i class='bx bx-plus'></i> Ajouter mon expérience
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Ajouter Expérience -->
<div class="modal fade" id="addExperienceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('candidate.experiences.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une expérience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exp_job_title" class="form-label">Intitulé du poste *</label>
                            <input type="text" class="form-control" id="exp_job_title" name="job_title"
                                   placeholder="Ex: Développeur Web" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_company_name" class="form-label">Entreprise *</label>
                            <input type="text" class="form-control" id="exp_company_name" name="company_name"
                                   placeholder="Ex: Orange CI" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_location" class="form-label">Localisation</label>
                            <input type="text" class="form-control" id="exp_location" name="location"
                                   placeholder="Ex: Abidjan, Côte d'Ivoire">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_employment_type" class="form-label">Type de contrat</label>
                            <select class="form-select" id="exp_employment_type" name="employment_type">
                                <option value="">Sélectionnez...</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Stage">Stage</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Alternance">Alternance</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_start_date" class="form-label">Date de début *</label>
                            <input type="date" class="form-control" id="exp_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exp_end_date" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="exp_end_date" name="end_date">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="exp_is_current" name="is_current" value="1"
                                       onchange="document.getElementById('exp_end_date').disabled = this.checked">
                                <label class="form-check-label" for="exp_is_current">
                                    Poste actuel
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="exp_description" class="form-label">Description</label>
                            <textarea class="form-control" id="exp_description" name="description" rows="4"
                                      placeholder="Décrivez vos missions et réalisations..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="deleteExperienceForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteExperience(expId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette expérience?')) {
        const form = document.getElementById('deleteExperienceForm');
        form.action = `/candidate/experiences/${expId}`;
        form.submit();
    }
}
</script>
