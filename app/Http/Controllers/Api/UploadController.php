<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(StoreUploadRequest $request)
    {
        if (! $request->file('file')->isValid()) {
            return response()->json(['message' => 'Invalid file upload'], 400);
        }

        $path = $request->file('file')->store('uploads', 'public');
        $url = Storage::url($path);

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => asset($url),
        ], 201);
    }
}
