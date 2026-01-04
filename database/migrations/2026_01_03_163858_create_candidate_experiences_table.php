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
        Schema::create('candidate_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('job_title'); // Intitulé du poste
            $table->string('company_name'); // Nom de l'entreprise
            $table->string('location')->nullable(); // Ville, Pays
            $table->string('employment_type')->nullable(); // CDI, CDD, Freelance, Stage
            $table->date('start_date');
            $table->date('end_date')->nullable(); // null = poste actuel
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable(); // Description des missions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_experiences');
    }
};
