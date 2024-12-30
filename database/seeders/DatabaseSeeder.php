<?php

namespace Database\Seeders;

use App\Models\AdditionalInformation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(CropSeeder::class);
        $this->call(CropReportSeeder::class);
        $this->call(AdditionalInformationSeeder::class);
    }
}
