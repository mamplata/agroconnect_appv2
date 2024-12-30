<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\AdditionalInformation;
use App\Models\Crop; // Assuming you have a Crop model to reference

class AdditionalInformationSeeder extends Seeder
{
    public function run()
    {
        // Initialize Faker for generating dummy data
        $faker = Faker::create();

        // Create 10 dummy file records associated with existing crops
        for ($i = 0; $i < 10; $i++) {
            $file = $faker->word . '.pdf'; // Generate a random file name
            $filePath = 'uploads/' . $file; // File path in the public storage

            // Generate file details and associate with a crop
            AdditionalInformation::create([
                'crop_id' => $faker->numberBetween(1, 10), // Assuming there are crops with IDs from 1 to 10
                'user_id' => 2,
                'fileHolder' => json_encode([
                    'originalName' => $file,
                    'path' => $filePath,
                    'size' => $faker->numberBetween(1000, 5000), // Random file size (1KB to 5KB)
                    'type' => 'application/pdf', // Assuming all files are PDFs for simplicity
                ]),
            ]);
        }

        // Optional: You can also create more records with other file types if necessary
        for ($i = 0; $i < 5; $i++) {
            $file = $faker->word . '.jpg'; // Generate a random image file
            $filePath = 'uploads/' . $file;

            AdditionalInformation::create([
                'crop_id' => $faker->numberBetween(1, 10),
                'user_id' => 1,
                'fileHolder' => json_encode([
                    'originalName' => $file,
                    'path' => $filePath,
                    'size' => $faker->numberBetween(1000, 5000), // Random file size (1KB to 5KB)
                    'type' => 'image/jpeg', // Assuming all files are images for this batch
                ]),
            ]);
        }
    }
}
