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

test('service returns latest published posts except active post with limit', function () {
    $activePost = Post::factory()->create([
        'title_en' => 'Active Post',
        'status' => 'published',
        'published_at' => now()->subMinutes(30),
    ]);

    Post::factory()->create([
        'title_en' => 'Draft Candidate',
        'status' => 'draft',
        'published_at' => now()->subMinute(),
    ]);

    foreach (range(1, 8) as $index) {
        Post::factory()->create([
            'title_en' => 'Recent Post ' . $index,
            'status' => 'published',
            'published_at' => now()->subMinutes($index),
        ]);
    }

    $results = $this->service->getLatestPublishedExcept($activePost->id, 6);
    $titles = $results->pluck('title_en')->values()->all();

    expect($results)->toHaveCount(6)
        ->and($results->contains('id', $activePost->id))->toBeFalse()
        ->and($titles)->toBe([
            'Recent Post 1',
            'Recent Post 2',
            'Recent Post 3',
            'Recent Post 4',
            'Recent Post 5',
            'Recent Post 6',
        ]);
});

test('service returns previous and next published posts using published_at and id ordering', function () {
    $referenceTime = now()->startOfMinute();

    $sameTimeLower = Post::factory()->create([
        'title_en' => 'Same Time Lower',
        'status' => 'published',
        'published_at' => $referenceTime,
    ]);

    $currentPost = Post::factory()->create([
        'title_en' => 'Current Post',
        'status' => 'published',
        'published_at' => $referenceTime,
    ]);

    $sameTimeHigher = Post::factory()->create([
        'title_en' => 'Same Time Higher',
        'status' => 'published',
        'published_at' => $referenceTime,
    ]);

    Post::factory()->create([
        'title_en' => 'Older Post',
        'status' => 'published',
        'published_at' => $referenceTime->copy()->subDay(),
    ]);

    Post::factory()->create([
        'title_en' => 'Newer Post',
        'status' => 'published',
        'published_at' => $referenceTime->copy()->addDay(),
    ]);

    Post::factory()->create([
        'title_en' => 'Draft Same Time',
        'status' => 'draft',
        'published_at' => $referenceTime,
    ]);

    $previousPost = $this->service->getPreviousPublished($currentPost);
    $nextPost = $this->service->getNextPublished($currentPost);

    expect($previousPost?->id)->toBe($sameTimeHigher->id)
        ->and($nextPost?->id)->toBe($sameTimeLower->id);
});
