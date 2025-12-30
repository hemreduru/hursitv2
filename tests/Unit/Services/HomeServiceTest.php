<?php

use App\Services\HomeService;
use App\Models\Skill;
use App\Models\Experience;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

beforeEach(function () {
    Experience::truncate();
    Skill::truncate();
    $this->service = app(HomeService::class);
});

test('home service retrieves skills and experiences', function () {
    // Skills are grouped by 'category' in the repo method getAllGroupedByCategory()
    Skill::factory()->create(['category' => 'Frontend', 'name' => 'Vue.js']);

    // Experience uses locale
    Experience::factory()->create(['company' => 'Tech Corp', 'locale' => 'en']);

    $data = $this->service->getHomeData('en');

    expect($data['skills'])->not->toBeEmpty()
        ->and($data['experiences'])->not->toBeEmpty()
        ->and($data['experiences']->first()->company)->toBe('Tech Corp');
});
