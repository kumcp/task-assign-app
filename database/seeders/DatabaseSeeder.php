<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            AdminAccount::class,
            ProcessMethodSeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
            PriorityJobTypeSeeder::class,
            DepartmentStaffSeeder::class,
        ])->call([
            // JobSeeder::class,
        ])->call([
            // JobAssignSeeder::class,
        ]);
    }
}
