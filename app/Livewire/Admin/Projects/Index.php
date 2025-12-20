<?php

namespace App\Livewire\Admin\Projects;

use App\Services\ProjectService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(ProjectService $projectService)
    {
        $projects = $projectService->paginate(10);

        return view('livewire.admin.projects.index', [
            'projects' => $projects
        ])->layout('layouts.admin');
    }
}
