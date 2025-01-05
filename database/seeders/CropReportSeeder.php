<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CropReport;
use Faker\Factory as Faker;

class CropReportSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $cropData = [
            ['cropName' => 'Squash', 'variety' => 'Suprema'],
            ['cropName' => 'Rice', 'variety' => 'N/A'],
            ['cropName' => 'Upo', 'variety' => 'Mayumi'],
            ['cropName' => 'Watermelon', 'variety' => 'Sugarbaby Max'],
            ['cropName' => 'Eggplant', 'variety' => 'Fortuner'],
            ['cropName' => 'Tomato', 'variety' => 'Diamante Max'],
            ['cropName' => 'Ampalaya', 'variety' => 'Glaxy'],
            ['cropName' => 'Watermelon', 'variety' => 'Jaguar'],
            ['cropName' => 'Upo', 'variety' => 'Tambuli'],
            ['cropName' => 'Eggplant', 'variety' => 'Calixto'],
            ['cropName' => 'Red Hot Pepper', 'variety' => 'Superheat'],
        ];

        // Add 'type' to each crop entry
        foreach ($cropData as &$data) {
            if ($data['cropName'] === 'Rice') {
                $data['type'] = 'Rice';
            } elseif ($data['cropName'] === 'Watermelon') {
                $data['type'] = 'Fruits';
            } else {
                $data['type'] = 'Vegetables';
            }
        }
        unset($data); // Unset reference to avoid issues

        // Generate multiple CropReport records for each crop for the last 5 months
        foreach ($cropData as $crop) {
            // Get the last 5 months, starting from the current month
            $months = [];
            for ($j = 0; $j < 5; $j++) {
                $months[] = now()->subMonths($j)->format('Y-m');
            }

            // Add records for each of the last 5 months
            foreach ($months as $month) {
                CropReport::create([
                    'user_id' => 2,
                    'modified_by' => 2,
                    'cropName' => $crop['cropName'],
                    'variety' => $crop['variety'],
                    'type' => $crop['type'],
                    'areaPlanted' => $faker->randomFloat(2, 1, 100),  // In hectares
                    'productionVolume' => $faker->randomFloat(2, 500, 5000),  // In kilograms
                    'yield' => $faker->randomFloat(2, 1, 10),  // Yield per hectare
                    'price' => $faker->randomFloat(2, 20, 100),  // Price per kilogram
                    'monthObserved' => $month,  // Specific month
                ]);
            }
        }
    }
}
