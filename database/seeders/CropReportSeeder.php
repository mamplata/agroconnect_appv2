<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CropReport;  // Import your CropReport model
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
                $data['type'] = 'Fruit';
            } else {
                $data['type'] = 'Vegetable';
            }
        }
        unset($data); // Unset reference to avoid issues

        // Generate multiple CropReport records with random picks
        for ($i = 0; $i < 10; $i++) {
            $randomCrop = $cropData[array_rand($cropData)]; // Pick a random crop from $cropData

            CropReport::create([
                'user_id' => 2,
                'modified_by' => 2,
                'cropName' => $randomCrop['cropName'],
                'variety' => $randomCrop['variety'],
                'type' => $randomCrop['type'],
                'areaPlanted' => $faker->randomFloat(2, 1, 100),  // In hectares
                'productionVolume' => $faker->randomFloat(2, 500, 5000),  // In kilograms
                'yield' => $faker->randomFloat(2, 1, 10),  // Yield per hectare
                'price' => $faker->randomFloat(2, 20, 100),  // Price per kilogram
                'monthObserved' => $faker->date('Y-m'),  // Format: 2023-12
            ]);
        }
    }
}
