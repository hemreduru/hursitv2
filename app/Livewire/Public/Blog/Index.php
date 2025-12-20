<?php

namespace App\Livewire\Public\Blog;

use App\Services\PostService;
use Livewire\Component;

class Index extends Component
{
    public function render(PostService $postService)
    {
        $posts = $postService->getPublished(app()->getLocale());

        return view('livewire.public.blog.index', [
            'posts' => $posts
        ])->layout('layouts.app');
    }
}
