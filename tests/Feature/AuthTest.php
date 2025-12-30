<?php

use App\Models\User;

test('login page is accessible', function () {
    $this->get('/login')->assertStatus(200);
});

test('users can authenticate', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Default factory password
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('unauthenticated users cannot access admin dashboard', function () {
    $this->get('/admin/dashboard')->assertRedirect('/login');
});
