<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Profile;
use App\Services\ProfileService;
use Throwable;
use Livewire\Component;
use App\Livewire\Forms\ProfileForm;

class Edit extends Component
{
    public ProfileForm $form;

    public function mount($id = null)
    {
        if ($id) {
            $profile = Profile::findOrFail($id);
            $this->form->setProfile($profile);
        }
    }

    public function save(ProfileService $profileService)
    {
        $data = $this->form->prepareData();

        try {
            if ($this->form->profile) {
                $profileService->update($this->form->profile, $data);
                session()->flash('message', __('messages.admin_profile_updated'));
            } else {
                $profileService->create($data);
                session()->flash('message', __('messages.admin_profile_created'));
                return redirect()->route('admin.profile.index');
            }
        } catch (Throwable $exception) {
            report($exception);
            session()->flash('error', __('messages.admin_operation_failed'));
        }
    }

    public function render()
    {
        return view('livewire.admin.profile.edit')->layout('layouts.admin');
    }
}
