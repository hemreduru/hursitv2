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
        $trFaker = \Faker\Factory::create('tr_TR');

        return [
            'name' => $this->faker->name(),
            'contact_email' => $this->faker->safeEmail(),
            'social_links' => [
                'github' => 'https://github.com/' . $this->faker->userName(),
                'twitter' => 'https://twitter.com/' . $this->faker->userName(),
                'linkedin' => 'https://linkedin.com/in/' . $this->faker->userName(),
            ],

            // EN
            'title_en' => $this->faker->jobTitle(),
            'bio_en' => $this->faker->paragraph(),

            // TR
            'title_tr' => $trFaker->jobTitle(),
            'bio_tr' => $trFaker->paragraph(),
        ];
    }
}
