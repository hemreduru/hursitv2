<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'slug' => $this->faker->slug(),
            'short_description' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(3, true),
            'tech_stack' => $this->faker->words(5),
            'urls' => [
                'repo' => $this->faker->url(),
                'live' => $this->faker->url()
            ],
            'is_featured' => $this->faker->boolean(20),
            'locale' => 'en', // Default
        ];
    }
}
