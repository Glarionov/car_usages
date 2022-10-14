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
         \App\Models\User::factory(10)->create();

         $carSeeder = new CarSeeder();
         $carSeeder->run();

         $carUsageSeeder = new CarUsageSeeder();
//         $carUsageSeeder->run();
    }
}
