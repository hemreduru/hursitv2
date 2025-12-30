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

        // 3. Profile (Single row, dual content)
        \App\Models\Profile::factory()->create([
            'name' => 'Hurşit Emre Duru',
            'title_en' => 'Senior Full-Stack Engineer',
            'title_tr' => 'Kıdemli Full-Stack Geliştirici',
        ]);

        // 4. Experiences (Still single-language rows, so we loop)
        foreach (['en', 'tr'] as $locale) {
            $faker = \Faker\Factory::create($locale === 'tr' ? 'tr_TR' : 'en_US');
            \App\Models\Experience::factory(3)->create([
                'locale' => $locale,
                'role' => $faker->jobTitle(),
                'company' => $faker->company(),
                'description' => $faker->paragraph(),
            ]);
        }

        // 5. Tags (Single-language rows)
        $enTags = \App\Models\Tag::factory(5)->create(['locale' => 'en']);
        $trTags = \App\Models\Tag::factory(5)->create([
            'locale' => 'tr',
            'name' => fn() => ucfirst(\Faker\Factory::create('tr_TR')->unique()->word())
        ]);

        $allTags = $enTags->merge($trTags);

        // 6. Projects (Dual content)
        \App\Models\Project::factory(6)->create();

        // 7. Posts (Dual content)
        \App\Models\Post::factory(10)->create()
            ->each(function ($post) use ($allTags) {
                // Attach random tags (mix of EN and TR)
                $post->tags()->attach($allTags->random(3));
            });
    }
}
