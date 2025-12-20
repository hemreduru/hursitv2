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
        return $this->model->where('locale', $locale)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public function findBySlug(string $slug, string $locale)
    {
        return $this->model->where('slug', $slug)
            ->where('locale', $locale)
            ->where('status', 'published')
            ->first();
    }
}
