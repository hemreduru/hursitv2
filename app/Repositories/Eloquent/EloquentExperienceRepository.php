<?php

namespace App\Repositories\Eloquent;

use App\Models\Experience;
use App\Repositories\Interfaces\ExperienceRepositoryInterface;

class EloquentExperienceRepository extends BaseRepository implements ExperienceRepositoryInterface
{
    public function __construct(Experience $model)
    {
        parent::__construct($model);
    }
}
