<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileService
{
    public function create(array $data): Profile
    {
        try {
            DB::beginTransaction();
            $profile = Profile::query()->create($data);
            DB::commit();

            Log::info('profile.create.success', [
                'profile_id' => $profile->id,
                'email' => $profile->contact_email,
            ]);

            return $profile;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('profile.create.failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    public function update(Profile $profile, array $data): bool
    {
        try {
            DB::beginTransaction();
            $updated = $profile->update($data);
            DB::commit();

            Log::info('profile.update.success', [
                'profile_id' => $profile->id,
                'updated' => $updated,
            ]);

            return $updated;
        } catch (Throwable $exception) {
            DB::rollBack();

            Log::error('profile.update.failed', [
                'profile_id' => $profile->id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }
}
