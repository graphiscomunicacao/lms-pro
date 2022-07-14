<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningArtifact;

class LearningArtifactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LearningArtifact::factory()
            ->count(5)
            ->create();
    }
}
