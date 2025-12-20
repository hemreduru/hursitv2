<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Simple direct query for Tags as it's a minor resource
        $tags = Tag::orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.admin.tags.index', [
            'tags' => $tags
        ])->layout('layouts.admin');
    }
}
