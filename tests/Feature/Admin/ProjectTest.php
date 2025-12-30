<?php

use App\Models\User;
use App\Models\Project;
use Livewire\Livewire;
use App\Livewire\Admin\Projects\Index;
use App\Livewire\Admin\Projects\Edit;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('admin can view projects list', function () {
    $uniqueTitle = 'Unique Project List ' . uniqid();
    Project::factory()->create([
        'title_tr' => $uniqueTitle,
        'title_en' => $uniqueTitle,
    ]);

    Livewire::test(Index::class)
        ->set('search', $uniqueTitle)
        ->assertStatus(200)
        ->assertSee($uniqueTitle);
});

test('admin can create a new project', function () {
    $uniqueTitle = 'Unique New Project ' . uniqid();

    Livewire::test(Edit::class)
        ->set('form.title_tr', $uniqueTitle)
        ->set('form.title_en', 'New Project EN')
        ->set('form.content_tr', 'Detaylar')
        ->set('form.content_en', 'Details')
        ->set('form.short_description_tr', 'Kısa Açıklama')
        ->set('form.short_description_en', 'Short Desc')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.projects.index'));

    expect(Project::where('title_tr', $uniqueTitle)->exists())->toBeTrue();
});

test('admin can delete a project', function () {
    $project = Project::factory()->create();

    Livewire::test(Index::class)
        ->call('delete', $project->id);

    expect(Project::find($project->id))->toBeNull();
});
