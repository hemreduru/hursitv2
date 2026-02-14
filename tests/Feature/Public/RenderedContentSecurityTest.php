<?php

use App\Services\PostService;
use App\Services\ProjectService;

test('public blog rendering does not expose unsafe payloads', function () {
    $post = app(PostService::class)->create([
        'title_en' => 'Safe Blog Post',
        'title_tr' => 'Guvenli Blog Yazisi',
        'slug_en' => 'safe-blog-post',
        'slug_tr' => 'guvenli-blog-yazisi',
        'short_description_en' => 'Safe short description',
        'short_description_tr' => 'Guvenli kisa aciklama',
        'content_en' => '<p>Safe Content</p><script>alert("script-token")</script><img src=x onerror="alert(\'xss-token\')"><a href="javascript:alert(\'js-token\')">link</a>',
        'content_tr' => '<p>Guvenli Icerik</p><script>alert("script-token-tr")</script>',
        'status' => 'published',
        'published_at' => now(),
        'reading_time' => 5,
    ]);

    $this->get(route('blog.show', $post->slug_en))
        ->assertOk()
        ->assertSee('Safe Content')
        ->assertDontSee('script-token')
        ->assertDontSee('xss-token')
        ->assertDontSee('js-token');
});

test('public project rendering does not expose unsafe payloads', function () {
    $project = app(ProjectService::class)->create([
        'title_en' => 'Safe Project',
        'title_tr' => 'Guvenli Proje',
        'slug_en' => 'safe-project',
        'slug_tr' => 'guvenli-proje',
        'short_description_en' => 'Safe project desc',
        'short_description_tr' => 'Guvenli proje aciklamasi',
        'content_en' => '<p>Safe Project Content</p><iframe src="https://evil.test"></iframe><script>alert("project-script-token")</script>',
        'content_tr' => '<p>Guvenli Proje Icerigi</p>',
        'tech_stack' => ['Laravel', 'Livewire'],
        'urls' => ['repo' => 'https://example.com/repo'],
        'is_featured' => true,
    ]);

    $this->get(route('projects.show', $project->slug_en))
        ->assertOk()
        ->assertSee('Safe Project Content')
        ->assertDontSee('project-script-token');
});
