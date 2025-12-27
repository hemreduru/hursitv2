<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\Project;

class ProjectForm extends Form
{
    public ?Project $project = null;

    public $title = '';
    public $slug = '';
    public $short_description = '';
    public $content = '';
    public $tech_stack_string = '';
    public $url_repo = '';
    public $url_live = '';
    public $is_featured = false;
    public $locale = 'en';

    public function setProject(Project $project)
    {
        $this->project = $project;
        $this->title = $project->title;
        $this->slug = $project->slug;
        $this->short_description = $project->short_description;
        $this->content = $project->content;
        $this->tech_stack_string = implode(', ', $project->tech_stack ?? []);
        $this->url_repo = $project->urls['repo'] ?? '';
        $this->url_live = $project->urls['live'] ?? '';
        $this->is_featured = $project->is_featured;
        $this->locale = $project->locale;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . ($this->project->id ?? 'NULL'),
            'short_description' => 'required|string',
            'content' => 'nullable|string',
            'locale' => 'required|in:en,tr',
            'tech_stack_string' => 'nullable|string',
            'url_repo' => 'nullable|url',
            'url_live' => 'nullable|url',
            'is_featured' => 'boolean',
        ];
    }

    public function prepareData()
    {
        $this->validate();

        $techStack = array_map('trim', explode(',', $this->tech_stack_string));
        $techStack = array_filter($techStack);

        $urls = [];
        if (!empty($this->url_repo)) $urls['repo'] = $this->url_repo;
        if (!empty($this->url_live)) $urls['live'] = $this->url_live;

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'tech_stack' => $techStack,
            'urls' => $urls,
            'is_featured' => $this->is_featured,
            'locale' => $this->locale,
        ];
    }
}
