<!-- Section Formations -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class='bx bx-book'></i>
            Formations & Diplômes
        </h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addEducationModal">
            <i class='bx bx-plus'></i> Ajouter
        </button>
    </div>
    <div class="card-body">
        @if($educations->count() > 0)
            @foreach($educations as $edu)
                <div class="education-item mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $edu->degree }}</h6>
                            <p class="mb-1 text-primary">{{ $edu->field_of_study }}</p>
                            <p class="mb-1 text-muted">{{ $edu->institution }}</p>
                            <p class="mb-1 text-muted small">
                                <i class='bx bx-calendar'></i> {{ $edu->period }}
                                @if($edu->location)
                                    | <i class='bx bx-map'></i> {{ $edu->location }}
                                @endif
                            </p>
                            @if($edu->description)
                                <p class="mb-0 mt-2 text-muted small">{{ $edu->description }}</p>
                            @endif
                        </div>
                        <div class="ms-2">
                            <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                    onclick="deleteEducation({{ $edu->id }})">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4 text-muted">
                <i class='bx bx-book' style="font-size: 48px;"></i>
                <p class="mt-2">Aucune formation ajoutée</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                    <i class='bx bx-plus'></i> Ajouter ma formation
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Ajouter Formation -->
<div class="modal fade" id="addEducationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('candidate.educations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une formation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edu_degree" class="form-label">Diplôme *</label>
                            <input type="text" class="form-control" id="edu_degree" name="degree"
                                   placeholder="Ex: Licence, Master, Doctorat" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edu_field_of_study" class="form-label">Domaine d'étude *</label>
                            <input type="text" class="form-control" id="edu_field_of_study" name="field_of_study"
                                   placeholder="Ex: Informatique, Marketing" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edu_institution" class="form-label">École / Université *</label>
                            <input type="text" class="form-control" id="edu_institution" name="institution"
                                   placeholder="Ex: Université Félix Houphouët-Boigny" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edu_location" class="form-label">Localisation</label>
                            <input type="text" class="form-control" id="edu_location" name="location"
                                   placeholder="Ex: Abidjan, Côte d'Ivoire">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edu_start_date" class="form-label">Date de début *</label>
                            <input type="date" class="form-control" id="edu_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edu_end_date" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="edu_end_date" name="end_date">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="edu_is_current" name="is_current" value="1"
                                       onchange="document.getElementById('edu_end_date').disabled = this.checked">
                                <label class="form-check-label" for="edu_is_current">
                                    En cours
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edu_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edu_description" name="description" rows="3"
                                      placeholder="Mention, projets réalisés, etc."></textarea>
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

<form id="deleteEducationForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteEducation(eduId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette formation?')) {
        const form = document.getElementById('deleteEducationForm');
        form.action = `/candidate/educations/${eduId}`;
        form.submit();
    }
}
</script>
