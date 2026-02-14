<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('automation api endpoints require authentication', function () {
    getJson('/api/automation/taxonomy')->assertStatus(401);
    getJson('/api/automation/dedupe-context')->assertStatus(401);
    postJson('/api/posts/automated', [])->assertStatus(401);
});

test('automation taxonomy endpoint returns canonical categories and optional tags', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $response = getJson('/api/automation/taxonomy')
        ->assertStatus(200)
        ->assertJsonStructure([
            'categories' => [['slug', 'name_en', 'name_tr']],
            'optional_tags' => [['slug', 'name_en', 'name_tr']],
        ]);

    expect($response->json('categories'))->toHaveCount(8)
        ->and(collect($response->json('categories'))->pluck('slug'))->toContain('devops')
        ->and(collect($response->json('optional_tags'))->pluck('slug'))->toContain('docker');
});

test('automation dedupe context validates query bounds', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    getJson('/api/automation/dedupe-context?days=0&limit=100')->assertStatus(422);
    getJson('/api/automation/dedupe-context?days=180&limit=300')->assertStatus(422);
});

test('automation dedupe context returns recent published post payload', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $recent = Post::factory()->create([
        'status' => 'published',
        'published_at' => now()->subDays(2),
        'source_url' => 'https://example.com/recent',
        'source_hash' => hash('sha256', 'https://example.com/recent'),
    ]);

    Post::factory()->create([
        'status' => 'published',
        'published_at' => now()->subDays(250),
        'source_url' => 'https://example.com/old',
        'source_hash' => hash('sha256', 'https://example.com/old'),
    ]);

    $response = getJson('/api/automation/dedupe-context')
        ->assertStatus(200)
        ->assertJsonPath('meta.days', 180)
        ->assertJsonPath('meta.limit', 100);

    expect(collect($response->json('items'))->pluck('id'))->toContain($recent->id);
});

test('automated post endpoint creates post and attaches canonical locale tags', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $payload = [
        'title_en' => 'Docker Build Optimization for Laravel Deployments',
        'title_tr' => 'Laravel Dagitimlari Icin Docker Build Optimizasyonu',
        'short_description_en' => 'Short EN description',
        'short_description_tr' => 'Kisa TR aciklama',
        'content_en' => '<h2>Section One</h2><p>Some english content.</p>',
        'content_tr' => '<h2>Bolum Bir</h2><p>Bazi turkce icerik.</p>',
        'status' => 'published',
        'source_url' => 'https://source.example/news/1?utm_source=x',
        'primary_category_slug' => 'devops',
        'secondary_tag_slugs' => ['docker'],
        'thumbnail' => 'https://www.hursit.me/storage/uploads/thumb.webp',
    ];

    postJson('/api/posts/automated', $payload)->assertStatus(201);

    $post = Post::query()->where('title_en', $payload['title_en'])->firstOrFail();
    $attached = $post->tags()->get(['slug', 'locale'])->map(
        static fn ($tag): string => $tag->slug.'|'.$tag->locale
    )->sort()->values()->all();

    expect($post->source_url)->toBe('https://source.example/news/1')
        ->and($post->source_hash)->toBe(hash('sha256', 'https://source.example/news/1'))
        ->and($attached)->toBe([
            'devops|en',
            'devops|tr',
            'docker|en',
            'docker|tr',
        ]);
});

test('automated post endpoint blocks duplicate source url', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $firstPayload = [
        'title_en' => 'Source Duplicate First',
        'title_tr' => 'Kaynak Kopya Birinci',
        'short_description_en' => 'desc en',
        'short_description_tr' => 'desc tr',
        'content_en' => '<p>content en</p>',
        'content_tr' => '<p>content tr</p>',
        'status' => 'published',
        'source_url' => 'https://source.example/article?a=1&utm_source=test',
        'primary_category_slug' => 'laravel',
        'secondary_tag_slugs' => ['livewire'],
    ];

    postJson('/api/posts/automated', $firstPayload)->assertStatus(201);

    $secondPayload = [
        'title_en' => 'Source Duplicate Second',
        'title_tr' => 'Kaynak Kopya Ikinci',
        'short_description_en' => 'desc en 2',
        'short_description_tr' => 'desc tr 2',
        'content_en' => '<p>content en 2</p>',
        'content_tr' => '<p>content tr 2</p>',
        'status' => 'published',
        'source_url' => 'https://source.example/article?a=1&utm_medium=email',
        'primary_category_slug' => 'laravel',
        'secondary_tag_slugs' => ['livewire'],
        'slug_en' => 'source-duplicate-second',
        'slug_tr' => 'kaynak-kopya-ikinci',
    ];

    postJson('/api/posts/automated', $secondPayload)
        ->assertStatus(409)
        ->assertJsonPath('duplicate', true)
        ->assertJsonPath('reason', 'source_url already published');
});

test('automated post endpoint blocks near-duplicate titles', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    Post::factory()->create([
        'title_en' => 'Laravel Queue Performance Deep Dive',
        'title_tr' => 'Laravel Queue Performans Derinlemesine Inceleme',
        'status' => 'published',
        'published_at' => now()->subDays(10),
        'source_url' => 'https://source.example/original',
        'source_hash' => hash('sha256', 'https://source.example/original'),
    ]);

    $payload = [
        'title_en' => 'Laravel Queue Performance Deep Dive',
        'title_tr' => 'Laravel Queue Performans Derinlemesine Inceleme',
        'slug_en' => 'laravel-queue-performance-deep-dive-new',
        'slug_tr' => 'laravel-queue-performans-derinlemesine-inceleme-yeni',
        'short_description_en' => 'desc en',
        'short_description_tr' => 'desc tr',
        'content_en' => '<p>content en</p>',
        'content_tr' => '<p>content tr</p>',
        'status' => 'published',
        'source_url' => 'https://source.example/new-source',
        'primary_category_slug' => 'performance',
        'secondary_tag_slugs' => ['queues'],
    ];

    postJson('/api/posts/automated', $payload)
        ->assertStatus(409)
        ->assertJsonPath('duplicate', true);
});

test('automated post endpoint validates primary category and optional tag constraints', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $base = [
        'title_en' => 'Validation Payload',
        'title_tr' => 'Dogrulama Yuku',
        'short_description_en' => 'desc en',
        'short_description_tr' => 'desc tr',
        'content_en' => '<p>content en</p>',
        'content_tr' => '<p>content tr</p>',
        'status' => 'published',
        'source_url' => 'https://source.example/validation',
    ];

    postJson('/api/posts/automated', $base + [
        'primary_category_slug' => 'not-valid',
        'secondary_tag_slugs' => ['docker'],
    ])->assertStatus(422)->assertJsonValidationErrors(['primary_category_slug']);

    postJson('/api/posts/automated', $base + [
        'source_url' => 'https://source.example/validation-2',
        'primary_category_slug' => 'devops',
        'secondary_tag_slugs' => ['docker', 'kubernetes', 'redis'],
    ])->assertStatus(422)->assertJsonValidationErrors(['secondary_tag_slugs']);

    postJson('/api/posts/automated', $base + [
        'source_url' => 'https://source.example/validation-3',
        'primary_category_slug' => 'devops',
        'secondary_tag_slugs' => ['docker', 'random-tag'],
    ])->assertStatus(422)->assertJsonValidationErrors(['secondary_tag_slugs.1']);
});
