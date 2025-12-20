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
        return $this->model->where('locale', $locale)
            ->where('is_featured', true)
            ->get();
    }

    public function findBySlug(string $slug, string $locale)
    {
        return $this->model->where('slug', $slug)
            ->where('locale', $locale)
            ->first();
    }
}
