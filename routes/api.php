<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/posts', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::post('/posts/automated', [\App\Http\Controllers\Api\AutomatedPostController::class, 'store']);
    Route::post('/upload', [\App\Http\Controllers\Api\UploadController::class, 'store']);
    Route::get('/automation/taxonomy', [\App\Http\Controllers\Api\AutomationController::class, 'taxonomy']);
    Route::get('/automation/dedupe-context', [\App\Http\Controllers\Api\AutomationController::class, 'dedupeContext']);
});
