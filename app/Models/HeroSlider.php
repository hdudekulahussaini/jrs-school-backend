<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $table = 'hero_sliders';

    protected $fillable = [
        'badge_title',
        'title',
        'highlight_text',
        'description',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'image_path',
        'contact_phone',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Compute full URL for the hero slider background image.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return url($this->image_path);
    }

    /**
     * Centralized validation rules for hero slider.
     */
    public static function validationRules($id = null): array
    {
        return [
            'badge_title' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'highlight_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'primary_button_text' => 'nullable|string|max:100',
            'primary_button_url' => 'nullable|string|max:500',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // up to 5MB
            'image_url' => 'nullable|string|max:1000',
            'contact_phone' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
