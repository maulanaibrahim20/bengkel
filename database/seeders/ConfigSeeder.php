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
            ['key' => 'hero_title', 'value' => 'Bengkel Terpercaya di Kota Anda', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => 'Layanan Cepat, Andal, dan Terjangkau', 'type' => 'text'],
            ['key' => 'hero_image', 'value' => 'uploads/images/hero.jpg', 'type' => 'image'],

            ['key' => 'about_title', 'value' => 'Tentang Kami', 'type' => 'text'],
            ['key' => 'about_content', 'value' => '<p>Kami telah melayani pelanggan sejak 2005 dengan layanan otomotif yang andal dan profesional.</p>', 'type' => 'html'],
            ['key' => 'about_image', 'value' => 'uploads/images/about.jpg', 'type' => 'image'],

            ['key' => 'service_1_title', 'value' => 'Ganti Oli', 'type' => 'text'],
            ['key' => 'service_1_description', 'value' => 'Layanan ganti oli cepat dengan oli berkualitas tinggi.', 'type' => 'textarea'],
            ['key' => 'service_1_image', 'value' => 'uploads/images/services/oil_change.jpg', 'type' => 'image'],

            ['key' => 'service_2_title', 'value' => 'Servis Rem', 'type' => 'text'],
            ['key' => 'service_2_description', 'value' => 'Pemeriksaan dan perbaikan sistem rem untuk keselamatan Anda.', 'type' => 'textarea'],
            ['key' => 'service_2_image', 'value' => 'uploads/images/services/brake_service.jpg', 'type' => 'image'],

            ['key' => 'contact_address', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '0812-3456-7890', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@bengkelku.com', 'type' => 'text'],
            ['key' => 'contact_open_hours', 'value' => 'Senin - Sabtu: 08:00 - 17:00', 'type' => 'text'],

            ['key' => 'testimonial_1_name', 'value' => 'John Doe', 'type' => 'text'],
            ['key' => 'testimonial_1_position', 'value' => 'Pelanggan', 'type' => 'text'],
            ['key' => 'testimonial_1_comment', 'value' => 'Pelayanan yang sangat memuaskan dan cepat!', 'type' => 'textarea'],
            ['key' => 'testimonial_1_image', 'value' => 'uploads/images/testimonials/john_doe.jpg', 'type' => 'image'],

            ['key' => 'team_1_name', 'value' => 'Andi Mechanic', 'type' => 'text'],
            ['key' => 'team_1_position', 'value' => 'Kepala Teknisi', 'type' => 'text'],
            ['key' => 'team_1_description', 'value' => 'Berpengalaman lebih dari 10 tahun dalam perbaikan otomotif.', 'type' => 'textarea'],
            ['key' => 'team_1_image', 'value' => 'uploads/images/team/andi_mechanic.jpg', 'type' => 'image'],
        ];

        foreach ($data as $item) {
            Config::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'type' => $item['type']]
            );
        }
    }
}
