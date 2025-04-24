<?php

namespace Database\Factories;

use App\Models\ComponentCms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComponentCms>
 */
class ComponentCmsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ComponentCms::class;
    public function definition(): array
    {
        return [
            'page_id' => 1,
            'type' => $this->faker->randomElement(['hero', 'services', 'call_to_action']),
            'order' => $this->faker->numberBetween(1, 10),
            'settings' => json_encode([
                'title' => $this->faker->sentence(3),
                'subtitle' => $this->faker->sentence(6),
                'button_text' => 'Learn More',
                'button_link' => '#',
                'image' => 'dummy.jpg'
            ]),
        ];
    }
}
