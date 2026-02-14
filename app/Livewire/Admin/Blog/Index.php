<?php

namespace App\Livewire\Admin\Blog;

use App\Services\PostService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function render(PostService $postService)
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->status,
        ];

        $posts = $postService->getAllForAdmin(10, $filters);

        return view('livewire.admin.blog.index', [
            'posts' => $posts
        ])->layout('layouts.admin');
    }

    public function delete(int $id, PostService $postService): void
    {
        if ($postService->delete($id)) {
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => __('messages.item_deleted')
            ]);
        }
    }
}
