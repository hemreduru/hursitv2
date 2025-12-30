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
        $trFaker = \Faker\Factory::create('tr_TR');

        $titleEn = $this->faker->sentence(4);
        $titleTr = $trFaker->sentence(4);

        return [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'reading_time' => $this->faker->numberBetween(1, 15),

            // EN
            'title_en' => $titleEn,
            'slug_en' => \Illuminate\Support\Str::slug($titleEn),
            'short_description_en' => $this->faker->sentence(10),
            'content_en' => $this->faker->paragraphs(5, true),

            // TR
            'title_tr' => $titleTr,
            'slug_tr' => \Illuminate\Support\Str::slug($titleTr),
            'short_description_tr' => $trFaker->sentence(10),
            'content_tr' => $trFaker->paragraphs(5, true),
        ];
    }
}
