<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\Post;

class PostForm extends Form
{
    public ?Post $post = null;

    // English Fields
    public $title_en = '';
    public $title_tr = '';
    public $slug_en = '';
    public $slug_tr = '';
    public $short_description_en = '';
    public $short_description_tr = '';
    public $content_en = '';
    public $content_tr = '';

    // Shared Fields
    public $status = 'draft';
    public $published_at = '';
    public $selectedTagsEn = [];
    public $selectedTagsTr = [];

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->title_en = $post->title_en;
        $this->title_tr = $post->title_tr;
        $this->slug_en = $post->slug_en;
        $this->slug_tr = $post->slug_tr;
        $this->short_description_en = $post->short_description_en;
        $this->short_description_tr = $post->short_description_tr;
        $this->content_en = $post->content_en;
        $this->content_tr = $post->content_tr;

        $this->status = $post->status;
        $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i');

        $this->selectedTagsEn = $post->tags->where('locale', 'en')->pluck('id')->toArray();
        $this->selectedTagsTr = $post->tags->where('locale', 'tr')->pluck('id')->toArray();
    }

    public function rules()
    {
        return [
            'title_en' => 'required|string|max:255',
            'title_tr' => 'required|string|max:255',
            'slug_en' => 'required|string|max:255|unique:posts,slug_en,' . ($this->post->id ?? 'NULL'),
            'slug_tr' => 'required|string|max:255|unique:posts,slug_tr,' . ($this->post->id ?? 'NULL'),
            'short_description_en' => 'required|string',
            'short_description_tr' => 'required|string',
            'content_en' => 'required|string',
            'content_tr' => 'required|string',

            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'selectedTagsEn' => 'array',
            'selectedTagsTr' => 'array',
        ];
    }

    public function prepareData()
    {
        $this->validate();

        return [
            'title_en' => $this->title_en,
            'title_tr' => $this->title_tr,
            'slug_en' => $this->slug_en,
            'slug_tr' => $this->slug_tr,
            'short_description_en' => $this->short_description_en,
            'short_description_tr' => $this->short_description_tr,
            'content_en' => $this->content_en,
            'content_tr' => $this->content_tr,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'tags' => array_merge($this->selectedTagsEn, $this->selectedTagsTr),
        ];
    }
}
