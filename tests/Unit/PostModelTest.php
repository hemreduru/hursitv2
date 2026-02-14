<?php

use App\Models\Post;

test('post stores dual language content correctly', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Turkce Baslik',
        'title_en' => 'English Title',
        'content_tr' => '<p>Turkce icerik</p>',
        'content_en' => '<p>English content</p>',
    ]);

    expect($post->title_tr)->toBe('Turkce Baslik')
        ->and($post->title_en)->toBe('English Title')
        ->and($post->content_tr)->toBe('<p>Turkce icerik</p>')
        ->and($post->content_en)->toBe('<p>English content</p>');
});

test('post slug is unique', function () {
    Post::factory()->create(['slug_tr' => 'test-slug']);

    $this->expectException(\Illuminate\Database\QueryException::class);

    Post::factory()->create(['slug_tr' => 'test-slug']);
});

test('post retrieves correct attribute based on locale', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Turkce Baslik',
        'title_en' => 'English Title',
    ]);

    app()->setLocale('tr');
    expect($post->title)->toBe('Turkce Baslik');

    app()->setLocale('en');
    expect($post->title)->toBe('English Title');
});

test('post reading time is calculated dynamically from localized content', function () {
    $englishContent = '<p>' . implode(' ', array_fill(0, 420, 'word')) . '</p>';
    $turkishContent = '<p>' . implode(' ', array_fill(0, 80, 'kelime')) . '</p>';

    $post = Post::factory()->create([
        'content_en' => $englishContent,
        'content_tr' => $turkishContent,
        'reading_time' => 99,
    ]);

    app()->setLocale('en');
    expect($post->reading_time)->toBe(3);

    app()->setLocale('tr');
    expect($post->reading_time)->toBe(1);
});

test('post reading time falls back to stored value when localized content is empty', function () {
    $post = Post::factory()->create([
        'content_en' => '',
        'content_tr' => '',
        'reading_time' => 7,
    ]);

    app()->setLocale('en');
    expect($post->reading_time)->toBe(7);
});
