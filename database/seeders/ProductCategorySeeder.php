<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategories = [
            'Oli Mesin',
            'Aki / Battery',
            'Ban',
            'Rem & Kampas',
            'Filter Udara',
            'Lampu & Kelistrikan',
            'Sparepart Mesin',
            'Aksesoris Motor',
            'Jasa Servis',
        ];

        foreach ($productCategories as $productCategory) {
            ProductCategory::create([
                'name' => $productCategory,
            ]);
        }
    }
}
