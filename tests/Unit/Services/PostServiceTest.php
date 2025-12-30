<?php

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

use Illuminate\Support\Facades\DB;

beforeEach(function () {
    DB::table('post_tag')->delete();
    Post::query()->delete();
    $this->service = app(PostService::class);
});

test('service can filter posts by search term', function () {
    Post::factory()->create(['title_en' => 'Unique Term Search']);
    Post::factory()->create(['title_en' => 'Ignored Post']);

    $results = $this->service->getAllForAdmin(10, ['search' => 'Unique Term']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->title_en)->toBe('Unique Term Search');
});

test('service can filter posts by status', function () {
    Post::factory()->create(['status' => 'published']);
    Post::factory()->create(['status' => 'draft']);

    $results = $this->service->getAllForAdmin(10, ['status' => 'published']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->status)->toBe('published');
});

test('service can filter by both search and status', function () {
    Post::factory()->create(['title_en' => 'FindMe', 'status' => 'published']);
    Post::factory()->create(['title_en' => 'FindMe', 'status' => 'draft']);
    Post::factory()->create(['title_en' => 'Ignore', 'status' => 'published']);

    $results = $this->service->getAllForAdmin(10, ['search' => 'FindMe', 'status' => 'published']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->title_en)->toBe('FindMe')
        ->and($results->first()->status)->toBe('published');
});
