<?php

namespace App\Livewire\Admin\Profile;

use App\Models\Profile;
use Livewire\Component;

class Edit extends Component
{
    public $profile;
    public $name;
    public $title;
    public $bio;
    public $contact_email;
    public $locale = 'en';

    // Social Links
    public $github_url;
    public $linkedin_url;
    public $twitter_url;

    public function mount($id = null)
    {
        if ($id) {
            $this->profile = Profile::findOrFail($id);
            $this->name = $this->profile->name;
            $this->title = $this->profile->title;
            $this->bio = $this->profile->bio;
            $this->contact_email = $this->profile->contact_email;
            $this->locale = $this->profile->locale;

            $socials = $this->profile->social_links ?? [];
            $this->github_url = $socials['github'] ?? '';
            $this->linkedin_url = $socials['linkedin'] ?? '';
            $this->twitter_url = $socials['twitter'] ?? '';
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'locale' => 'required|in:en,tr',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ]);

        $socialLinks = [];
        if ($this->github_url) $socialLinks['github'] = $this->github_url;
        if ($this->linkedin_url) $socialLinks['linkedin'] = $this->linkedin_url;
        if ($this->twitter_url) $socialLinks['twitter'] = $this->twitter_url;

        $data = [
            'name' => $this->name,
            'title' => $this->title,
            'bio' => $this->bio,
            'contact_email' => $this->contact_email,
            'locale' => $this->locale,
            'social_links' => $socialLinks,
        ];

        if ($this->profile) {
            $this->profile->update($data);
            session()->flash('message', 'Profile updated successfully.');
        } else {
            Profile::create($data);
            session()->flash('message', 'Profile created successfully.');
            return redirect()->route('admin.profile.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.profile.edit')->layout('layouts.admin');
    }
}
