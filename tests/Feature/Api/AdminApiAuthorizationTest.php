<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;

test('non-admin api users cannot create posts', function () {
    $user = User::factory()->create(['is_admin' => false]);
    Sanctum::actingAs($user, ['*']);

    $payload = [
        'title_en' => 'Blocked Post EN',
        'title_tr' => 'Blocked Post TR',
        'short_description_en' => 'Short EN',
        'short_description_tr' => 'Short TR',
        'content_en' => '<p>Content EN</p>',
        'content_tr' => '<p>Content TR</p>',
    ];

    postJson('/api/posts', $payload)->assertForbidden();
});

test('non-admin api users cannot upload files', function () {
    Storage::fake('public');
    $user = User::factory()->create(['is_admin' => false]);
    Sanctum::actingAs($user, ['*']);

    postJson('/api/upload', [
        'file' => UploadedFile::fake()->image('blocked.jpg'),
    ])->assertForbidden();
});
