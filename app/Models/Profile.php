<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title_en', 'title_tr',
        'bio_en', 'bio_tr',
        'contact_email',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()] ?? $this->attributes['title_en'] ?? null;
    }

    public function getBioAttribute()
    {
        return $this->attributes['bio_' . app()->getLocale()] ?? $this->attributes['bio_en'] ?? null;
    }
}
