<?php

namespace App\Repositories\Eloquent;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    public function __construct(Profile $model)
    {
        parent::__construct($model);
    }

    public function getByLocale(string $locale): Collection
    {
        return $this->model->all();
    }

    public function getPrimary(): ?Profile
    {
        return $this->model->query()->orderBy('id')->first();
    }
}
