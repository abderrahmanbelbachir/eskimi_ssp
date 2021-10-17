<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Compaign::factory(10)->create();
    }
}
