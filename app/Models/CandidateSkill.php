<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateSkill extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'level',
        'years_of_experience',
    ];

    protected $casts = [
        'level' => 'integer',
        'years_of_experience' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le libellé du niveau
     */
    public function getLevelLabelAttribute(): string
    {
        return match($this->level) {
            1 => 'Débutant',
            2 => 'Intermédiaire',
            3 => 'Confirmé',
            4 => 'Avancé',
            5 => 'Expert',
            default => 'Non défini',
        };
    }
}
