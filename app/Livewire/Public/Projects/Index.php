<?php

namespace App\Livewire\Public\Projects;

use App\Services\ProjectService;
use Livewire\Component;

class Index extends Component
{
    public function render(ProjectService $projectService)
    {
        $projects = $projectService->getAll(app()->getLocale());

        return view('livewire.public.projects.index', [
            'projects' => $projects
        ])->layout('layouts.app');
    }
}
