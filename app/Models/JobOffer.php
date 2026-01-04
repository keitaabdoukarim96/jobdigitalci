<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recruiter_id',
        'category_id',
        'title',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'location',
        'city',
        'is_remote',
        'employment_type',
        'experience_level',
        'salary_min',
        'salary_max',
        'salary_period',
        'salary_negotiable',
        'application_deadline',
        'status',
        'views_count',
        'applications_count',
        'company_name',
        'company_website',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'salary_negotiable' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'application_deadline' => 'date',
        'views_count' => 'integer',
        'applications_count' => 'integer',
    ];

    /**
     * Obtenir le recruteur qui a publié cette offre
     */
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    /**
     * Obtenir la catégorie de cette offre
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    /**
     * Obtenir toutes les candidatures pour cette offre
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_offer_id');
    }

    /**
     * Obtenir tous les favoris pour cette offre
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'job_offer_id');
    }

    /**
     * Vérifier si l'offre est active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
               (!$this->application_deadline || $this->application_deadline->isFuture());
    }

    /**
     * Vérifier si un candidat a déjà postulé
     */
    public function hasApplied(int $candidateId): bool
    {
        return $this->applications()->where('candidate_id', $candidateId)->exists();
    }

    /**
     * Vérifier si un candidat a sauvegardé cette offre
     */
    public function isFavoritedBy(int $candidateId): bool
    {
        return $this->favorites()->where('candidate_id', $candidateId)->exists();
    }
}
