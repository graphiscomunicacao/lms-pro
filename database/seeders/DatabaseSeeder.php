<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->command->info('Admin semeado.');

        $this->call(AchievementSeeder::class);
        $this->command->info('Achievements semeados.');

        $this->call(CategorySeeder::class);
        $this->command->info('Categorias semeadas.');

        $this->call(CertificateSeeder::class);
        $this->command->info('Certificados semeados.');

        $this->call(GroupSeeder::class);
        $this->command->info('Categorias semeadas.');

        $this->call(JobSeeder::class);
        $this->command->info('Cargos semeados.');

        $this->call(LearningArtifactSeeder::class);
        $this->command->info('LearningArtifact semeados.');

        $this->call(LearningPathSeeder::class);
        $this->command->info('LearningPath semeados.');

        $this->call(LearningPathGroupSeeder::class);
        $this->command->info('LearningPathGroups semeados.');

        $this->call(MenuSeeder::class);
        $this->command->info('Menus semeados.');

        $this->call(ObjectiveQuestionSeeder::class);
        $this->command->info('Categorias semeadas.');

        $this->call(QuizSeeder::class);
        $this->command->info('Quizzes semeados.');

        $this->call(RoleSeeder::class);
        $this->command->info('Perfis semeados.');

        $this->call(SupportLinkSeeder::class);
        $this->command->info('Links semeados.');

        $this->call(TeamSeeder::class);
        $this->command->info('Equipes semeadas.');

        $this->call(UserSeeder::class);
        $this->command->info('Usuarios semeados.');

    }
}
