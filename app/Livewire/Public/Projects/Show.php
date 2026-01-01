<?php

namespace App\Livewire\Public\Projects;

use App\Services\ProjectService;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount($slug, ProjectService $projectService)
    {
        $this->slug = $slug;

        // Check availability in mount to handle redirects
        $project = $projectService->getBySlug($this->slug, app()->getLocale());

        if (!$project) {
            // Smart 404 Recovery: Check if slug belongs to another locale
            $alternativeProject = $projectService->findAny($this->slug);

            if ($alternativeProject) {
                $currentLocale = app()->getLocale();
                $targetSlug = $alternativeProject->{"slug_{$currentLocale}"};

                if ($targetSlug && $targetSlug !== $this->slug) {
                    $this->redirect(route('projects.show', $targetSlug), navigate: true);
                    return;
                }
            }

            abort(404);
        }
    }

    public function render(ProjectService $projectService)
    {
        $project = $projectService->getBySlug($this->slug, app()->getLocale());

        return view('livewire.public.projects.show', [
            'project' => $project
        ])->layout('layouts.app', [
            'title' => $project->title . ' | Hurşit Emre Duru',
            'meta_description' => $project->short_description,
            'og_type' => 'website',
        ]);
    }
}
