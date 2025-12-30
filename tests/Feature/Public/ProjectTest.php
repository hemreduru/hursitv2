<?php

use App\Models\Project;

test('public project index loads', function () {
    $project = Project::factory()->create([
        'title_tr' => 'My Awesome Project',
        'title_en' => 'My Awesome Project',
    ]);

    $this->get(route('projects.index'))
        ->assertStatus(200)
        ->assertSee('My Awesome Project');
});

test('public project detail page shows content', function () {
    $project = Project::factory()->create([
        'title_tr' => 'Detail Project',
        'title_en' => 'Detail Project',
        'slug_tr' => 'detail-project-tr',
        'slug_en' => 'detail-project-en',
        'content_tr' => 'Project deep dive content',
        'tech_stack' => ['Laravel', 'Vue'],
    ]);

    $this->get(route('projects.show', $project->slug_en))
        ->assertStatus(200)
        ->assertSee('Detail Project');
});
