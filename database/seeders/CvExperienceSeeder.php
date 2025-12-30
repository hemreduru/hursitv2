<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class CvExperienceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cyprus International University
        Experience::create([
            'locale' => 'en',
            'role' => 'Software Developer',
            'company' => 'Cyprus International University',
            'date_range' => 'August 2024 – Present',
            'description' => "Developed and maintained robust software solutions using Laravel (PHP), SQL on Ubuntu. Contributed to digital infrastructure, UI design, and internal systems using GitLab.",
        ]);
        Experience::create([
            'locale' => 'tr',
            'role' => 'Yazılım Geliştirici',
            'company' => 'Uluslararası Kıbrıs Üniversitesi',
            'date_range' => 'Ağustos 2024 – Günümüz',
            'description' => "Laravel (PHP) ve SQL kullanarak sağlam yazılım çözümleri geliştirdi. Dijital altyapıya, UI tasarımına ve GitLab kullanılan iç sistemlere katkıda bulundu.",
        ]);

        // 2. Freelance
        Experience::create([
            'locale' => 'en',
            'role' => 'Backend / Full-Stack Developer',
            'company' => 'Freelance',
            'date_range' => 'April 2020 – Present',
            'description' => "Developed RESTful APIs using Laravel and MySQL. Delivered scalable solutions, integrated frontends, and translated business requirements into functional platforms.",
        ]);
        Experience::create([
            'locale' => 'tr',
            'role' => 'Backend / Full-Stack Geliştirici',
            'company' => 'Freelance',
            'date_range' => 'Nisan 2020 – Günümüz',
            'description' => "Laravel ve MySQL kullanarak RESTful API'ler geliştirdi. Ölçeklenebilir çözümler sundu, frontend entegrasyonları yaptı ve iş gereksinimlerini işlevsel platformlara dönüştürdü.",
        ]);
    }
}
