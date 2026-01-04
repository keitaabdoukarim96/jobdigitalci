<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'candidate_id',
        'job_offer_id',
    ];

    /**
     * Obtenir le candidat qui a sauvegardé cette offre
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Obtenir l'offre d'emploi sauvegardée
     */
    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }
}
