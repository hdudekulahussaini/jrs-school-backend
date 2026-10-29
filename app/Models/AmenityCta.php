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
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'image_path',
        'bg_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Absolute URL accessor for the CTA background/artwork
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return asset('images/amenities/cta-banner.png');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset(ltrim($this->image_path, '/'));
    }

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
            'primary_button_text' => 'nullable|string|max:100',
            'primary_button_url' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'bg_color' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ];
    }
}
