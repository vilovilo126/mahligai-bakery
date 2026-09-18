<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'category' => $this->faker->randomElement(['produk', 'interior', 'suasana', 'display', 'proses']),
            'description' => $this->faker->optional()->sentence(8),
            'image' => 'images/gallery/placeholder.svg',
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}