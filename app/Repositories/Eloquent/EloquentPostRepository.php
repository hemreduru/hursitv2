<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentPostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getPublished(string $locale): Collection
    {
        return $this->model
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public function findBySlug(string $slug, string $locale)
    {
        return $this->model->where("slug_{$locale}", $slug)
            ->where('status', 'published')
            ->first();
    }

    public function findByAnyLocalizedSlug(string $slug)
    {
        return $this->model
            ->where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug_en', $slug)
                  ->orWhere('slug_tr', $slug);
            })
            ->first();
    }

    public function getByLocale(string $locale): Collection
    {
        return $this->getPublished($locale);
    }
}
