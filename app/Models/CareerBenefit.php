<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerBenefit extends Model
{
    use HasFactory;

    protected $table = 'career_benefits';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'badge',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Standard icon options available for Work Culture & Benefits cards.
     */
    public static function availableIcons(): array
    {
        return [
            'users' => 'Users / Collaborative Community',
            'graduation-cap' => 'Graduation Cap / Continuous Growth',
            'lightbulb' => 'Lightbulb / Innovative Teaching',
            'star' => 'Star / Make A Difference',
            'heart' => 'Heart / Wellness & Care',
            'trophy' => 'Trophy / Merit & Recognition',
            'sparkles' => 'Sparkles / Inspiration',
            'shield-check' => 'Shield / Security & Stability',
        ];
    }

    /**
     * Centralized validation rules.
     */
    public static function validationRules($id = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'badge' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
