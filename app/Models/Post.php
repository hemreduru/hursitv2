<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    public const READING_WORDS_PER_MINUTE = 200;

    protected $fillable = [
        'title_en', 'title_tr',
        'slug_en', 'slug_tr',
        'short_description_en', 'short_description_tr',
        'content_en', 'content_tr',
        'status',
        'published_at',
        'reading_time',
        'thumbnail',
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

    public function getReadingTimeAttribute($value): int
    {
        $content = $this->getContentAttribute();

        if (! is_string($content)) {
            return $this->fallbackReadingTime($value);
        }

        $plainText = trim((string) preg_replace(
            '/\s+/u',
            ' ',
            strip_tags(html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
        ));

        if ($plainText === '') {
            return $this->fallbackReadingTime($value);
        }

        preg_match_all('/[\p{L}\p{N}\']+/u', $plainText, $matches);
        $wordCount = count($matches[0] ?? []);

        if ($wordCount === 0) {
            return $this->fallbackReadingTime($value);
        }

        return max(1, (int) ceil($wordCount / self::READING_WORDS_PER_MINUTE));
    }

    protected function fallbackReadingTime($value): int
    {
        $storedReadingTime = (int) $value;

        return $storedReadingTime > 0 ? $storedReadingTime : 1;
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
