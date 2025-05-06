<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // FULL SERVICE ANS
        $fullService = Service::create([
            'name'     => 'FULL SERVICE ANS',
            'price'    => 490000,
            'duration' => '2 Jam',
            'icon'     => 'fa-wrench', // contoh nama ikon atau path ke gambar
        ]);

        $details = [
            'Free Oli Castrol',
            'Free Oli Gardan',
            'Service CVT',
            'Infus Injeksi',
            'Service TB (Throttle body)',
            'Pembersihan dan Scan TB',
            'Kuras Minyak Rem & Service rem',
            'Pembersihan area kaliper / tromol',
            'Pengecekan ACCU',
            'Pengecekan Busi',
            'Pengecekan Tekanan Fuel Pump',
            'Pengecekan Kompresi',
        ];

        foreach ($details as $item) {
            ServiceDetail::create([
                'service_id'  => $fullService->id,
                'description' => $item,
            ]);
        }

        // Tambahan contoh layanan lain
        Service::create([
            'name'     => 'REGULER PLUS',
            'price'    => 375000,
            'duration' => '1 jam 30 menit',
            'icon'     => 'fa-tools',
        ]);

        Service::create([
            'name'     => 'REGULER SERVICE',
            'price'    => 195000,
            'duration' => '45 menit',
            'icon'     => 'fa-cogs',
        ]);

        Service::create([
            'name'     => 'UPGRADE CVT',
            'price'    => 595000,
            'duration' => '1 jam 30 menit',
            'icon'     => 'fa-car',
        ]);

        Service::create([
            'name'     => 'ANTI GREDEG',
            'price'    => 175000,
            'duration' => '1 jam',
            'icon'     => 'fa-ban',
        ]);

        Service::create([
            'name'     => 'DYNO TEST BEFORE – AFTER',
            'price'    => 250000,
            'duration' => '30 menit',
            'icon'     => 'fa-tachometer-alt',
        ]);

        Service::create([
            'name'     => 'REMAP HONDA ONLY',
            'price'    => 250000,
            'duration' => '30 menit',
            'icon'     => 'fa-microchip',
        ]);
    }
}
