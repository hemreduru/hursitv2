<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en', 'title_tr',
        'slug_en', 'slug_tr',
        'short_description_en', 'short_description_tr',
        'content_en', 'content_tr',
        'status',
        'published_at',
        'reading_time',
    ];

    protected $casts = [
        'published_at' => 'datetime',
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
