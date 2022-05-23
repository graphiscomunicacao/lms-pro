<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningPathGroup;

class LearningPathGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LearningPathGroup::factory()
            ->count(5)
            ->create();
    }
}
