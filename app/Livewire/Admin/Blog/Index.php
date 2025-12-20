<?php

namespace App\Livewire\Admin\Blog;

use App\Services\PostService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(PostService $postService)
    {
        $posts = $postService->getAllForAdmin();

        return view('livewire.admin.blog.index', [
            'posts' => $posts
        ])->layout('layouts.admin');
    }
}
