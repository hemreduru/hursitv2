<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Throwable;
use Livewire\Component;
use App\Livewire\Forms\PostForm;

class Edit extends Component
{
    public PostForm $form;

    public function mount($id = null)
    {
        if ($id) {
            $post = Post::findOrFail($id);
            $this->form->setPost($post);
        } else {
            $this->form->published_at = now()->format('Y-m-d\TH:i');
        }
    }

    public function updated($name, $value)
    {
        if ($name === 'form.title_tr') {
            $this->form->slug_tr = \Illuminate\Support\Str::slug($value);
        }
        if ($name === 'form.title_en') {
            $this->form->slug_en = \Illuminate\Support\Str::slug($value);
        }
    }

    public function save(PostService $postService)
    {
        $data = $this->form->prepareData();

        try {
            if ($this->form->post) {
                $postService->update($this->form->post->id, $data);
                session()->flash('message', __('messages.admin_post_updated'));
            } else {
                $postService->create($data);
                session()->flash('message', __('messages.admin_post_created'));
                return redirect()->route('admin.blog.index');
            }
        } catch (Throwable $exception) {
            report($exception);
            session()->flash('error', __('messages.admin_operation_failed'));
        }
    }

    public function render()
    {
        return view('livewire.admin.blog.edit', [
            'tagsEn' => Tag::where('locale', 'en')->get(),
            'tagsTr' => Tag::where('locale', 'tr')->get(),
        ])->layout('layouts.admin');
    }
}
