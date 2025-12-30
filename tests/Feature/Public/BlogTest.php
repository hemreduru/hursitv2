<?php

use App\Models\Post;
use App\Models\Tag;
use Livewire\Livewire;
use App\Livewire\Public\Blog\Index;

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

test('public blog can be filtered by tag', function () {
    $tag = Tag::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);
    $post = Post::factory()->create(['title_en' => 'Laravel Post', 'status' => 'published']);
    $post->tags()->attach($tag);

    $otherPost = Post::factory()->create(['title_en' => 'Other Post', 'status' => 'published']);

    Livewire::test(Index::class)
        ->set('tag', 'Laravel')
        ->assertSee('Laravel Post')
        ->assertDontSee('Other Post');
});

test('public blog can be filtered by search', function () {
    Post::factory()->create(['title_en' => 'SearchMe', 'status' => 'published']);
    Post::factory()->create(['title_en' => 'IgnoreMe', 'status' => 'published']);

    Livewire::test(Index::class)
        ->set('search', 'SearchMe')
        ->assertSee('SearchMe')
        ->assertDontSee('IgnoreMe');
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
