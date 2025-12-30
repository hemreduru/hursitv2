<?php

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;

test('post belongs to many tags', function () {
    $post = Post::factory()->create();
    $tag = Tag::factory()->create();

    $post->tags()->attach($tag);

    expect($post->tags)->toHaveCount(1)
        ->and($post->tags->first()->id)->toBe($tag->id);
});

test('tag belongs to many posts', function () {
    $tag = Tag::factory()->create();
    $post = Post::factory()->create();

    $tag->posts()->attach($post);

    expect($tag->posts)->toHaveCount(1)
        ->and($tag->posts->first()->id)->toBe($post->id);
});

test('posts table has required columns', function () {
    expect(Schema::hasColumns('posts', [
        'id', 'title_en', 'title_tr', 'slug_en', 'slug_tr', 'status'
    ]))->toBeTrue();
});
