<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\JobCategory;
use App\Models\JobOffer;
use App\Models\Application;
use App\Models\Favorite;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. CRÉER L'ADMIN
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@jobdigitalci.com',
            'password' => Hash::make('Admin123@#'),
            'role' => 'admin',
            'is_validated' => true,
            'status' => 'actif',
        ]);

        // 2. CRÉER VOTRE COMPTE CANDIDAT
        $candidate = User::create([
            'name' => 'Abdou karim keita',
            'first_name' => 'Abdou karim',
            'last_name' => 'keita',
            'email' => 'candidat1@gmail.com',
            'password' => Hash::make('Admin123@#'),
            'role' => 'candidate',
            'is_validated' => false,
            'status' => 'actif',
        ]);

        // 3. CRÉER LE PROFIL DU CANDIDAT
        $profile = CandidateProfile::create([
            'user_id' => $candidate->id,
            'date_of_birth' => '1996-05-03',
            'gender' => 'male',
            'nationality' => 'Ivoirienne',
            'phone' => '0709909290',
            'address' => 'Cococdy',
            'city' => 'Abidjan',
            'profile_completeness' => 52,
            'profile_photo' => 'profiles/photos/Xf6NTVN2lesXtwws6NpTXDspPN7VdhOainCXp1B5.jpg',
            'cv_file' => 'profiles/cvs/6sounoeXmexepaJlQ1vpVUlQFF175mqKkHAJzErq.pdf',
        ]);

        // 4. CRÉER UN RECRUTEUR DE TEST
        $recruiter = User::create([
            'name' => 'Entreprise Tech CI',
            'email' => 'recruteur@techci.com',
            'password' => Hash::make('Admin123@#'),
            'role' => 'recruiter',
            'is_validated' => true,
            'status' => 'actif',
        ]);

        // 5. CRÉER LES CATÉGORIES D'EMPLOI
        $categories = [
            ['name' => 'Développement Web', 'slug' => 'developpement-web', 'icon' => 'bx-code-alt', 'description' => 'Développeurs front-end, back-end et full-stack'],
            ['name' => 'Design & UI/UX', 'slug' => 'design-ui-ux', 'icon' => 'bx-palette', 'description' => 'Designers graphiques et UX/UI'],
            ['name' => 'Marketing Digital', 'slug' => 'marketing-digital', 'icon' => 'bx-trending-up', 'description' => 'Marketing, SEO, réseaux sociaux'],
            ['name' => 'Data Science', 'slug' => 'data-science', 'icon' => 'bx-data', 'description' => 'Data analysts, scientists et ingénieurs'],
            ['name' => 'DevOps & Cloud', 'slug' => 'devops-cloud', 'icon' => 'bx-cloud', 'description' => 'Ingénieurs DevOps et Cloud'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = JobCategory::create($cat);
        }

        // 6. CRÉER DES OFFRES D'EMPLOI
        $jobs = [
            [
                'recruiter_id' => $recruiter->id,
                'category_id' => $categoryModels[0]->id,
                'title' => 'Développeur Full Stack Laravel/Vue.js',
                'description' => 'Nous recherchons un développeur full stack passionné pour rejoindre notre équipe dynamique.',
                'responsibilities' => "- Développer et maintenir des applications web\n- Collaborer avec l'équipe produit\n- Optimiser les performances",
                'requirements' => "- 2+ ans d'expérience en Laravel\n- Maîtrise de Vue.js\n- Connaissance de MySQL",
                'benefits' => "- Salaire compétitif\n- Télétravail possible\n- Formation continue",
                'location' => 'Abidjan, Plateau',
                'city' => 'Abidjan',
                'is_remote' => true,
                'employment_type' => 'full-time',
                'experience_level' => 'intermediate',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'salary_period' => 'month',
                'salary_negotiable' => true,
                'application_deadline' => now()->addDays(30),
                'status' => 'active',
                'company_name' => 'Tech CI',
                'company_website' => 'https://techci.com',
            ],
            [
                'recruiter_id' => $recruiter->id,
                'category_id' => $categoryModels[1]->id,
                'title' => 'Designer UI/UX Senior',
                'description' => 'Rejoignez notre équipe créative pour concevoir des expériences utilisateur exceptionnelles.',
                'responsibilities' => "- Créer des maquettes et prototypes\n- Mener des recherches utilisateurs\n- Collaborer avec les développeurs",
                'requirements' => "- Portfolio professionnel\n- Maîtrise Figma/Adobe XD\n- 3+ ans d'expérience",
                'benefits' => "- Environnement créatif\n- Équipement fourni\n- Horaires flexibles",
                'location' => 'Abidjan, Cocody',
                'city' => 'Abidjan',
                'is_remote' => false,
                'employment_type' => 'full-time',
                'experience_level' => 'senior',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'salary_period' => 'month',
                'salary_negotiable' => true,
                'application_deadline' => now()->addDays(45),
                'status' => 'active',
                'company_name' => 'Design Studio CI',
                'company_website' => 'https://designstudio.ci',
            ],
            [
                'recruiter_id' => $recruiter->id,
                'category_id' => $categoryModels[2]->id,
                'title' => 'Chargé(e) de Marketing Digital',
                'description' => 'Nous cherchons un expert en marketing digital pour développer notre présence en ligne.',
                'responsibilities' => "- Gérer les réseaux sociaux\n- Créer des campagnes publicitaires\n- Analyser les performances",
                'requirements' => "- Expérience en SEO/SEM\n- Maîtrise Google Ads\n- Créativité et analytique",
                'benefits' => "- Primes sur objectifs\n- Formation continue\n- Ambiance jeune",
                'location' => 'Abidjan, Marcory',
                'city' => 'Abidjan',
                'is_remote' => true,
                'employment_type' => 'full-time',
                'experience_level' => 'intermediate',
                'salary_min' => 400000,
                'salary_max' => 700000,
                'salary_period' => 'month',
                'salary_negotiable' => false,
                'application_deadline' => now()->addDays(20),
                'status' => 'active',
                'company_name' => 'Digital Agency CI',
            ],
            [
                'recruiter_id' => $recruiter->id,
                'category_id' => $categoryModels[0]->id,
                'title' => 'Développeur Mobile Flutter',
                'description' => 'Développez des applications mobiles innovantes avec Flutter.',
                'responsibilities' => "- Développer des apps iOS/Android\n- Intégrer des APIs\n- Assurer la qualité du code",
                'requirements' => "- Maîtrise de Flutter/Dart\n- Expérience Firebase\n- Portfolio mobile",
                'benefits' => "- Projets variés\n- Matériel fourni\n- Évolution rapide",
                'location' => 'Abidjan, Yopougon',
                'city' => 'Abidjan',
                'is_remote' => false,
                'employment_type' => 'contract',
                'experience_level' => 'junior',
                'salary_min' => 350000,
                'salary_max' => 600000,
                'salary_period' => 'month',
                'salary_negotiable' => true,
                'application_deadline' => now()->addDays(15),
                'status' => 'active',
                'company_name' => 'Mobile Dev CI',
            ],
            [
                'recruiter_id' => $recruiter->id,
                'category_id' => $categoryModels[3]->id,
                'title' => 'Data Analyst',
                'description' => 'Analysez les données pour aider à la prise de décision stratégique.',
                'responsibilities' => "- Créer des tableaux de bord\n- Analyser les tendances\n- Présenter les insights",
                'requirements' => "- Python/R\n- SQL avancé\n- PowerBI ou Tableau",
                'benefits' => "- Formation data\n- Projets stratégiques\n- Équipe internationale",
                'location' => 'Abidjan, Plateau',
                'city' => 'Abidjan',
                'is_remote' => true,
                'employment_type' => 'full-time',
                'experience_level' => 'intermediate',
                'salary_min' => 550000,
                'salary_max' => 900000,
                'salary_period' => 'month',
                'salary_negotiable' => true,
                'application_deadline' => now()->addDays(25),
                'status' => 'active',
                'company_name' => 'Data Insights CI',
            ],
        ];

        $jobModels = [];
        foreach ($jobs as $job) {
            $jobModels[] = JobOffer::create($job);
        }

        // 7. CRÉER UNE CANDIDATURE DE TEST pour le candidat
        Application::create([
            'candidate_id' => $candidate->id,
            'job_offer_id' => $jobModels[0]->id,
            'status' => 'pending',
            'cover_letter' => 'Je suis très intéressé par ce poste car j\'ai 3 ans d\'expérience en Laravel et Vue.js...',
        ]);

        Application::create([
            'candidate_id' => $candidate->id,
            'job_offer_id' => $jobModels[3]->id,
            'status' => 'reviewed',
            'cover_letter' => 'Passionné par le développement mobile, je serais ravi de rejoindre votre équipe...',
        ]);

        // 8. CRÉER DES FAVORIS DE TEST pour le candidat
        Favorite::create([
            'candidate_id' => $candidate->id,
            'job_offer_id' => $jobModels[1]->id,
        ]);

        Favorite::create([
            'candidate_id' => $candidate->id,
            'job_offer_id' => $jobModels[4]->id,
        ]);

        $this->command->info('✅ Base de données remplie avec succès!');
        $this->command->info('📧 Admin: admin@jobdigitalci.com | Admin123@#');
        $this->command->info('📧 Candidat: candidat1@gmail.com | Admin123@#');
        $this->command->info('📧 Recruteur: recruteur@techci.com | Admin123@#');
        $this->command->info('📊 ' . count($jobModels) . ' offres d\'emploi créées');
    }
}
