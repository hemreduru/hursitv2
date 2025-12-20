<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Livewire\Component;

class Edit extends Component
{
    public $post;
    public $title;
    public $slug;
    public $short_description;
    public $content;
    public $status = 'draft';
    public $published_at;
    public $reading_time;
    public $locale = 'en';
    public $selectedTags = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->post = Post::findOrFail($id);
            $this->title = $this->post->title;
            $this->slug = $this->post->slug;
            $this->short_description = $this->post->short_description;
            $this->content = $this->post->content;
            $this->status = $this->post->status;
            $this->published_at = $this->post->published_at ? $this->post->published_at->format('Y-m-d\TH:i') : null;
            $this->reading_time = $this->post->reading_time;
            $this->locale = $this->post->locale;
            $this->selectedTags = $this->post->tags->pluck('id')->toArray();
        } else {
            $this->published_at = now()->format('Y-m-d\TH:i');
        }
    }

    public function save(PostService $postService)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . ($this->post->id ?? 'NULL'),
            'short_description' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'locale' => 'required|in:en,tr',
            'reading_time' => 'required|integer',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'reading_time' => $this->reading_time,
            'locale' => $this->locale,
            'tags' => $this->selectedTags,
        ];

        if ($this->post) {
            $postService->update($this->post->id, $data);
            session()->flash('message', 'Post updated successfully.');
        } else {
            $postService->create($data);
            session()->flash('message', 'Post created successfully.');
            return redirect()->route('admin.blog.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.edit', [
            'tags' => Tag::all()
        ])->layout('layouts.admin');
    }
}
