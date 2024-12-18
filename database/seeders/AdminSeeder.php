<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::updateOrCreate(
        //     ['email' => 'admin@example.com'], // Ensure only one admin
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@example.com',
        //         'password' => Hash::make('password'), // Set a secure password
        //         'role' => 'admin',
        //     ]
        // );

        User::updateOrCreate(
            [
                'name' => 'John Doe',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Set a secure password
                'role' => 'user',
            ]
        );
    }
}
