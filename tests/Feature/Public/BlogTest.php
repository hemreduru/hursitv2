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

test('public blog detail shows latest posts sidebar with limit and excludes drafts', function () {
    $currentPost = Post::factory()->create([
        'title_en' => 'Current Detail Post',
        'slug_en' => 'current-detail-post',
        'status' => 'published',
        'published_at' => now(),
    ]);

    Post::factory()->create([
        'title_en' => 'Draft Sidebar Candidate',
        'slug_en' => 'draft-sidebar-candidate',
        'status' => 'draft',
        'published_at' => now()->subMinute(),
    ]);

    foreach (range(1, 8) as $index) {
        Post::factory()->create([
            'title_en' => 'Sidebar Recent ' . $index,
            'slug_en' => 'sidebar-recent-' . $index,
            'status' => 'published',
            'published_at' => now()->subMinutes($index),
        ]);
    }

    $this->get(route('blog.show', $currentPost->slug_en))
        ->assertStatus(200)
        ->assertSee(__('messages.latest_posts'))
        ->assertSee('Sidebar Recent 1')
        ->assertSee('Sidebar Recent 2')
        ->assertSee('Sidebar Recent 3')
        ->assertSee('Sidebar Recent 4')
        ->assertSee('Sidebar Recent 5')
        ->assertSee('Sidebar Recent 6')
        ->assertDontSee('Sidebar Recent 7')
        ->assertDontSee('Sidebar Recent 8')
        ->assertDontSee('Draft Sidebar Candidate');
});

test('public blog detail shows previous and next post navigation links', function () {
    $olderPost = Post::factory()->create([
        'title_en' => 'Older Navigation Post',
        'slug_en' => 'older-navigation-post',
        'status' => 'published',
        'published_at' => now()->subDays(2),
    ]);

    $currentPost = Post::factory()->create([
        'title_en' => 'Current Navigation Post',
        'slug_en' => 'current-navigation-post',
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);

    $newerPost = Post::factory()->create([
        'title_en' => 'Newer Navigation Post',
        'slug_en' => 'newer-navigation-post',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('blog.show', $currentPost->slug_en))
        ->assertStatus(200)
        ->assertSee(__('messages.continue_reading'))
        ->assertSee(__('messages.previous_post'))
        ->assertSee(__('messages.next_post'))
        ->assertSee('Older Navigation Post')
        ->assertSee('Newer Navigation Post')
        ->assertSee(route('blog.show', $olderPost->slug_en))
        ->assertSee(route('blog.show', $newerPost->slug_en));
});

test('public blog detail uses localized labels for turkish locale', function () {
    $post = Post::factory()->create([
        'title_tr' => 'Detay Yazi',
        'slug_tr' => 'detay-yazi',
        'status' => 'published',
        'published_at' => now(),
    ]);

    Post::factory()->create([
        'title_tr' => 'Yandaki Yazi',
        'slug_tr' => 'yandaki-yazi',
        'status' => 'published',
        'published_at' => now()->subMinute(),
    ]);

    $this->withSession(['locale' => 'tr'])
        ->get(route('blog.show', $post->slug_tr))
        ->assertStatus(200)
        ->assertSee('Son Yazilar');
});

test('blog detail returns 404 for draft post', function () {
    $post = Post::factory()->create([
        'slug_tr' => 'draft-slug',
        'status' => 'draft'
    ]);

    $this->get(route('blog.show', $post->slug_tr))
        ->assertStatus(404);
});
