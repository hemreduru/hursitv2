<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'tech_stack',
        'urls',
        'is_featured',
        'locale',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'urls' => 'array',
        'is_featured' => 'boolean',
    ];
}
