<?php

namespace Database\Seeders;

use App\Models\BrandEngine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandEngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandEngine = ['Yamaha', 'Honda', 'Suzuki', 'Kawasaki'];

        foreach ($brandEngine as $brandEngine) {
            BrandEngine::create([
                'name' => $brandEngine,
            ]);
        }
    }
}
