<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\{postJson};

test('api upload requires authentication', function () {
    postJson('/api/upload', [])
        ->assertStatus(401);
});

test('authenticated user can upload an image', function () {
    Config::set('filesystems.uploads_disk', 'public');
    Storage::fake('public');
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $file = UploadedFile::fake()->image('test-image.jpg');

    $response = postJson('/api/upload', [
        'file' => $file,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'path',
            'url',
        ]);

    // Check if file stored
    $path = $response->json('path');
    Storage::disk('public')->assertExists($path);
});

test('api upload stores files on configured disk', function () {
    Config::set('filesystems.uploads_disk', 's3');
    Storage::fake('s3');

    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    $response = postJson('/api/upload', [
        'file' => UploadedFile::fake()->image('s3-image.jpg'),
    ])->assertStatus(201);

    Storage::disk('s3')->assertExists($response->json('path'));
});

test('api upload validates image file', function () {
    $user = User::factory()->admin()->create();
    Sanctum::actingAs($user, ['*']);

    postJson('/api/upload', ['file' => 'not-a-file'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['file']);

    $pdf = UploadedFile::fake()->create('document.pdf', 100);
    postJson('/api/upload', ['file' => $pdf])
        ->assertStatus(422) // Expecting image validation to fail
        ->assertJsonValidationErrors(['file']);
});
