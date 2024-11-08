<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin gebruiker maken of bijwerken
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Het unieke veld
            [
                'name' => 'Admin',              // Admin naam
                'password' => Hash::make('password'), // Admin wachtwoord
                'role' => 'admin',              // Admin rol
            ]
        );
    }
}
