<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_offer_id')->constrained('job_offers')->onDelete('cascade');

            // Statut de la candidature
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected', 'accepted'])->default('pending');

            // Lettre de motivation
            $table->text('cover_letter')->nullable();

            // CV spécifique pour cette candidature (optionnel, sinon utilise le CV du profil)
            $table->string('cv_file')->nullable();

            // Notes du recruteur
            $table->text('recruiter_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Un candidat ne peut postuler qu'une fois à la même offre
            $table->unique(['candidate_id', 'job_offer_id']);

            // Index pour performance
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
