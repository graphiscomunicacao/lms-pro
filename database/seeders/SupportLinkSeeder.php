<?php

namespace Database\Seeders;

use App\Models\SupportLink;
use Illuminate\Database\Seeder;

class SupportLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupportLink::factory()
            ->count(5)
            ->create();
    }
}
