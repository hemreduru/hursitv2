<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class CvProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'name' => 'Hurşit Emre Duru',
            'title_en' => 'Software Developer',
            'title_tr' => 'Yazılım Geliştirici',
            'bio_en' => 'Mid-level Software Developer with strong Laravel/PHP backend experience. Focused on robust solutions, CI/CD pipelines, and user-friendly systems.',
            'bio_tr' => 'Güçlü Laravel/PHP backend deneyimine sahip Yazılım Geliştirici. Sağlam çözümler, CI/CD süreçleri ve kullanıcı dostu sistemler geliştirmeye odaklı.',
            'contact_email' => 'hemreduru@gmail.com',
            // Ideally add other social links if Profile model supports them
        ]);
    }
}
