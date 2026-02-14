<?php

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Services\HomeService;

test('home service resolves the same primary profile for all locales', function () {
    $primary = Profile::factory()->create(['name' => 'Primary Profile']);
    Profile::factory()->create(['name' => 'Secondary Profile']);

    $homeService = app(HomeService::class);

    $homeEn = $homeService->getHomeData('en');
    $homeTr = $homeService->getHomeData('tr');

    expect($homeEn['profile'])->not->toBeNull()
        ->and($homeTr['profile'])->not->toBeNull()
        ->and($homeEn['profile']->id)->toBe($primary->id)
        ->and($homeTr['profile']->id)->toBe($primary->id);
});

test('profile repository returns primary profile record', function () {
    $primary = Profile::factory()->create(['name' => 'Primary Profile']);
    Profile::factory()->create(['name' => 'Secondary Profile']);

    $repository = app(ProfileRepositoryInterface::class);

    expect($repository->getPrimary())->not->toBeNull()
        ->and($repository->getPrimary()->id)->toBe($primary->id);
});
