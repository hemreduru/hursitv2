<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\ProfileRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentProfileRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SkillRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentSkillRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ExperienceRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentExperienceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\ProjectRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentProjectRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PostRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentPostRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\TagRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentTagRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
