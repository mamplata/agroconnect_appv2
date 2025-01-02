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


        foreach ($cropData as $data) {
            Crop::create([
                'user_id' => 2,
                'img' => $faker->imageUrl(),
                'cropName' => $data['cropName'],
                'variety' => $data['variety'],
                'type' => $data['type'],
                'description' => $faker->sentence,
                'planting_period' => $faker->monthName,
                'growth_duration' => $faker->numberBetween(60, 180),  // Days
                'modified_by' => 2,
            ]);
        }
    }
}
