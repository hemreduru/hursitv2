<?php

namespace App\Livewire\Public\Projects;

use App\Services\ProjectService;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render(ProjectService $projectService)
    {
        $project = $projectService->getBySlug($this->slug, app()->getLocale());

        if (!$project) {
            abort(404);
        }

        return view('livewire.public.projects.show', [
            'project' => $project
        ])->layout('layouts.app', [
            'title' => $project->title . ' | Hurşit Emre Duru',
            'meta_description' => $project->short_description,
            'og_type' => 'website',
        ]);
    }
}
