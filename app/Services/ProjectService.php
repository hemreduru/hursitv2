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
                $q->where('title_tr', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('title_en', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_description_tr', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_description_en', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('content_tr', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('content_en', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('tech_stack', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $query->where('is_featured', $filters['featured']);
        }

        if (!empty($filters['locale'])) {
            $query->where('locale', $filters['locale']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        try {
            return $this->projectRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception(__('messages.error_create_project') . ' ' . $e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            return $this->projectRepository->update($id, $data);
        } catch (\Exception $e) {
            throw new \Exception(__('messages.error_update_project') . ' ' . $e->getMessage());
        }
    }
}
