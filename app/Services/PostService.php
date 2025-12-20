<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $post = $this->postRepository->create($data);

        if (!empty($tags)) {
            $post->tags()->sync($tags);
        }

        return $post;
    }

    public function update(int $id, array $data)
    {
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $updated = $this->postRepository->update($id, $data);

        if ($updated && !empty($tags)) {
            $post = $this->postRepository->find($id);
            $post->tags()->sync($tags);
        }

        return $updated;
    }

    public function getBySlug(string $slug, string $locale): ?Model
    {
        return $this->postRepository->findBySlug($slug, $locale);
    }

    public function getAllForAdmin()
    {
        return $this->postRepository->paginate(20);
    }
}
