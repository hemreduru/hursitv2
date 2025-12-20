<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
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
            'title' => $this->faker->jobTitle(),
            'bio' => $this->faker->paragraph(),
            'contact_email' => $this->faker->safeEmail(),
            'social_links' => [
                'github' => 'https://github.com/' . $this->faker->userName(),
                'twitter' => 'https://twitter.com/' . $this->faker->userName(),
                'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName(),
            ],
            'locale' => 'en',
        ];
    }
}
