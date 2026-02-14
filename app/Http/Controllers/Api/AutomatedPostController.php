<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DuplicatePostException;
use App\Exceptions\InvalidTaxonomySelectionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAutomatedPostRequest;
use App\Services\PostService;
use Illuminate\Support\Facades\Log;
use Throwable;

class AutomatedPostController extends Controller
{
    public function __construct(protected PostService $postService) {}

    public function store(StoreAutomatedPostRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['published_at'] = ($validated['status'] ?? 'draft') === 'published' ? now() : null;

            $post = $this->postService->createAutomated($validated);

            return response()->json([
                'message' => __('messages.api_post_created'),
                'id' => $post->id,
                'link' => route('blog.show', $post->slug_en),
                'links' => [
                    'en' => route('blog.show', $post->slug_en),
                ],
            ], 201);
        } catch (DuplicatePostException $exception) {
            $matchedPost = $exception->matchedPost();

            return response()->json([
                'message' => __('messages.api_duplicate_post'),
                'duplicate' => true,
                'reason' => $exception->reason(),
                'matched_post' => $matchedPost ? [
                    'id' => $matchedPost->id,
                    'link' => route('blog.show', $matchedPost->slug_en),
                ] : null,
            ], 409);
        } catch (InvalidTaxonomySelectionException $exception) {
            Log::warning('api.post.automated.taxonomy_invalid', [
                'error' => $exception->getMessage(),
                'user_id' => $request->user()?->id,
            ]);

            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('api.post.automated.store.failed', [
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
