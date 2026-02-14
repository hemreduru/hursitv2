<?php

namespace App\Services;

use App\Exceptions\DuplicatePostException;
use App\Exceptions\InvalidTaxonomySelectionException;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Support\HtmlSanitizer;
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

    protected HtmlSanitizer $htmlSanitizer;

    protected ContentTaxonomyService $contentTaxonomyService;

    public function __construct(
        PostRepositoryInterface $postRepository,
        HtmlSanitizer $htmlSanitizer,
        ContentTaxonomyService $contentTaxonomyService
    ) {
        $this->postRepository = $postRepository;
        $this->htmlSanitizer = $htmlSanitizer;
        $this->contentTaxonomyService = $contentTaxonomyService;
    }

    public function getPublished(string $locale): Collection
    {
        return $this->postRepository->getPublished($locale);
    }

    public function getLatestPublishedExcept(int $excludePostId, int $limit = 6): Collection
    {
        return $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->where('id', '!=', $excludePostId)
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function getPreviousPublished(Post $post): ?Model
    {
        if (! $post->published_at) {
            return null;
        }

        /** @var Builder $query */
        $query = $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function (Builder $builder) use ($post) {
                $builder->where('published_at', '>', $post->published_at)
                    ->orWhere(function (Builder $sameTimeBuilder) use ($post) {
                        $sameTimeBuilder->where('published_at', $post->published_at)
                            ->where('id', '>', $post->id);
                    });
            })
            ->orderBy('published_at')
            ->orderBy('id');

        return $query->first();
    }

    public function getNextPublished(Post $post): ?Model
    {
        if (! $post->published_at) {
            return null;
        }

        /** @var Builder $query */
        $query = $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function (Builder $builder) use ($post) {
                $builder->where('published_at', '<', $post->published_at)
                    ->orWhere(function (Builder $sameTimeBuilder) use ($post) {
                        $sameTimeBuilder->where('published_at', $post->published_at)
                            ->where('id', '<', $post->id);
                    });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        return $query->first();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->postRepository->paginate($perPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $data = $this->sanitizeLocalizedContent($data);
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

    public function createAutomated(array $data): Model
    {
        DB::beginTransaction();

        try {
            $data = $this->sanitizeLocalizedContent($data);
            $primaryCategorySlug = (string) ($data['primary_category_slug'] ?? '');
            $secondaryTagSlugs = array_values($data['secondary_tag_slugs'] ?? []);

            unset($data['primary_category_slug'], $data['secondary_tag_slugs']);

            $normalizedSourceUrl = $this->normalizeSourceUrl((string) $data['source_url']);
            $sourceHash = hash('sha256', $normalizedSourceUrl);
            $data['source_url'] = $normalizedSourceUrl;
            $data['source_hash'] = $sourceHash;

            $this->assertNoAutomatedDuplicate(
                $sourceHash,
                (string) ($data['title_en'] ?? ''),
                (string) ($data['title_tr'] ?? '')
            );

            $post = $this->postRepository->create($data);
            $this->syncCanonicalTags($post, $primaryCategorySlug, $secondaryTagSlugs);

            DB::commit();

            Log::info('api.post.automated.created', [
                'post_id' => $post->id,
                'source_hash' => $sourceHash,
                'primary_category_slug' => $primaryCategorySlug,
                'secondary_tags_count' => count($secondaryTagSlugs),
                'status' => $post->status,
            ]);

            return $post;
        } catch (DuplicatePostException $exception) {
            DB::rollBack();

            Log::warning('api.post.automated.duplicate_blocked', [
                'reason' => $exception->reason(),
                'matched_post_id' => $exception->matchedPost()?->id,
                'score' => $exception->score(),
                'source_url' => $data['source_url'] ?? null,
                'title_en' => $data['title_en'] ?? null,
                'title_tr' => $data['title_tr'] ?? null,
            ]);

            throw $exception;
        } catch (InvalidTaxonomySelectionException $exception) {
            DB::rollBack();

            Log::warning('api.post.automated.taxonomy_invalid', [
                'error' => $exception->getMessage(),
                'source_url' => $data['source_url'] ?? null,
                'primary_category_slug' => $primaryCategorySlug ?? null,
                'secondary_tag_slugs' => $secondaryTagSlugs ?? [],
            ]);

            throw $exception;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('api.post.automated.store.failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'source_url' => $data['source_url'] ?? null,
                'title_en' => $data['title_en'] ?? null,
                'title_tr' => $data['title_tr'] ?? null,
            ]);

            throw $exception;
        }
    }

    /**
     * @return array<int, array{id: int, title_en: string, title_tr: string, short_description_en: string, short_description_tr: string, source_url: ?string, published_at: ?string, link: string}>
     */
    public function getAutomationDedupeContext(int $days, int $limit): array
    {
        $days = max(1, $days);
        $limit = max(1, min(200, $limit));

        return $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subDays($days))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get([
                'id',
                'title_en',
                'title_tr',
                'short_description_en',
                'short_description_tr',
                'source_url',
                'published_at',
                'slug_en',
            ])
            ->map(static function (Post $post): array {
                return [
                    'id' => $post->id,
                    'title_en' => (string) $post->title_en,
                    'title_tr' => (string) $post->title_tr,
                    'short_description_en' => (string) $post->short_description_en,
                    'short_description_tr' => (string) $post->short_description_tr,
                    'source_url' => $post->source_url,
                    'published_at' => $post->published_at?->toIso8601String(),
                    'link' => route('blog.show', $post->slug_en),
                ];
            })
            ->values()
            ->all();
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $data = $this->sanitizeLocalizedContent($data);
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

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $term = $filters['search'];
                $q->where('title_en', 'like', '%'.$term.'%')
                    ->orWhere('title_tr', 'like', '%'.$term.'%')
                    ->orWhere('content_en', 'like', '%'.$term.'%')
                    ->orWhere('content_tr', 'like', '%'.$term.'%');
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getPublishedWithFilters(string $locale, int $perPage = 15, array $filters = [])
    {
        /** @var Builder $query */
        $query = $this->postRepository->getModel()::query()
            ->where('status', 'published');

        if (! empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('title_en', 'like', '%'.$term.'%')
                    ->orWhere('title_tr', 'like', '%'.$term.'%')
                    ->orWhere('content_en', 'like', '%'.$term.'%')
                    ->orWhere('content_tr', 'like', '%'.$term.'%');
            });
        }

        if (! empty($filters['tag'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->where('name', $filters['tag']);
            });
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }

    protected function assertNoAutomatedDuplicate(string $sourceHash, string $titleEn, string $titleTr): void
    {
        $sourceMatch = $this->findPublishedBySourceHash($sourceHash);

        if ($sourceMatch) {
            throw new DuplicatePostException('source_url already published', $sourceMatch, 100.0);
        }

        $titleMatch = $this->findPublishedBySimilarTitle($titleEn, $titleTr);

        if ($titleMatch) {
            throw new DuplicatePostException(
                sprintf('title similarity >= %.2f%%', $titleMatch['score']),
                $titleMatch['post'],
                $titleMatch['score']
            );
        }
    }

    protected function findPublishedBySourceHash(string $sourceHash): ?Post
    {
        return $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->where('source_hash', $sourceHash)
            ->orderByDesc('published_at')
            ->first();
    }

    /**
     * @return array{post: Post, score: float}|null
     */
    protected function findPublishedBySimilarTitle(string $titleEn, string $titleTr): ?array
    {
        $days = (int) config('content_taxonomy.dedupe.days_default', 180);
        $limit = (int) config('content_taxonomy.dedupe.limit_default', 100);
        $threshold = (float) config('content_taxonomy.dedupe.title_similarity_threshold', 80.0);

        $candidates = $this->postRepository->getModel()::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subDays($days))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get(['id', 'title_en', 'title_tr', 'slug_en', 'published_at']);

        $bestMatch = null;
        $bestScore = 0.0;

        foreach ($candidates as $candidate) {
            $scoreEn = $this->titleSimilarityPercent($titleEn, (string) $candidate->title_en);
            $scoreTr = $this->titleSimilarityPercent($titleTr, (string) $candidate->title_tr);
            $score = max($scoreEn, $scoreTr);

            if ($score >= $threshold && $score > $bestScore) {
                $bestMatch = $candidate;
                $bestScore = $score;
            }
        }

        if (! $bestMatch) {
            return null;
        }

        return [
            'post' => $bestMatch,
            'score' => round($bestScore, 2),
        ];
    }

    protected function titleSimilarityPercent(string $left, string $right): float
    {
        $normalizedLeft = $this->normalizeComparableText($left);
        $normalizedRight = $this->normalizeComparableText($right);

        if ($normalizedLeft === '' || $normalizedRight === '') {
            return 0.0;
        }

        similar_text($normalizedLeft, $normalizedRight, $percent);

        return (float) $percent;
    }

    protected function normalizeComparableText(string $text): string
    {
        $stripped = strip_tags($text);
        $collapsed = preg_replace('/\s+/u', ' ', $stripped);

        return mb_strtolower(trim((string) $collapsed));
    }

    protected function normalizeSourceUrl(string $url): string
    {
        $trimmed = trim($url);

        $withoutFragment = strtok($trimmed, '#');
        if ($withoutFragment === false) {
            return $trimmed;
        }

        $parts = parse_url($withoutFragment);
        if (! is_array($parts)) {
            return $withoutFragment;
        }

        $scheme = isset($parts['scheme']) ? mb_strtolower((string) $parts['scheme']) : 'https';
        $host = isset($parts['host']) ? mb_strtolower((string) $parts['host']) : '';
        $path = $parts['path'] ?? '';
        $query = $parts['query'] ?? '';

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        $normalizedQuery = '';
        if ($query !== '') {
            parse_str($query, $queryParams);
            if (is_array($queryParams)) {
                foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'] as $trackingKey) {
                    unset($queryParams[$trackingKey]);
                }
                ksort($queryParams);
                $normalizedQuery = http_build_query($queryParams);
            }
        }

        $normalized = $scheme.'://'.$host.$path;

        if ($normalizedQuery !== '') {
            $normalized .= '?'.$normalizedQuery;
        }

        return $normalized;
    }

    protected function syncCanonicalTags(Model $post, string $primaryCategorySlug, array $secondaryTagSlugs): void
    {
        $definitions = $this->contentTaxonomyService->resolveCanonicalSelection($primaryCategorySlug, $secondaryTagSlugs);
        $tagIds = [];

        foreach ($definitions as $definition) {
            foreach (['en' => 'name_en', 'tr' => 'name_tr'] as $locale => $nameField) {
                $tag = Tag::firstOrCreate(
                    [
                        'slug' => $definition['slug'],
                        'locale' => $locale,
                    ],
                    [
                        'name' => $definition[$nameField],
                    ]
                );

                if ($tag->name !== $definition[$nameField]) {
                    $tag->update(['name' => $definition[$nameField]]);
                }

                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync(array_values(array_unique($tagIds)));
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

    protected function sanitizeLocalizedContent(array $data): array
    {
        foreach (['content_en', 'content_tr'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $this->htmlSanitizer->sanitizePost($data[$field]);
            }
        }

        return $data;
    }
}
