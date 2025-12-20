<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'short_description' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5, true),
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'reading_time' => $this->faker->numberBetween(1, 15),
            'locale' => 'en',
        ];
    }
}
