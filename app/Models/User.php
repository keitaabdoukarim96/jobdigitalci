<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'phone',
        'is_validated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_validated' => 'boolean',
        ];
    }

    /**
     * Relation avec le profil candidat
     */
    public function candidateProfile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class);
    }

    /**
     * Relation avec les compétences
     */
    public function skills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class);
    }

    /**
     * Relation avec les expériences
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(CandidateExperience::class);
    }

    /**
     * Relation avec les formations
     */
    public function educations(): HasMany
    {
        return $this->hasMany(CandidateEducation::class);
    }

    /**
     * Relation avec les offres d'emploi publiées (pour les recruteurs)
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class, 'recruiter_id');
    }

    /**
     * Relation avec les candidatures (pour les candidats)
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    /**
     * Relation avec les favoris (pour les candidats)
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'candidate_id');
    }

    /**
     * Vérifier si l'utilisateur est un candidat
     */
    public function isCandidate(): bool
    {
        return $this->role === 'candidate';
    }

    /**
     * Vérifier si l'utilisateur est un recruteur
     */
    public function isRecruiter(): bool
    {
        return $this->role === 'recruiter';
    }

    /**
     * Vérifier si l'utilisateur est un admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
