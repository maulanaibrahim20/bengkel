<?php

namespace Database\Factories;

use App\Models\PagesCms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PageCmsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PagesCms::class;
    public function definition(): array
    {
        return [
            'title' => 'Home',
            'slug' => 'home',
            'content' => null,
            'status' => 'published',
            'template' => 'home',
            'parent_id' => null,
            'published_at' => now(),
        ];
    }
}
