<?php

use App\Models\User;
use App\Livewire\Actions\Logout;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('authenticated user can logout', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $logout = new Logout();
    $logout(request());

    expect(auth()->check())->toBeFalse();
});
