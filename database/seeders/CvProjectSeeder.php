<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CvProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Harbeli Bilişim
        Project::create([
            'title_en' => 'Harbeli Bilişim',
            'title_tr' => 'Harbeli Bilişim',
            'slug_en' => Str::slug('Harbeli Bilişim'),
            'slug_tr' => Str::slug('Harbeli Bilişim'),
            'short_description_en' => 'Full rebuild of a WordPress site using Laravel, including automated data migration.',
            'short_description_tr' => 'WordPress tabanlı sitenin Laravel ile yeniden yazılması ve otomatik veri taşıma işlemi.',
            'content_en' => 'Maintained and updated existing WordPress site. Developed custom product import. Fully rebuilt system using Laravel/MySQL with automated migration from WordPress.',
            'content_tr' => 'Mevcut WordPress sitesinin bakımı yapıldı. Özel ürün içe aktarma mekanizması geliştirildi. Sistem Laravel/MySQL ile yeniden yazıldı ve WordPress\'ten otomatik veri taşıma sağlandı.',
            'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'WordPress Migration'],
            'is_featured' => true,
        ]);

        // 2. Echt Zorg Travel
        Project::create([
            'title_en' => 'Echt Zorg Travel',
            'title_tr' => 'Echt Zorg Travel',
            'slug_en' => Str::slug('Echt Zorg Travel'),
            'slug_tr' => Str::slug('Echt Zorg Travel TR'),
            'short_description_en' => 'Custom ERP/CMS built from scratch tailored for travel management.',
            'short_description_tr' => 'Seyahat yönetimi için sıfırdan geliştirilen özel ERP/CMS sistemi.',
            'content_en' => 'Built from scratch using Laravel. Designed as a mini CMS for flexibility. Integrated Email, SMS, Telegram notifications and CI/CD pipelines.',
            'content_tr' => 'Laravel kullanılarak sıfırdan geliştirildi. Esneklik için mini CMS olarak tasarlandı. E-posta, SMS, Telegram bildirimleri ve CI/CD süreçleri entegre edildi.',
            'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Minio', 'CI/CD'],
            'is_featured' => true,
        ]);
    }
}
