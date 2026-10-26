<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeStat extends Model
{
    use HasFactory;

    protected $table = 'home_stats';

    protected $fillable = [
        'title',
        'value',
        'icon',
        'color',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Centralized validation rules for Home Stats.
     */
    public static function validationRules($id = null): array
    {
        return [
            'value' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }
}
