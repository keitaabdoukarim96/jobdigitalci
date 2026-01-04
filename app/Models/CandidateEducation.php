<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CandidateEducation extends Model
{
    protected $table = 'candidate_educations';

    protected $fillable = [
        'user_id',
        'degree',
        'field_of_study',
        'institution',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir la période formatée
     */
    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->format('Y');
        $end = $this->is_current ? 'En cours' : $this->end_date->format('Y');

        return "{$start} - {$end}";
    }
}
