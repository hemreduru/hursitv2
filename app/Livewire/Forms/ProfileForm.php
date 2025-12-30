<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\Profile;

class ProfileForm extends Form
{
    public ?Profile $profile = null;

    // Shared Fields
    public $name = '';
    public $contact_email = '';

    // English Fields
    public $title_en = '';
    public $title_tr = '';
    public $bio_en = '';
    public $bio_tr = '';

    // Social Links
    public $github_url = '';
    public $linkedin_url = '';
    public $twitter_url = '';

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
        $this->name = $profile->name;
        $this->contact_email = $profile->contact_email;

        $this->title_en = $profile->title_en;
        $this->title_tr = $profile->title_tr;
        $this->bio_en = $profile->bio_en;
        $this->bio_tr = $profile->bio_tr;

        $socials = $profile->social_links ?? [];
        $this->github_url = $socials['github'] ?? '';
        $this->linkedin_url = $socials['linkedin'] ?? '';
        $this->twitter_url = $socials['twitter'] ?? '';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'title_en' => 'required|string|max:255',
            'title_tr' => 'required|string|max:255',
            'bio_en' => 'required|string',
            'bio_tr' => 'required|string',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ];
    }

    public function prepareData()
    {
        $this->validate();

        $socialLinks = [];
        if ($this->github_url) $socialLinks['github'] = $this->github_url;
        if ($this->linkedin_url) $socialLinks['linkedin'] = $this->linkedin_url;
        if ($this->twitter_url) $socialLinks['twitter'] = $this->twitter_url;

        return [
            'name' => $this->name,
            'contact_email' => $this->contact_email,
            'title_en' => $this->title_en,
            'title_tr' => $this->title_tr,
            'bio_en' => $this->bio_en,
            'bio_tr' => $this->bio_tr,
            'social_links' => $socialLinks,
        ];
    }
}
