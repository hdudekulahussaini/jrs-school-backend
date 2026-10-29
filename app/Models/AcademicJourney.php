<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AcademicJourney extends Model
{
    use HasFactory;

    protected $table = 'academic_journeys';

    protected $fillable = [
        'title',
        'age_group',
        'lead_text',
        'description',
        'highlights',
        'icon',
        'icon_svg',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'highlights' => 'array',
    ];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Return the fully qualified asset URL for the journey image.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        return url(ltrim($this->image_path, '/'));
    }

    /**
     * Validation rules for store / update.
     */
    public static function validationRules(int $id = null): array
    {
        return [
            'title' => 'required|string|max:190',
            'age_group' => 'nullable|string|max:100',
            'lead_text' => 'nullable|string',
            'description' => 'required|string',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:190',
            'icon_svg' => 'nullable|string',
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096' : 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'image_path' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
