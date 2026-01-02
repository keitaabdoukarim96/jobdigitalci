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
        Schema::create('recruiter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->text('company_description')->nullable();
            $table->string('sector', 100);
            $table->enum('size', ['1-10', '11-50', '51-200', '201-500', '500+']);
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->default('Cote d Ivoire');

            // Statut de validation admin (NOUVEAU - fonctionnalité clé)
            $table->enum('account_status', ['pending', 'validated', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('validated_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();

            // Abonnement
            $table->enum('subscription_plan', ['free', 'basic', 'premium', 'enterprise'])->default('free');
            $table->timestamp('subscription_expires_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_profiles');
    }
};
