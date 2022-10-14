<?php

namespace Database\Seeders;

use App\Models\CarsUsage;
use Illuminate\Database\Seeder;

class CarUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carUsage = new CarsUsage();
        $carUsage->start_using_at = new \DateTime();
        $carUsage->user_id = 1;
        $carUsage->car_id = 1;
        $carUsage->save();
    }
}
