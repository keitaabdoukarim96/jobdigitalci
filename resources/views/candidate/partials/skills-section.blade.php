<!-- Section Compétences -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class='bx bx-code-alt'></i>
            Mes Compétences
        </h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addSkillModal">
            <i class='bx bx-plus'></i> Ajouter
        </button>
    </div>
    <div class="card-body">
        @if($skills->count() > 0)
            <div class="row">
                @foreach($skills as $skill)
                    <div class="col-md-6 mb-3">
                        <div class="skill-item p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $skill->name }}</h6>
                                    @if($skill->category)
                                        <span class="badge bg-secondary mb-2">{{ $skill->category }}</span>
                                    @endif
                                    <div class="mb-2">
                                        <small class="text-muted">Niveau:</small>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: {{ ($skill->level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $skill->level_label }}</small>
                                    </div>
                                    @if($skill->years_of_experience)
                                        <small class="text-muted">
                                            <i class='bx bx-time'></i> {{ $skill->years_of_experience }} an(s) d'expérience
                                        </small>
                                    @endif
                                </div>
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                            onclick="deleteSkill({{ $skill->id }})">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class='bx bx-code-alt' style="font-size: 48px;"></i>
                <p class="mt-2">Aucune compétence ajoutée</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                    <i class='bx bx-plus'></i> Ajouter ma première compétence
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal Ajouter Compétence -->
<div class="modal fade" id="addSkillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('candidate.skills.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une compétence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="skill_name" class="form-label">Nom de la compétence *</label>
                        <input type="text" class="form-control" id="skill_name" name="name"
                               placeholder="Ex: PHP, JavaScript, React" required>
                    </div>
                    <div class="mb-3">
                        <label for="skill_category" class="form-label">Catégorie</label>
                        <select class="form-select" id="skill_category" name="category">
                            <option value="">Sélectionnez...</option>
                            <option value="programming">Programmation</option>
                            <option value="design">Design</option>
                            <option value="management">Management</option>
                            <option value="marketing">Marketing</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="skill_level" class="form-label">Niveau *</label>
                        <select class="form-select" id="skill_level" name="level" required>
                            <option value="1">Débutant</option>
                            <option value="2">Intermédiaire</option>
                            <option value="3" selected>Confirmé</option>
                            <option value="4">Avancé</option>
                            <option value="5">Expert</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="skill_years" class="form-label">Années d'expérience</label>
                        <input type="number" class="form-control" id="skill_years" name="years_of_experience"
                               min="0" placeholder="Ex: 3">
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

<form id="deleteSkillForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteSkill(skillId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette compétence?')) {
        const form = document.getElementById('deleteSkillForm');
        form.action = `/candidate/skills/${skillId}`;
        form.submit();
    }
}
</script>

<style>
.skill-item {
    background-color: #f8f9fa;
    transition: all 0.3s;
}

.skill-item:hover {
    background-color: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.progress-bar {
    background-color: var(--primary-red, #fd1616);
}
</style>
