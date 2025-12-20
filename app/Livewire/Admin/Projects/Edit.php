<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use App\Services\ProjectService;
use Livewire\Component;

class Edit extends Component
{
    public $project;
    public $title;
    public $slug;
    public $short_description;
    public $content;
    public $tech_stack_string; // Comma separated for input
    public $url_repo;
    public $url_live;
    public $is_featured = false;
    public $locale = 'en';

    public function mount($id = null)
    {
        if ($id) {
            $this->project = Project::findOrFail($id);
            $this->title = $this->project->title;
            $this->slug = $this->project->slug;
            $this->short_description = $this->project->short_description;
            $this->content = $this->project->content;
            $this->tech_stack_string = implode(', ', $this->project->tech_stack ?? []);
            $this->url_repo = $this->project->urls['repo'] ?? '';
            $this->url_live = $this->project->urls['live'] ?? '';
            $this->is_featured = $this->project->is_featured;
            $this->locale = $this->project->locale;
        }
    }

    public function save(ProjectService $projectService)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . ($this->project->id ?? 'NULL'),
            'short_description' => 'required|string',
            'locale' => 'required|in:en,tr',
            'tech_stack_string' => 'nullable|string',
        ]);

        $techStack = array_map('trim', explode(',', $this->tech_stack_string));
        $techStack = array_filter($techStack); // Remove empty strings

        $urls = [];
        if (!empty($this->url_repo)) $urls['repo'] = $this->url_repo;
        if (!empty($this->url_live)) $urls['live'] = $this->url_live;

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'tech_stack' => $techStack,
            'urls' => $urls, // Will be casted to array/json automatically by model
            'is_featured' => $this->is_featured,
            'locale' => $this->locale,
        ];

        if ($this->project) {
            $projectService->update($this->project->id, $data);
            session()->flash('message', 'Project updated successfully.');
        } else {
            $projectService->create($data);
            session()->flash('message', 'Project created successfully.');
            return redirect()->route('admin.projects.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.projects.edit')->layout('layouts.admin');
    }
}
