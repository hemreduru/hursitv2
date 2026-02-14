<?php

use App\Models\User;
use App\Livewire\Admin\Dashboard;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('admin can view dashboard', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertStatus(200);
});

test('dashboard component renders', function () {
    $user = User::factory()->admin()->create();
    $this->actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertStatus(200);
});
