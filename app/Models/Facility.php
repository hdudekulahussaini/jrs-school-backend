<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    protected $fillable = [
        'title',
        'description',
        'overview_description',
        'highlights',
        'gallery_images',
        'image_path',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'highlights' => 'array',
        'gallery_images' => 'array',
    ];

    protected $appends = [];
}
