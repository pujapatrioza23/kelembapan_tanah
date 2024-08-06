<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensor_data')->insert([
            [
                'soil_moisture' => 30.5,
                'recorded_at' => Carbon::now()->subMinutes(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'soil_moisture' => 45.2,
                'recorded_at' => Carbon::now()->subMinutes(8),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'soil_moisture' => 50.3,
                'recorded_at' => Carbon::now()->subMinutes(6),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'soil_moisture' => 40.1,
                'recorded_at' => Carbon::now()->subMinutes(4),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'soil_moisture' => 35.6,
                'recorded_at' => Carbon::now()->subMinutes(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
