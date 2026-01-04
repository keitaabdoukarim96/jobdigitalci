<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'phone',
        'address',
        'city',
        'postal_code',
        'title',
        'bio',
        'experience_level',
        'expected_salary',
        'availability',
        'open_to_remote',
        'open_to_relocation',
        'profile_photo',
        'cv_file',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'twitter_url',
        'profile_completeness',
        'profile_views',
        'last_active_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'expected_salary' => 'decimal:2',
        'open_to_remote' => 'boolean',
        'open_to_relocation' => 'boolean',
        'profile_completeness' => 'integer',
        'profile_views' => 'integer',
        'last_active_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculer le pourcentage de complétion du profil
     */
    public function calculateCompleteness(): int
    {
        $fields = [
            'first_name', 'last_name', 'date_of_birth', 'gender', 'phone',
            'city', 'title', 'bio', 'experience_level', 'profile_photo', 'cv_file'
        ];

        $completed = 0;
        $total = count($fields);

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        // Ajouter des points bonus pour les sections supplémentaires
        if ($this->user->skills()->count() > 0) $completed += 0.5;
        if ($this->user->experiences()->count() > 0) $completed += 0.5;
        if ($this->user->educations()->count() > 0) $completed += 0.5;

        $total += 1.5; // Ajuster le total pour les bonus

        return (int) round(($completed / $total) * 100);
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
