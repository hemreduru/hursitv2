<?php

namespace App\Services;

use App\Repositories\Interfaces\ExperienceRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;

class HomeService
{
    public function __construct(
        protected ProfileRepositoryInterface $profileRepository,
        protected SkillRepositoryInterface $skillRepository,
        protected ExperienceRepositoryInterface $experienceRepository,
        protected ProjectRepositoryInterface $projectRepository,
        protected PostRepositoryInterface $postRepository
    ) {}

    public function getHomeData(string $locale): array
    {
        return [
            'profile' => $this->profileRepository->getByLocale($locale)->first(),
            'skills' => $this->skillRepository->getAllGroupedByCategory(),
            'experiences' => $this->experienceRepository->getByLocale($locale),
            'featuredProjects' => $this->projectRepository->getFeatured($locale),
            'latestPosts' => $this->postRepository->getPublished($locale)->take(3),
        ];
    }
}
