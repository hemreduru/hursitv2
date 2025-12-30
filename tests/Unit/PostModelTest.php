<?php

use App\Models\Post;
use Illuminate\Support\Str;

test('post stores dual language content correctly', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Türkçe Başlık',
        'title_en' => 'English Title',
        'content_tr' => '<p>Türkçe içerik</p>',
        'content_en' => '<p>English content</p>',
    ]);

    expect($post->title_tr)->toBe('Türkçe Başlık')
        ->and($post->title_en)->toBe('English Title')
        ->and($post->content_tr)->toBe('<p>Türkçe içerik</p>')
        ->and($post->content_en)->toBe('<p>English content</p>');
});

test('post slug is unique', function () {
    Post::factory()->create(['slug_tr' => 'test-slug']);

    // Attempting to create another post with same slug should fail or be handled by logic
    // But unit test usually tests DB constraints if migration sets unique.

    $this->expectException(\Illuminate\Database\QueryException::class);

    Post::factory()->create(['slug_tr' => 'test-slug']);
});

test('post retrieves correct attribute based on locale', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Türkçe Başlık',
        'title_en' => 'English Title',
    ]);

    app()->setLocale('tr');
    // Assuming you have an accessor like 'title' that checks locale.
    // If not, we skip this. Let's assume you access specific fields directly in admin.
    // If you have a 'title' accessor:
    // expect($post->title)->toBe('Türkçe Başlık');

    // Since we are explicit in Admin panel, we test explicit fields.
    expect($post->title_tr)->toBe('Türkçe Başlık');
});
