<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PostService
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPublished(string $locale): Collection
    {
        return $this->postRepository->getPublished($locale);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->postRepository->paginate($perPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $post = $this->postRepository->create($data);
            $this->syncTags($post, $tags);

            DB::commit();

            Log::info('post.create.success', [
                'post_id' => $post->id,
                'status' => $post->status,
                'tags_count' => count($tags),
            ]);

            return $post;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('post.create.failed', [
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
        DB::beginTransaction();

        try {
            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $updated = $this->postRepository->update($id, $data);

            if ($updated) {
                $post = $this->postRepository->find($id);
                if ($post) {
                    $this->syncTags($post, $tags);
                }
            }

            DB::commit();

            Log::info('post.update.success', [
                'post_id' => $id,
                'updated' => $updated,
                'tags_count' => count($tags),
            ]);

            return $updated;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('post.update.failed', [
                'post_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        DB::beginTransaction();

        try {
            $post = $this->postRepository->find($id);

            if (! $post) {
                DB::commit();
                Log::warning('post.delete.not_found', ['post_id' => $id]);
                return false;
            }

            $post->tags()->detach();
            $deleted = $this->postRepository->delete($id);

            DB::commit();

            Log::info('post.delete.success', [
                'post_id' => $id,
                'deleted' => $deleted,
            ]);

            return $deleted;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('post.delete.failed', [
                'post_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function getBySlug(string $slug, string $locale): ?Model
    {
        return $this->postRepository->findBySlug($slug, $locale);
    }

    public function findAny(string $slug): ?Model
    {
        return $this->postRepository->findByAnyLocalizedSlug($slug);
    }

    public function getAllForAdmin($perPage = 20, array $filters = [])
    {
        /** @var Builder $query */
        $query = $this->postRepository->getModel()::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where('title_en', 'like', '%' . $term . '%')
                  ->orWhere('title_tr', 'like', '%' . $term . '%')
                  ->orWhere('content_en', 'like', '%' . $term . '%')
                  ->orWhere('content_tr', 'like', '%' . $term . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }
    public function getPublishedWithFilters(string $locale, int $perPage = 15, array $filters = [])
    {
        /** @var Builder $query */
        $query = $this->postRepository->getModel()::query()
            ->where('status', 'published');

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('title_en', 'like', '%' . $term . '%')
                  ->orWhere('title_tr', 'like', '%' . $term . '%')
                  ->orWhere('content_en', 'like', '%' . $term . '%')
                  ->orWhere('content_tr', 'like', '%' . $term . '%');
            });
        }

        if (!empty($filters['tag'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->where('name', $filters['tag']);
            });
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }

    protected function syncTags(Model $post, array $tags)
    {
        if (empty($tags)) {
            return;
        }

        $tagIds = [];
        foreach ($tags as $tag) {
            if (is_numeric($tag)) {
                $tagIds[] = $tag;
            } else {
                $tagModel = \App\Models\Tag::firstOrCreate(
                    ['name' => $tag],
                    [
                        'slug' => Str::slug($tag),
                        'locale' => app()->getLocale(),
                    ]
                );
                $tagIds[] = $tagModel->id;
            }
        }

        $post->tags()->sync($tagIds);
    }
}
