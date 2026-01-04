<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CandidateExperience extends Model
{
    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'location',
        'employment_type',
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
     * Obtenir la durée de l'expérience
     */
    public function getDurationAttribute(): string
    {
        $start = Carbon::parse($this->start_date);
        $end = $this->is_current ? Carbon::now() : Carbon::parse($this->end_date);

        $years = $start->diffInYears($end);
        $months = $start->copy()->addYears($years)->diffInMonths($end);

        if ($years > 0 && $months > 0) {
            return "{$years} an" . ($years > 1 ? 's' : '') . " et {$months} mois";
        } elseif ($years > 0) {
            return "{$years} an" . ($years > 1 ? 's' : '');
        } else {
            return "{$months} mois";
        }
    }

    /**
     * Obtenir la période formatée
     */
    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Présent' : $this->end_date->format('M Y');

        return "{$start} - {$end}";
    }
}
