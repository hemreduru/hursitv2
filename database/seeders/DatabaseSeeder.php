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

        // 2. Call CV Seeders
        $this->call([
            CvProfileSeeder::class,
            CvExperienceSeeder::class,
            CvProjectSeeder::class,
            CvSkillSeeder::class,
        ]);

        // 3. Blog Posts (Still random for content filling, attached to random tags)
        // We create some tags first because CvSkillSeeder created Skills, not Tags (Tag model is for Blog)
        $tags = \App\Models\Tag::factory(5)->create(['locale' => 'en']);

        \App\Models\Post::factory(5)->create()
            ->each(function ($post) use ($tags) {
                $post->tags()->attach($tags->random(2));
            });
    }
}
