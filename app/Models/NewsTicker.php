<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTicker extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'badge_text',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Validation rules for news ticker creation/updating.
     */
    public static function validationRules($id = null): array
    {
        return [
            'title' => 'required|string|max:500',
            'badge_text' => 'nullable|string|max:50',
            'link_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
