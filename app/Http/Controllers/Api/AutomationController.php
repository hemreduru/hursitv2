<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AutomationDedupeContextRequest;
use App\Services\ContentTaxonomyService;
use App\Services\PostService;

class AutomationController extends Controller
{
    public function taxonomy(ContentTaxonomyService $taxonomyService)
    {
        return response()->json([
            'categories' => $taxonomyService->categories(),
            'optional_tags' => $taxonomyService->optionalTags(),
        ]);
    }

    public function dedupeContext(AutomationDedupeContextRequest $request, PostService $postService)
    {
        $validated = $request->validated();
        $days = (int) $validated['days'];
        $limit = (int) $validated['limit'];

        return response()->json([
            'items' => $postService->getAutomationDedupeContext($days, $limit),
            'meta' => [
                'days' => $days,
                'limit' => $limit,
            ],
        ]);
    }
}
