<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        \App\Models\User::factory()->create([
            'name' => 'emre',
            'email' => 'hemreduru@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('emre2000'),
        ]);

        // 2. Global Skills
        $categories = ['Languages', 'Frameworks', 'Tools', 'DevOps'];
        foreach ($categories as $category) {
            \App\Models\Skill::factory(5)->create(['category' => $category]);
        }

        // 3. Localized Content
        foreach (['en', 'tr'] as $locale) {
            $faker = \Faker\Factory::create($locale === 'tr' ? 'tr_TR' : 'en_US');

            // Profile
            \App\Models\Profile::factory()->create([
                'locale' => $locale,
                'name' => $locale === 'tr' ? 'Hurşit Emre Duru' : 'Hursit Emre Duru',
                'title' => $locale === 'tr' ? 'Kıdemli Full-Stack Geliştirici' : 'Senior Full-Stack Engineer',
                'bio' => $faker->paragraph(3),
            ]);

            // Experiences
            \App\Models\Experience::factory(3)->create([
                'locale' => $locale,
                'role' => $faker->jobTitle(),
                'company' => $faker->company(),
                'description' => $faker->paragraph(),
            ]);

            // Tags
            $tags = \App\Models\Tag::factory(8)->create([
                'locale' => $locale,
                'name' => fn() => ucfirst($faker->unique()->word()),
                'slug' => fn(array $attributes) => \Illuminate\Support\Str::slug($attributes['name']),
            ]);

            // Projects
            \App\Models\Project::factory(6)->create([
                'locale' => $locale,
                'title' => fn() => $faker->sentence(3),
                'short_description' => fn() => $faker->sentence(10),
                'content' => fn() => $faker->paragraphs(3, true),
            ]);

            // Posts
            \App\Models\Post::factory(10)->create([
                'locale' => $locale,
                'title' => fn() => $faker->sentence(4),
                'short_description' => fn() => $faker->sentence(10),
                'content' => fn() => $faker->paragraphs(5, true),
            ])->each(function ($post) use ($tags) {
                // Attach random tags from the SAME locale
                $post->tags()->attach($tags->random(2));
            });
        }
    }
}
