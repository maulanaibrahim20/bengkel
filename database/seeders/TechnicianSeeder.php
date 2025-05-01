<?php

namespace Database\Seeders;

use App\Models\Technician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technician = ['Boim', 'Daniel Firdaus', 'Ardi', 'John', 'Andi'];

        foreach ($technician as $technician) {
            Technician::create([
                'name' => $technician,
                'username' => str_replace(' ', '', strtolower($technician))
            ]);
        }
    }
}
