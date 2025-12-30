<?php

namespace App\Livewire\Admin\Projects;

use App\Services\ProjectService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $featured = '';
    public $locale = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'featured' => ['except' => ''],
        'locale' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFeatured()
    {
        $this->resetPage();
    }

    public function updatedLocale()
    {
        $this->resetPage();
    }

    public function render(ProjectService $projectService)
    {
        $filters = [
            'search' => $this->search,
            'featured' => $this->featured,
            'locale' => $this->locale,
        ];

        $projects = $projectService->paginate(10, $filters);

        return view('livewire.admin.projects.index', [
            'projects' => $projects
        ])->layout('layouts.admin');
    }

    public function delete($id)
    {
        $project = \App\Models\Project::find($id);
        if ($project) {
            $project->delete();
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('messages.item_deleted')
            ]);
        }
    }
}
