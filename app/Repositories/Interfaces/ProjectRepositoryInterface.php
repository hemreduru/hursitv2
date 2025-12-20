<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function getFeatured(string $locale): Collection;
    public function findBySlug(string $slug, string $locale);
}
