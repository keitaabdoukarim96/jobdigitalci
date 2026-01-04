<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@jobdigitalci.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_validated' => true,
        ]);

        // Créer un candidat de test
        User::create([
            'name' => 'Jean Kouassi',
            'email' => 'candidat@test.com',
            'password' => Hash::make('password'),
            'role' => 'candidate',
            'phone' => '+225 07 XX XX XX XX',
            'is_validated' => true,
        ]);

        // Créer un recruteur validé
        User::create([
            'name' => 'Orange Côte d\'Ivoire',
            'email' => 'recruteur@test.com',
            'password' => Hash::make('password'),
            'role' => 'recruiter',
            'phone' => '+225 27 XX XX XX XX',
            'is_validated' => true,
        ]);

        // Créer un recruteur en attente de validation
        User::create([
            'name' => 'MTN CI',
            'email' => 'recruteur-pending@test.com',
            'password' => Hash::make('password'),
            'role' => 'recruiter',
            'phone' => '+225 27 YY YY YY YY',
            'is_validated' => false,
        ]);
    }
}
