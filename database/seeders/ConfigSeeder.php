<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'hero_title_1', 'value' => 'Bengkel Motor Terpercaya di Kota Anda', 'type' => 'text'],
            ['key' => 'hero_subtitle_1', 'value' => 'Perbaikan Motor Cepat, Andal, dan Terjangkau', 'type' => 'text'],
            ['key' => 'hero_image_1', 'value' => 'uploads/images/hero.jpg', 'type' => 'image'],

            ['key' => 'hero_title_2', 'value' => 'Ahli Perbaikan Motor Semua Merek', 'type' => 'text'],
            ['key' => 'hero_subtitle_2', 'value' => 'Teknisi Profesional dan Berpengalaman', 'type' => 'text'],
            ['key' => 'hero_image_2', 'value' => 'uploads/images/hero1.jpg', 'type' => 'image'],

            ['key' => 'hero_title_3', 'value' => 'Servis Motor dengan Harga Terjangkau', 'type' => 'text'],
            ['key' => 'hero_subtitle_3', 'value' => 'Memberikan Pelayanan Terbaik untuk Anda', 'type' => 'text'],
            ['key' => 'hero_image_3', 'value' => 'uploads/images/hero2.jpg', 'type' => 'image'],

            ['key' => 'about_title', 'value' => 'Tentang Kami', 'type' => 'text'],
            ['key' => 'about_content', 'value' => 'Kami telah melayani pelanggan sejak 2005 dengan layanan otomotif yang andal dan profesional.', 'type' => 'text'],
            ['key' => 'about_image', 'value' => 'uploads/images/about.jpg', 'type' => 'image'],

            ['key' => 'contact_address', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '0812-3456-7890', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@bengkelku.com', 'type' => 'text'],
            ['key' => 'contact_open_hours', 'value' => 'Senin - Sabtu: 08:00 - 17:00', 'type' => 'text'],
        ];

        foreach ($data as $item) {
            Config::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'type' => $item['type']]
            );
        }
    }
}
