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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('job_categories')->onDelete('set null');

            // Informations de base
            $table->string('title');
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();

            // Localisation
            $table->string('location');
            $table->string('city')->nullable();
            $table->boolean('is_remote')->default(false);

            // Type et contrat
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'internship', 'freelance'])->default('full-time');
            $table->enum('experience_level', ['junior', 'intermediate', 'senior', 'expert'])->nullable();

            // Salaire
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->enum('salary_period', ['hour', 'day', 'month', 'year'])->default('month');
            $table->boolean('salary_negotiable')->default(false);

            // Dates et statut
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'active', 'closed', 'expired'])->default('active');
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);

            // Informations entreprise
            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index pour performance
            $table->index('status');
            $table->index('category_id');
            $table->index('city');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
