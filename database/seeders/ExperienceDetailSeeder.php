<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExperienceDetail;

class ExperienceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExperienceDetail::factory()
            ->count(5)
            ->create();
    }
}
