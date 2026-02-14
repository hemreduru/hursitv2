<?php

namespace App\Services;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;
    protected HtmlSanitizer $htmlSanitizer;

    public function __construct(ProjectRepositoryInterface $projectRepository, HtmlSanitizer $htmlSanitizer)
    {
        $this->projectRepository = $projectRepository;
        $this->htmlSanitizer = $htmlSanitizer;
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

    public function findAny(string $slug): ?Model
    {
        return $this->projectRepository->findByAnyLocalizedSlug($slug);
    }

    public function paginate(int $perPage = 15, array $filters = [])
    {
        /** @var Builder $query */
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

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $data = $this->sanitizeLocalizedContent($data);
            $project = $this->projectRepository->create($data);
            DB::commit();

            Log::info('project.create.success', [
                'project_id' => $project->id,
                'is_featured' => $project->is_featured,
            ]);

            return $project;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('project.create.failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'title_en' => $data['title_en'] ?? null,
                'title_tr' => $data['title_tr'] ?? null,
            ]);

            throw $exception;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            DB::beginTransaction();
            $data = $this->sanitizeLocalizedContent($data);
            $updated = $this->projectRepository->update($id, $data);
            DB::commit();

            Log::info('project.update.success', [
                'project_id' => $id,
                'updated' => $updated,
            ]);

            return $updated;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('project.update.failed', [
                'project_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();
            $deleted = $this->projectRepository->delete($id);
            DB::commit();

            Log::info('project.delete.success', [
                'project_id' => $id,
                'deleted' => $deleted,
            ]);

            return $deleted;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('project.delete.failed', [
                'project_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    protected function sanitizeLocalizedContent(array $data): array
    {
        foreach (['content_en', 'content_tr'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $this->htmlSanitizer->sanitizeProject($data[$field]);
            }
        }

        return $data;
    }
}
