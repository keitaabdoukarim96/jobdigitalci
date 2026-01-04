<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifier la colonne role pour supporter admin, candidate, recruiter
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retour à l'état précédent si nécessaire
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NOT NULL");
    }
};
