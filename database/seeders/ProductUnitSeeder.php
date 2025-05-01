<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productUnitName = [
            'Pieces',
            'Liter',
            'Set',
            'Roll',
            'Tube',
            'Can',
            'Bottle',
            'Box',
            'Pack',
        ];

        $productUnitAcronym = [
            'Pcs',
            'L',
            'Set',
            'Roll',
            'Tube',
            'Can',
            'Btl',
            'Box',
            'Pack',
        ];

        foreach ($productUnitName as $index => $name) {
            ProductUnit::create([
                'name' => $name,
                'acronym' => $productUnitAcronym[$index],
            ]);
        }
    }
}
