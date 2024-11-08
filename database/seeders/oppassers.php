<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class oppassers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Controleren of er al een oppasser met dezelfde voornaam en achternaam bestaat
        $existingOppasser = DB::table('oppassers')
            ->where('name', 'Lars')
            ->first();

        if ($existingOppasser) {
            // Als de oppasser al bestaat, update dan de bestaande invoer
            DB::table('oppassers')
                ->where('id', $existingOppasser->id)
                ->update([
                    'name' => 'Lars',
                    // Je kunt hier andere velden bijwerken als nodig
                ]);
        } else {
            // Als de oppasser niet bestaat, voeg een nieuwe invoer toe
            DB::table('oppassers')->insert([
                'name' => 'Lars',
            ]);
        }
    }
}
