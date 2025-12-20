<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'date_range' => $this->faker->year() . ' - ' . $this->faker->year(),
            'description' => $this->faker->paragraph(),
            'locale' => 'en',
        ];
    }
}
