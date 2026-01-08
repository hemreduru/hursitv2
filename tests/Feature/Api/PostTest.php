<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\{postJson, assertDatabaseHas};

test('api requests require authentication', function () {
    postJson('/api/posts', [])
        ->assertStatus(401);
});

test('authenticated user can create a post', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $data = [
        'title_en' => 'Test Post EN',
        'title_tr' => 'Test Post TR',
        'short_description_en' => 'Short desc EN',
        'short_description_tr' => 'Short desc TR',
        'content_en' => '<p>Content EN</p>',
        'content_tr' => '<p>Content TR</p>',
        'status' => 'draft',
        'thumbnail' => 'https://hursit.me/storage/uploads/test.jpg',
    ];

    $response = postJson('/api/posts', $data)
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'id',
            'link',
            'links' => ['en']
        ]);

    assertDatabaseHas('posts', [
        'title_en' => 'Test Post EN',
        'slug_en' => 'test-post-en', // Auto generated
        'slug_tr' => 'test-post-tr', // Auto generated
        'thumbnail' => 'https://hursit.me/storage/uploads/test.jpg',
    ]);
});

test('api validates required fields', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    postJson('/api/posts', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['title_en', 'title_tr', 'content_en']);
});

test('api respects provided slugs', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $data = [
        'title_en' => 'Test Post EN',
        'title_tr' => 'Test Post TR',
        'slug_en' => 'custom-slug-en',
        'slug_tr' => 'custom-slug-tr',
        'short_description_en' => 'Short desc EN',
        'short_description_tr' => 'Short desc TR',
        'content_en' => '<p>Content EN</p>',
        'content_tr' => '<p>Content TR</p>',
    ];

    postJson('/api/posts', $data)
        ->assertStatus(201);

    assertDatabaseHas('posts', [
        'slug_en' => 'custom-slug-en',
        'slug_tr' => 'custom-slug-tr',
    ]);
});

test('api returns correct link', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $data = [
        'title_en' => 'Link Test',
        'title_tr' => 'Link Test TR',
        'short_description_en' => 'SD',
        'short_description_tr' => 'SD',
        'content_en' => 'C',
        'content_tr' => 'C',
    ];

    $response = postJson('/api/posts', $data)->assertStatus(201);

    $slug = \Illuminate\Support\Str::slug('Link Test');
    $expectedLink = route('blog.show', $slug);

    expect($response->json('link'))->toBe($expectedLink);
});

test('api creates new tags from strings', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $data = [
        'title_en' => 'Tag Test',
        'title_tr' => 'Tag Test TR',
        'short_description_en' => 'SD',
        'short_description_tr' => 'SD',
        'content_en' => 'C',
        'content_tr' => 'C',
        'tags' => ['Existing Tag', 'New Dynamic Tag'],
    ];

    \App\Models\Tag::create(['name' => 'Existing Tag', 'slug' => 'existing-tag', 'locale' => 'en']);

    postJson('/api/posts', $data)->assertStatus(201);

    assertDatabaseHas('tags', ['name' => 'New Dynamic Tag']);
    assertDatabaseHas('tags', ['name' => 'Existing Tag']);

    $post = \App\Models\Post::where('title_en', 'Tag Test')->first();
    expect($post->tags)->toHaveCount(2);
});
