<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TagService
{
    public function create(array $data): Tag
    {
        try {
            DB::beginTransaction();
            $tag = Tag::query()->create($data);
            DB::commit();

            Log::info('tag.create.success', [
                'tag_id' => $tag->id,
                'locale' => $tag->locale,
            ]);

            return $tag;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('tag.create.failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function update(Tag $tag, array $data): bool
    {
        try {
            DB::beginTransaction();
            $updated = $tag->update($data);
            DB::commit();

            Log::info('tag.update.success', [
                'tag_id' => $tag->id,
                'updated' => $updated,
            ]);

            return $updated;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('tag.update.failed', [
                'tag_id' => $tag->id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();
            $deleted = Tag::query()->whereKey($id)->delete() > 0;
            DB::commit();

            Log::info('tag.delete.success', [
                'tag_id' => $id,
                'deleted' => $deleted,
            ]);

            return $deleted;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('tag.delete.failed', [
                'tag_id' => $id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }
}
