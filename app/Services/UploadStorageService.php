<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadStorageService
{
    /**
     * @return array{disk: string, path: string, url: string}
     */
    public function storeImage(UploadedFile $file, string $directory = 'uploads'): array
    {
        $disk = $this->resolveUploadsDisk();
        $path = $file->store($directory, $disk);
        $url = Storage::disk($disk)->url($path);

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            $url = asset($url);
        }

        return [
            'disk' => $disk,
            'path' => $path,
            'url' => $url,
        ];
    }

    protected function resolveUploadsDisk(): string
    {
        $disk = (string) config('filesystems.uploads_disk', 'public');
        $configuredDisks = config('filesystems.disks', []);

        if (! is_array($configuredDisks) || ! array_key_exists($disk, $configuredDisks)) {
            Log::warning('upload.storage.invalid_disk_fallback', ['disk' => $disk]);

            return 'public';
        }

        return $disk;
    }
}
