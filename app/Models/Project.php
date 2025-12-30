<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en', 'title_tr',
        'slug_en', 'slug_tr',
        'short_description_en', 'short_description_tr',
        'content_en', 'content_tr',
        'tech_stack',
        'urls',
        'is_featured',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'urls' => 'array',
        'is_featured' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()] ?? $this->attributes['title_en'] ?? null;
    }

    public function getSlugAttribute()
    {
        return $this->attributes['slug_' . app()->getLocale()] ?? $this->attributes['slug_en'] ?? null;
    }

    public function getShortDescriptionAttribute()
    {
        return $this->attributes['short_description_' . app()->getLocale()] ?? $this->attributes['short_description_en'] ?? null;
    }

    public function getContentAttribute()
    {
        return $this->attributes['content_' . app()->getLocale()] ?? $this->attributes['content_en'] ?? null;
    }
}
