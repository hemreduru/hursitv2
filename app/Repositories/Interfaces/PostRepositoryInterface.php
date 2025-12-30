<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function getPublished(string $locale): Collection;
    public function findBySlug(string $slug, string $locale);

    public function findByAnyLocalizedSlug(string $slug);
}
