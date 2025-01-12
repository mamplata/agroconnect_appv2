<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DamageReport;
use Faker\Factory as Faker;

class DamageReportSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Damage report data
        $damageData = [
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
        foreach ($damageData as &$data) {
            if ($data['cropName'] === 'Rice') {
                $data['type'] = 'Rice';
            } elseif ($data['cropName'] === 'Watermelon') {
                $data['type'] = 'Fruits';
            } else {
                $data['type'] = 'Vegetables';
            }
        }
        unset($data); // Unset reference to avoid issues

        // Define common damage names for Pest and Disease types
        $pestDamageNames = ['Aphids', 'Whiteflies', 'Cutworms', 'Leafhoppers', 'Thrips'];
        $diseaseDamageNames = ['Blight', 'Powdery Mildew', 'Rust', 'Downy Mildew', 'Fusarium Wilt'];

        // Generate multiple DamageReport records for each crop for the last 5 months
        foreach ($damageData as $crop) {
            // Get the last 5 months, starting from the current month
            $months = [];
            for ($j = 0; $j < 5; $j++) {
                $months[] = now()->subMonths($j)->format('Y-m');
            }

            // Add records for each of the last 5 months
            foreach ($months as $month) {
                // Randomly assign damage type (Natural Disaster, Pest, or Disease)
                $damageType = $faker->randomElement(['Natural Disaster', 'Pest', 'Disease']);

                // Determine damage name based on type
                if ($damageType === 'Natural Disaster') {
                    // Generate a random natural disaster name using Faker
                    $damageName = $faker->word();
                } elseif ($damageType === 'Pest') {
                    // Choose a common pest name
                    $damageName = $faker->randomElement($pestDamageNames);
                } else { // Disease
                    // Choose a common disease name
                    $damageName = $faker->randomElement($diseaseDamageNames);
                }

                // If damage type is 'Natural Disaster', set natural_disaster_type, otherwise set it to null
                $naturalDisasterType = $damageType === 'Natural Disaster'
                    ? $faker->randomElement(['Typhoon', 'Flood', 'Earthquake'])
                    : null;

                DamageReport::create([
                    'user_id' => 2,
                    'modified_by' => 2,
                    'cropName' => $crop['cropName'],
                    'variety' => $crop['variety'],
                    'type' => $crop['type'],
                    'damage_type' => $damageType,
                    'natural_disaster_type' => $naturalDisasterType, // Set only if damage_type is 'Natural Disaster'
                    'damage_name' => $damageName,  // Specific damage name based on type
                    'area_planted' => $faker->randomFloat(2, 1, 100),  // In hectares
                    'area_affected' => $faker->randomFloat(2, 0, 100),  // Affected area in hectares
                    'monthObserved' => $month,  // Specific month
                ]);
            }
        }
    }
}
