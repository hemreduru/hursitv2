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
            // Smart 404 Recovery: Check if slug belongs to another locale
            $alternativePost = $postService->findAny($this->slug);

            if ($alternativePost) {
                $currentLocale = app()->getLocale();
                $targetSlug = $alternativePost->{"slug_{$currentLocale}"};

                if ($targetSlug && $targetSlug !== $this->slug) {
                    return redirect()->route('blog.show', $targetSlug);
                }
            }

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
