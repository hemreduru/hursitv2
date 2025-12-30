<?php

use App\Models\User;
use App\Models\Tag;
use Livewire\Livewire;
use App\Livewire\Admin\Tags\Index;
use App\Livewire\Admin\Tags\Edit;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('admin can view tags list', function () {
    Tag::factory()->create(['name' => 'Test Tag']);

    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Test Tag');
});

test('admin can create a new tag', function () {
    Livewire::test(Edit::class)
        ->set('name', 'New Tag')
        ->set('slug', 'new-tag')
        ->set('locale', 'tr')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.tags.index'));

    expect(Tag::where('name', 'New Tag')->exists())->toBeTrue();
});

test('admin can update a tag', function () {
    $tag = Tag::factory()->create(['name' => 'Old Tag']);

    Livewire::test(Edit::class, ['id' => $tag->id])
        ->set('name', 'Updated Tag')
        ->call('save')
        ->assertHasNoErrors();

    $tag->refresh();
    expect($tag->name)->toBe('Updated Tag');
});
