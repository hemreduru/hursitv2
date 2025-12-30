<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('login requires recaptcha token', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        // 'g-recaptcha-response' is missing
    ])->assertSessionHasErrors(['g-recaptcha-response']);
});

test('login fails with invalid recaptcha token', function () {
    $user = User::factory()->create();

    // Mocking the Http call would be best, but we are testing full stack.
    // The real Http call to Google will fail with invalid token, which is what we want.

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'g-recaptcha-response' => 'invalid-token',
    ])->assertSessionHasErrors(['g-recaptcha-response']);
});
