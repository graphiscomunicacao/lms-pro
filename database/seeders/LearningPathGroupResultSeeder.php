<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningPathGroupResult;

class LearningPathGroupResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LearningPathGroupResult::factory()
            ->count(5)
            ->create();
    }
}
