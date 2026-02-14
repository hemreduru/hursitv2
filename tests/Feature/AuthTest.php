<?php

use App\Models\User;

test('login page is accessible', function () {
    $this->get('/login')->assertStatus(200);
});

use Illuminate\Support\Facades\Http;

test('users can authenticate', function () {
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
    ]);

    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Default factory password
        'g-recaptcha-response' => 'test-token',
    ])->assertRedirect('/admin/dashboard');

    $this->assertAuthenticated();
});

test('users cannot authenticate with invalid password', function () {
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
    ]);

    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'g-recaptcha-response' => 'test-token',
    ]);

    $this->assertGuest();
});

test('unauthenticated users cannot access admin dashboard', function () {
    $this->get('/admin/dashboard')->assertRedirect('/login');
});
