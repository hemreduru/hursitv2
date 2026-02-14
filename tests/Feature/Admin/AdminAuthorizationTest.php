<?php

use App\Models\User;

test('non-admin users get forbidden for admin routes', function (string $routeName) {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get(route($routeName))
        ->assertForbidden();
})->with([
    'admin.dashboard',
    'admin.blog.index',
    'admin.projects.index',
    'admin.tags.index',
    'admin.profile.index',
]);

test('admin users can access admin routes', function (string $routeName) {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route($routeName))
        ->assertOk();
})->with([
    'admin.dashboard',
    'admin.blog.index',
    'admin.projects.index',
    'admin.tags.index',
    'admin.profile.index',
]);
