<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    /**
     * Obtenir les offres d'emploi de cette catégorie
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class, 'category_id');
    }
}
