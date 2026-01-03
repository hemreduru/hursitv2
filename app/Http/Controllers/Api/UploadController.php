<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            ]);

            if ($request->file('file')->isValid()) {
                $path = $request->file('file')->store('uploads', 'public');
                $url = Storage::url($path);

                return response()->json([
                    'message' => 'File uploaded successfully',
                    'path' => $path,
                    'url' => asset($url), // Full URL
                ], 201);
            }

            return response()->json(['message' => 'Invalid file upload'], 400);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }
}
