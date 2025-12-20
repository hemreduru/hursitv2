<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'bio',
        'contact_email',
        'social_links',
        'locale',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
