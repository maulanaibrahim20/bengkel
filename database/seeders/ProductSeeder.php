<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ProductCategory::pluck('id', 'name');
        $units = ProductUnit::pluck('id', 'name');

        $products = [
            [
                'name' => 'Oli Pertamina Enduro 20W-50',
                'code' => 'OLI-ENDURO-2050',
                'description' => 'Oli mesin motor 4T, cocok untuk harian.',
                'image' => null,
                'stock' => 50,
                'status' => 'active',
                'category' => 'Oli Mesin',
                'unit' => 'Liter',
            ],
            [
                'name' => 'Aki GS Astra 12V 5Ah',
                'code' => 'AKI-GS-5AH',
                'description' => 'Aki kering untuk motor matic dan bebek.',
                'image' => null,
                'stock' => 20,
                'status' => 'active',
                'category' => 'Aki / Battery',
                'unit' => 'Pieces',
            ],
            [
                'name' => 'Ban Swallow 90/90-14',
                'code' => 'BAN-SWALLOW-9090',
                'description' => 'Ban tubeless untuk motor matic.',
                'image' => null,
                'stock' => 30,
                'status' => 'active',
                'category' => 'Ban',
                'unit' => 'Pieces',
            ],
            [
                'name' => 'Kampas Rem Belakang Yamaha',
                'code' => 'REM-KAMPAS-YMH',
                'description' => 'Kampas rem belakang original Yamaha.',
                'image' => null,
                'stock' => 40,
                'status' => 'active',
                'category' => 'Rem & Kampas',
                'unit' => 'Set',
            ],
            [
                'name' => 'Filter Udara Honda Beat',
                'code' => 'FILTER-HONDA-BEAT',
                'description' => 'Filter udara original Honda Beat.',
                'image' => null,
                'stock' => 25,
                'status' => 'active',
                'category' => 'Filter Udara',
                'unit' => 'Pieces',
            ],
            [
                'name' => 'Lampu LED 12V Universal',
                'code' => 'LAMPU-LED-UNIV',
                'description' => 'Lampu depan LED putih terang 12V.',
                'image' => null,
                'stock' => 60,
                'status' => 'active',
                'category' => 'Lampu & Kelistrikan',
                'unit' => 'Pieces',
            ],
            [
                'name' => 'Piston Kit Supra X 125',
                'code' => 'PISTON-SUPRAX125',
                'description' => 'Satu set piston kit untuk Supra X 125.',
                'image' => null,
                'stock' => 15,
                'status' => 'active',
                'category' => 'Sparepart Mesin',
                'unit' => 'Set',
            ],
            [
                'name' => 'Spion Motor Bulat Klasik',
                'code' => 'SPION-KLASIK',
                'description' => 'Aksesoris retro, cocok untuk modifikasi.',
                'image' => null,
                'stock' => 10,
                'status' => 'active',
                'category' => 'Aksesoris Motor',
                'unit' => 'Set',
            ],
            [
                'name' => 'Jasa Servis Lengkap Motor',
                'code' => 'SERVIS-LENGKAP',
                'description' => 'Paket servis mesin lengkap (ganti oli, cek rem, tune-up).',
                'image' => null,
                'stock' => 0,
                'status' => 'active',
                'category' => 'Jasa Servis',
                'unit' => 'Pack',
            ],
            [
                'name' => 'Selang Rem TDR Racing',
                'code' => 'SLG-TDR-RACING',
                'description' => 'Selang rem stainless braided, kuat dan tahan tekanan tinggi.',
                'image' => null,
                'stock' => 18,
                'status' => 'active',
                'category' => 'Rem & Kampas',
                'unit' => 'Roll',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'code' => $product['code'],
                'description' => $product['description'],
                'image' => $product['image'],
                'stock' => $product['stock'],
                'status' => $product['status'],
                'category_id' => $categories[$product['category']],
                'unit_id' => $units[$product['unit']],
            ]);
        }
    }
}
