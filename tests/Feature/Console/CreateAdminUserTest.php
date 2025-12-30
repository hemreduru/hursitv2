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

    expect(User::where('email', 'admin@test.com')->exists())->toBeTrue();
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
