<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'avatar' => 'images/avatars/placeholder.svg',
            'rating' => $this->faker->numberBetween(4, 5),
            'comment' => $this->faker->sentence(12),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
