<?php

namespace Database\Seeders;

use App\Models\QuizResult;
use Illuminate\Database\Seeder;

class QuizResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizResult::factory()
            ->count(5)
            ->create();
    }
}
