<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUploadRequest;
use App\Services\UploadStorageService;
use Illuminate\Support\Facades\Log;
use Throwable;

class UploadController extends Controller
{
    public function __construct(protected UploadStorageService $uploadStorageService) {}

    public function store(StoreUploadRequest $request)
    {
        try {
            if (! $request->file('file')->isValid()) {
                return response()->json(['message' => __('messages.api_invalid_upload')], 400);
            }

            $uploaded = $this->uploadStorageService->storeImage($request->file('file'));

            return response()->json([
                'message' => __('messages.api_upload_success'),
                'path' => $uploaded['path'],
                'url' => $uploaded['url'],
            ], 201);
        } catch (Throwable $exception) {
            Log::error('api.upload.store.failed', [
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
