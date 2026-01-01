<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getFeatured(string $locale): Collection
    {
        return $this->model
            ->where('is_featured', true)
            ->get();
    }

    public function findBySlug(string $slug, string $locale)
    {
        return $this->model->where("slug_{$locale}", $slug)
            ->first();
    }

    public function findByAnyLocalizedSlug(string $slug)
    {
        return $this->model
            ->where(function ($q) use ($slug) {
                $q->where('slug_en', $slug)
                  ->orWhere('slug_tr', $slug);
            })
            ->first();
    }

    public function getByLocale(string $locale): Collection
    {
        return $this->model->all();
    }
}
