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

        $this->call(AchievementSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CertificateSeeder::class);
        $this->call(ExperienceDetailSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(LearningArtifactSeeder::class);
        $this->call(LearningPathSeeder::class);
        $this->call(LearningPathGroupSeeder::class);
        $this->call(LearningPathGroupResultSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ObjectiveAnswerSeeder::class);
        $this->call(ObjectiveQuestionSeeder::class);
        $this->call(ObjectiveQuestionOptionSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(QuizResultSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SupportLinkSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(UserSeeder::class);
    }
}
