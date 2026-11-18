<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityCta extends Model
{
    use HasFactory;

    protected $table = 'amenity_ctas';

    protected $fillable = [
        'badge',
        'title',
        'highlight_text',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [];

    /**
     * Validation rules for store & update
     */
    public static function validationRules(): array
    {
        return [
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'highlight_text' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
