<?php

namespace App\Livewire\Public\Blog;

use App\Services\PostService;
use Livewire\Component;

use App\Models\Tag;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $tag = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTag()
    {
        $this->resetPage();
    }

    public function setTag($tagName)
    {
        $this->tag = $tagName === $this->tag ? '' : $tagName;
    }

    public function render(PostService $postService)
    {
        $locale = app()->getLocale();
        $posts = $postService->getPublishedWithFilters(
            $locale,
            15,
            ['search' => $this->search, 'tag' => $this->tag]
        );

        $tags = Tag::query()
            ->where('locale', $locale)
            ->whereHas('posts')
            ->orderBy('name')
            ->get();

        return view('livewire.public.blog.index', [
            'posts' => $posts,
            'tags' => $tags
        ])->layout('layouts.app');
    }
}
