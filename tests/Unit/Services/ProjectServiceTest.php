<?php

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

beforeEach(function () {
    Project::truncate();
    $this->service = app(ProjectService::class);
});

test('service can filter projects by search', function () {
    Project::factory()->create(['title_en' => 'Project Alpha']);
    Project::factory()->create(['title_en' => 'Project Beta']);

    $results = $this->service->paginate(10, ['search' => 'Alpha']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->title_en)->toBe('Project Alpha');
});

test('service can filter featured projects', function () {
    Project::factory()->create(['is_featured' => true]);
    Project::factory()->create(['is_featured' => false]);

    $results = $this->service->paginate(10, ['featured' => '1']);

    expect($results)->toHaveCount(1)
        ->and($results->first()->is_featured)->toBeTrue();
});
