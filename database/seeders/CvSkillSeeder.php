<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class CvSkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Languages' => ['PHP (Laravel)', 'HTML5', 'CSS', 'JavaScript'],
            'Backend' => ['REST API Development', 'Relational & Non-Relational Databases', 'Redis', 'OOP', 'TDD'],
            'DevOps & Tools' => ['CI/CD Pipelines', 'Docker', 'Git', 'GitLab', 'GitHub', 'Linux'],
            'Principles' => ['Clean Code', 'KISS', 'SRP', 'ACID', 'Agile'],
            'Familiar' => ['React.js', 'Vue.js', '.NET'],
        ];

        foreach ($skills as $category => $items) {
            foreach ($items as $name) {
                Skill::create([
                    'name' => $name,
                    'category' => $category,
                ]);
            }
        }
    }
}
