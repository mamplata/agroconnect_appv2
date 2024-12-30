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

        // Inserting dummy data
        foreach (range(1, 10) as $index) {  // Change 10 to the desired number of records
            CropReport::create([
                'user_id' => 2,
                'modified_by' => 2,
                'cropName' => $faker->word,
                'variety' => $faker->word,
                'type' => $faker->randomElement(['Vegetable', 'Rice', 'Fruit']),
                'areaPlanted' => $faker->randomFloat(2, 1, 100),  // In hectares
                'productionVolume' => $faker->randomFloat(2, 500, 5000),  // In kilograms
                'yield' => $faker->randomFloat(2, 1, 10),  // Yield per hectare
                'price' => $faker->randomFloat(2, 20, 100),  // Price per kilogram
                'monthObserved' => $faker->date('Y-m'),  // Format: 2023-12
            ]);
        }
    }
}
