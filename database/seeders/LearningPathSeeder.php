<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use Illuminate\Database\Seeder;

class LearningPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LearningPath::factory()
            ->count(5)
            ->create();
    }
}
