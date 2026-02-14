<?php

return [
    'categories' => [
        ['slug' => 'laravel', 'name_en' => 'Laravel', 'name_tr' => 'Laravel'],
        ['slug' => 'php', 'name_en' => 'PHP', 'name_tr' => 'PHP'],
        ['slug' => 'devops', 'name_en' => 'DevOps', 'name_tr' => 'DevOps'],
        ['slug' => 'cloud', 'name_en' => 'Cloud', 'name_tr' => 'Bulut'],
        ['slug' => 'security', 'name_en' => 'Security', 'name_tr' => 'Guvenlik'],
        ['slug' => 'performance', 'name_en' => 'Performance', 'name_tr' => 'Performans'],
        ['slug' => 'testing', 'name_en' => 'Testing', 'name_tr' => 'Test'],
        ['slug' => 'architecture', 'name_en' => 'Architecture', 'name_tr' => 'Mimari'],
    ],
    'optional_tags' => [
        ['slug' => 'docker', 'name_en' => 'Docker', 'name_tr' => 'Docker'],
        ['slug' => 'kubernetes', 'name_en' => 'Kubernetes', 'name_tr' => 'Kubernetes'],
        ['slug' => 'ci-cd', 'name_en' => 'CI/CD', 'name_tr' => 'CI/CD'],
        ['slug' => 'github-actions', 'name_en' => 'GitHub Actions', 'name_tr' => 'GitHub Actions'],
        ['slug' => 'observability', 'name_en' => 'Observability', 'name_tr' => 'Gozlemlenebilirlik'],
        ['slug' => 'mysql', 'name_en' => 'MySQL', 'name_tr' => 'MySQL'],
        ['slug' => 'redis', 'name_en' => 'Redis', 'name_tr' => 'Redis'],
        ['slug' => 'queues', 'name_en' => 'Queues', 'name_tr' => 'Kuyruklar'],
        ['slug' => 'caching', 'name_en' => 'Caching', 'name_tr' => 'Onbellekleme'],
        ['slug' => 'api-design', 'name_en' => 'API Design', 'name_tr' => 'API Tasarimi'],
        ['slug' => 'livewire', 'name_en' => 'Livewire', 'name_tr' => 'Livewire'],
        ['slug' => 'frankenphp', 'name_en' => 'FrankenPHP', 'name_tr' => 'FrankenPHP'],
    ],
    'limits' => [
        'secondary_tags_max' => 2,
    ],
    'dedupe' => [
        'days_default' => 180,
        'limit_default' => 100,
        'title_similarity_threshold' => 80.0,
    ],
];
