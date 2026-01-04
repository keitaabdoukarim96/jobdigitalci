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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informations personnelles
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->default('Ivoirienne');

            // Coordonnées
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();

            // Profil professionnel
            $table->string('title')->nullable(); // Titre professionnel (ex: Développeur Full Stack)
            $table->text('bio')->nullable(); // Courte biographie
            $table->string('experience_level')->nullable(); // junior, intermediate, senior, expert
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->string('availability')->default('immediately'); // immediately, 1month, 2months, 3months
            $table->boolean('open_to_remote')->default(true);
            $table->boolean('open_to_relocation')->default(false);

            // Documents
            $table->string('profile_photo')->nullable();
            $table->string('cv_file')->nullable();

            // Réseaux sociaux
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('twitter_url')->nullable();

            // Statistiques
            $table->integer('profile_completeness')->default(0); // Pourcentage de complétion du profil
            $table->integer('profile_views')->default(0);
            $table->timestamp('last_active_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
