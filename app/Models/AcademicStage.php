<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_number',
        'title',
        'subtitle',
        'description',
        'key_features',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'key_features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
