<?php

namespace App\Services;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getFeatured(string $locale): Collection
    {
        return $this->projectRepository->getFeatured($locale);
    }

    public function getAll(string $locale): Collection
    {
        return $this->projectRepository->getByLocale($locale);
    }

    public function getBySlug(string $slug, string $locale): ?Model
    {
        return $this->projectRepository->findBySlug($slug, $locale);
    }

    public function paginate(int $perPage = 15, array $filters = [])
    {
        $query = $this->projectRepository->getModel()::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('content', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('tech_stack', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $query->where('featured', $filters['featured']);
        }

        if (!empty($filters['locale'])) {
            $query->where('locale', $filters['locale']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->projectRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->projectRepository->update($id, $data);
    }
}
