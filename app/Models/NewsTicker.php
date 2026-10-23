<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTicker extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link_url',
        'is_highlighted',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_highlighted' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
