<?php

namespace Database\Seeders;

use App\Models\ProcessMethod;
use Illuminate\Database\Seeder;

class ProcessMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcessMethod::factory()->count(20)->create();
    }
}
