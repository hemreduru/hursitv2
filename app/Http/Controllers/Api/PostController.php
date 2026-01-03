<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

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

            // Create post
            $post = $this->postService->create($validated);

            return response()->json([
                'message' => 'Post created successfully',
                'id' => $post->id,
                'link' => route('blog.show', $post->slug_en),
                'links' => [
                    'en' => route('blog.show', $post->slug_en),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}
