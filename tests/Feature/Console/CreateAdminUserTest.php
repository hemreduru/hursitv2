<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('console can create admin user', function () {
    $this->artisan('app:register')
        ->expectsQuestion('Full Name', 'Admin Test')
        ->expectsQuestion('Email Address', 'admin@test.com')
        ->expectsQuestion('Password', 'password123')
        ->expectsQuestion('Confirm Password', 'password123')
        ->expectsOutput('Admin user [admin@test.com] created successfully!')
        ->assertExitCode(0);

    $user = User::where('email', 'admin@test.com')->first();
    expect($user)->not->toBeNull();
    expect($user->is_admin)->toBeTrue();
});

test('console warns if user exists', function () {
    // Create pre-existing user
    User::factory()->create(['email' => 'admin@test.com']);

    // The command logic uses Validator which prints errors and returns 1
    $this->artisan('app:register')
        ->expectsQuestion('Full Name', 'New Admin')
        ->expectsQuestion('Email Address', 'admin@test.com')
        ->expectsQuestion('Password', 'password123')
        ->expectsQuestion('Confirm Password', 'password123')
        ->expectsOutput('The email has already been taken.')
        ->assertExitCode(1);
});

test('console can promote existing user to admin', function () {
    $user = User::factory()->create(['email' => 'promote@test.com', 'is_admin' => false]);

    $this->artisan('app:promote-admin', ['email' => 'promote@test.com'])
        ->expectsOutput('User promoted to admin: promote@test.com')
        ->assertExitCode(0);

    expect($user->fresh()->is_admin)->toBeTrue();
});
