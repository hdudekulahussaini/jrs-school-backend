<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $table = 'contact_settings';

    protected $fillable = [
        'address',
        'phone',
        'email',
        'map_link',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'linkedin_url',
        'social_links',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'social_links' => 'array',
    ];
}
