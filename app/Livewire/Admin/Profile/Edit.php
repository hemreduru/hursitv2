<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Profile;
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

    public function save()
    {
        $data = $this->form->prepareData();

        try {
            if ($this->form->profile) {
                $this->form->profile->update($data);
                session()->flash('message', 'Profile updated successfully.');
            } else {
                Profile::create($data);
                session()->flash('message', 'Profile created successfully.');
                return redirect()->route('admin.profile.index');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Operation failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.profile.edit')->layout('layouts.admin');
    }
}
