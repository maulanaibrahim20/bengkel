<?php

namespace Database\Seeders;

use App\Models\ComponentCms;
use App\Models\PagesCms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $page = PagesCms::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => null,
            'status' => 'published',
            'template' => 'home',
            'parent_id' => null,
            'published_at' => now(),
        ]);

        ComponentCms::create([
            'page_id' => $page->id,
            'type' => 'hero',
            'order' => 1,
            'settings' => json_encode([
                'title' => 'Qualified Car Repair Service Center',
                'subtitle' => 'We provide the best service for your car',
                'button_text' => 'Learn More',
                'button_link' => '#',
                'image' => 'hero1.jpg'
            ]),
        ]);

        ComponentCms::create([
            'page_id' => $page->id,
            'type' => 'services',
            'order' => 2,
            'settings' => json_encode([
                'services' => [
                    ['title' => 'Engine Repair', 'icon' => 'engine.png'],
                    ['title' => 'Oil Change', 'icon' => 'oil.png'],
                    ['title' => 'Tire Replacement', 'icon' => 'tire.png']
                ]
            ]),
        ]);

        ComponentCms::create([
            'page_id' => $page->id,
            'type' => 'call_to_action',
            'order' => 3,
            'settings' => json_encode([
                'text' => 'Book your service now!',
                'button_text' => 'Booking',
                'button_link' => '/booking'
            ]),
        ]);
    }
}
