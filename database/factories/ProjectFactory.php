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
        $trFaker = \Faker\Factory::create('tr_TR');

        $titleEn = $this->faker->sentence(3);
        $titleTr = $trFaker->sentence(3);

        return [
            'tech_stack' => $this->faker->words(5),
            'urls' => [
                'repo' => $this->faker->url(),
                'live' => $this->faker->url()
            ],
            'is_featured' => $this->faker->boolean(20),

            // EN
            'title_en' => $titleEn,
            'slug_en' => \Illuminate\Support\Str::slug($titleEn),
            'short_description_en' => $this->faker->sentence(10),
            'content_en' => $this->faker->paragraphs(3, true),

            // TR
            'title_tr' => $titleTr,
            'slug_tr' => \Illuminate\Support\Str::slug($titleTr),
            'short_description_tr' => $trFaker->sentence(10),
            'content_tr' => $trFaker->paragraphs(3, true),
        ];
    }
}
