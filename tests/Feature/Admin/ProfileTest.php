<?php

use App\Models\User;
use App\Models\Profile;
use Livewire\Livewire;
use App\Livewire\Admin\Profile\Edit;

beforeEach(function () {
    $this->user = User::factory()->admin()->create();
    $this->actingAs($this->user);
});

test('admin can create or update profile info', function () {
    // Ensure no profile exists first or create one if needed
    Profile::truncate();

    Livewire::test(Edit::class)
        ->set('form.name', 'New Profile User')
        ->set('form.contact_email', 'new@example.com')
        ->set('form.title_en', 'Software Developer')
        ->set('form.title_tr', 'Yazılım Geliştirici')
        ->set('form.bio_en', 'Bio EN')
        ->set('form.bio_tr', 'Bio TR')
        ->call('save')
        ->assertHasNoErrors();

    $profile = Profile::first();
    expect($profile->name)->toBe('New Profile User')
        ->and($profile->contact_email)->toBe('new@example.com');
});
