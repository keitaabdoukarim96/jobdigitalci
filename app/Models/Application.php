<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'job_offer_id',
        'status',
        'cover_letter',
        'cv_file',
        'recruiter_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Obtenir le candidat qui a postulé
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Obtenir l'offre d'emploi associée
     */
    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }

    /**
     * Obtenir le libellé du statut en français
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'reviewed' => 'Examinée',
            'shortlisted' => 'Présélectionnée',
            'rejected' => 'Rejetée',
            'accepted' => 'Acceptée',
            default => 'Inconnu',
        };
    }

    /**
     * Obtenir la classe CSS du badge selon le statut
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'reviewed' => 'badge-info',
            'shortlisted' => 'badge-primary',
            'rejected' => 'badge-error',
            'accepted' => 'badge-success',
            default => 'badge-ghost',
        };
    }
}
