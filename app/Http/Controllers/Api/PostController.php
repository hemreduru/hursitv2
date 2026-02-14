<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(StorePostRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['published_at'] = ($validated['status'] ?? 'draft') === 'published' ? now() : null;

            $post = $this->postService->create($validated);

            return response()->json([
                'message' => __('messages.api_post_created'),
                'id' => $post->id,
                'link' => route('blog.show', $post->slug_en),
                'links' => [
                    'en' => route('blog.show', $post->slug_en),
                ]
            ], 201);
        } catch (Throwable $exception) {
            Log::error('api.post.store.failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'user_id' => $request->user()?->id,
            ]);

            return response()->json([
                'message' => __('messages.api_server_error'),
            ], 500);
        }
    }
}
