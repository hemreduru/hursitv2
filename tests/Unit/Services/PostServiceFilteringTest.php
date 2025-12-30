<?php

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

beforeEach(function () {
    DB::table('post_tag')->delete();
    Post::query()->delete();
    $this->service = app(PostService::class);
});

test('service can get published posts with tag filter', function () {
    $tag = Tag::factory()->create(['name' => 'Laravel']);
    $post = Post::factory()->create(['title_en' => 'Tagged Post', 'status' => 'published']);
    $post->tags()->attach($tag);

    Post::factory()->create(['title_en' => 'Untagged Post', 'status' => 'published']);

    $results = $this->service->getPublishedWithFilters('en', 10, ['tag' => 'Laravel']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->title_en)->toBe('Tagged Post');
});

test('service can get published posts with search filter', function () {
    Post::factory()->create(['title_en' => 'Searchable Content', 'status' => 'published']);
    Post::factory()->create(['title_en' => 'Hidden Content', 'status' => 'published']);

    $results = $this->service->getPublishedWithFilters('en', 10, ['search' => 'Searchable']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->title_en)->toBe('Searchable Content');
});
