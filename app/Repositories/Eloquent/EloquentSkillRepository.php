<?php

namespace App\Repositories\Eloquent;

use App\Models\Skill;
use App\Repositories\Interfaces\SkillRepositoryInterface;

class EloquentSkillRepository extends BaseRepository implements SkillRepositoryInterface
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }

    public function getAllGroupedByCategory(): \Illuminate\Support\Collection
    {
        return $this->model->all()->groupBy('category');
    }
}
