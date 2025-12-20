<?php

namespace App\Livewire\Public\Blog;

use App\Services\PostService;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render(PostService $postService)
    {
        $post = $postService->getBySlug($this->slug, app()->getLocale());

        if (!$post) {
            abort(404);
        }

        return view('livewire.public.blog.show', [
            'post' => $post
        ])->layout('layouts.app', [
            'title' => $post->title . ' | Hurşit Emre Duru',
            'meta_description' => $post->short_description,
            'og_type' => 'article',
        ]);
    }
}
