<?php

namespace App\Repositories\Interfaces;

interface SkillRepositoryInterface extends RepositoryInterface
{
    // Potentially get grouped by category?
    public function getAllGroupedByCategory(): \Illuminate\Support\Collection;
}
