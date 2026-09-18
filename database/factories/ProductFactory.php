<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucfirst($this->faker->words(2, true));

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => str()->slug($name.'-'.$this->faker->unique()->numberBetween(1, 999)),
            'description' => $this->faker->sentence(12),
            'price' => $this->faker->numberBetween(15_000, 200_000),
            'image' => 'images/products/placeholder.svg',
            'badge' => null,
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}