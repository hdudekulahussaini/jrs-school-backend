<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseFeature extends Model
{
    use HasFactory;

    protected $table = 'why_choose_features';

    protected $fillable = [
        'type',
        'title',
        'description',
        'icon',
        'icon_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
