<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ObjectiveAnswer;

class ObjectiveAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ObjectiveAnswer::factory()
            ->count(5)
            ->create();
    }
}
