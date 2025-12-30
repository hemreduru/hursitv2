<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Profile;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $profiles = Profile::all();

        return view('livewire.admin.profile.index', [
            'profiles' => $profiles
        ])->layout('layouts.admin');
    }
}
