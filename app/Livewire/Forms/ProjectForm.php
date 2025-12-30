<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\Project;

class ProjectForm extends Form
{
    public ?Project $project = null;

    // English Fields
    public $title_en = '';
    public $title_tr = '';
    public $slug_en = '';
    public $slug_tr = '';
    public $short_description_en = '';
    public $short_description_tr = '';
    public $content_en = '';
    public $content_tr = '';

    // Shared Fields
    public $tech_stack_string = '';
    public $url_repo = '';
    public $url_live = '';
    public $is_featured = false;

    public function setProject(Project $project)
    {
        $this->project = $project;
        $this->title_en = $project->title_en;
        $this->title_tr = $project->title_tr;
        $this->slug_en = $project->slug_en;
        $this->slug_tr = $project->slug_tr;
        $this->short_description_en = $project->short_description_en;
        $this->short_description_tr = $project->short_description_tr;
        $this->content_en = $project->content_en;
        $this->content_tr = $project->content_tr;

        $this->tech_stack_string = implode(', ', $project->tech_stack ?? []);
        $this->url_repo = $project->urls['repo'] ?? '';
        $this->url_live = $project->urls['live'] ?? '';
        $this->is_featured = $project->is_featured;
    }

    public function rules()
    {
        return [
            'title_en' => 'required|string|max:255',
            'title_tr' => 'required|string|max:255',
            'slug_en' => 'required|string|max:255|unique:projects,slug_en,' . ($this->project->id ?? 'NULL'),
            'slug_tr' => 'required|string|max:255|unique:projects,slug_tr,' . ($this->project->id ?? 'NULL'),
            'short_description_en' => 'required|string',
            'short_description_tr' => 'required|string',
            'content_en' => 'required|string',
            'content_tr' => 'required|string',

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
            'title_en' => $this->title_en,
            'title_tr' => $this->title_tr,
            'slug_en' => $this->slug_en,
            'slug_tr' => $this->slug_tr,
            'short_description_en' => $this->short_description_en,
            'short_description_tr' => $this->short_description_tr,
            'content_en' => $this->content_en,
            'content_tr' => $this->content_tr,
            'tech_stack' => $techStack,
            'urls' => $urls,
            'is_featured' => $this->is_featured,
        ];
    }
}
