<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use App\Services\ProjectService;
use Livewire\Component;

class Edit extends Component
{
    public \App\Livewire\Forms\ProjectForm $form;

    public function mount($id = null)
    {
        if ($id) {
            $project = Project::findOrFail($id);
            $this->form->setProject($project);
        }
    }

    public function save(ProjectService $projectService)
    {
        try {
            $data = $this->form->prepareData();

            if ($this->form->project) {
                $projectService->update($this->form->project->id, $data);
                session()->flash('message', 'Project updated successfully.');
            } else {
                $projectService->create($data);
                session()->flash('message', 'Project created successfully.');
                return redirect()->route('admin.projects.index');
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.projects.edit')->layout('layouts.admin');
    }
}
