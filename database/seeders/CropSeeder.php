<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;  // Import your Crop model
use Faker\Factory as Faker;

class CropSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Inserting dummy data
        foreach (range(1, 10) as $index) {  // Change 10 to the desired number of records
            Crop::create([
                'user_id' => 2,
                'img' => $faker->imageUrl(),
                'cropName' => $faker->word,
                'variety' => $faker->word,
                'type' => $faker->randomElement(['Vegetable', 'Rice', 'Fruit']),
                'description' => $faker->sentence,
                'planting_period' => $faker->monthName,
                'growth_duration' => $faker->numberBetween(60, 180),  // Days
                'modified_by' => 2,
            ]);
        }
    }
}
