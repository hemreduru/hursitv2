<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use App\Services\TagService;
use Livewire\Component;

class Edit extends Component
{
    public $tag;
    public $name;
    public $slug;
    public $locale = 'en';

    public function mount($id = null)
    {
        if ($id) {
            $this->tag = Tag::findOrFail($id);
            $this->name = $this->tag->name;
            $this->slug = $this->tag->slug;
            $this->locale = $this->tag->locale;
        }
    }

    public function save(TagService $tagService)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('tags')->ignore($this->tag?->id)],
            'locale' => 'required|in:en,tr',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'locale' => $this->locale,
        ];

        if ($this->tag) {
            $tagService->update($this->tag, $data);
            session()->flash('message', 'Tag updated successfully.');
        } else {
            $tagService->create($data);
            session()->flash('message', 'Tag created successfully.');
            return redirect()->route('admin.tags.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.tags.edit')->layout('layouts.admin');
    }
}
