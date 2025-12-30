<?php

use App\Models\Post;

test('public blog index shows published posts', function () {
    $publishedPost = Post::factory()->create([
        'title_tr' => 'Published Post TR',
        'title_en' => 'Published Post EN',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);

    $draftPost = Post::factory()->create([
        'title_tr' => 'Draft Post TR',
        'status' => 'draft',
    ]);

    $this->get(route('blog.index'))
        ->assertStatus(200)
        ->assertSee('Published Post EN');
});

test('public blog detail page shows content', function () {
    $post = Post::factory()->create([
        'title_en' => 'Detail Post',
        'slug_en' => 'detail-post',
        'content_tr' => 'This is the content body',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('blog.show', $post->slug_en))
        ->assertStatus(200)
        ->assertSee('Detail Post');
});

test('blog detail returns 404 for draft post', function () {
    $post = Post::factory()->create([
        'slug_tr' => 'draft-slug',
        'status' => 'draft'
    ]);

    $this->get(route('blog.show', $post->slug_tr))
        ->assertStatus(404);
});
