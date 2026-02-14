<?php

use App\Models\User;
use App\Livewire\Admin\Profile\Index;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('admin can view profile index', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('admin.profile.index'))
        ->assertStatus(200);
});

test('profile index component renders', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    Livewire::test(Index::class)
        ->assertStatus(200);
});
