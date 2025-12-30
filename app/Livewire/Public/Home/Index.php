<?php

namespace App\Livewire\Public\Home;

use App\Services\HomeService;
use Livewire\Component;

class Index extends Component
{
    public function render(HomeService $homeService)
    {
        $data = $homeService->getHomeData(app()->getLocale());

        return view('livewire.public.home.index', $data)
            ->layout('layouts.app', [
                'title' => ($data['profile']->name ?? 'Hurşit Emre Duru') . ' - ' . ($data['profile']->title ?? 'Full-Stack Engineer'),
                'meta_description' => $data['profile']->bio ?? 'Senior Full-Stack Engineer specializing in scalable web applications.',
            ]);
    }
}
