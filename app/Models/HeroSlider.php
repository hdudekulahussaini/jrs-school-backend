<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $table = 'hero_sliders';

    protected $fillable = [
        'primary_button_text',
        'secondary_button_text',
        'secondary_button_url',
        'background_images',
        'experience_badge_image',
        'image_path',
    ];

    protected $casts = [
        'background_images' => 'array',
    ];

    protected $appends = [
        'slides',
    ];

    /**
     * Slides accessor: transforms the hero content into slide items,
     * maintaining the CTA buttons across each background photograph.
     *
     * @return array<array<string, mixed>>
     */
    public function getSlidesAttribute(): array
    {
        $rawImages = $this->background_images;

        if (!is_array($rawImages) || empty($rawImages)) {
            $rawImages = !empty($this->image_path) ? [$this->image_path] : [];
        }

        $slides = [];

        foreach ($rawImages as $index => $rawPath) {
            if (empty($rawPath)) {
                continue;
            }
            $slides[] = [
                'id' => $this->id,
                'slide_index' => $index + 1,
                'primary_button_text' => $this->primary_button_text,
                'secondary_button_text' => $this->secondary_button_text,
                'secondary_button_url' => $this->secondary_button_url,
                'experience_badge_image' => $this->experience_badge_image,
                'image_path' => $rawPath,
                'sort_order' => $index + 1,
            ];
        }

        // If no background images configured yet, return single slide
        if (empty($slides)) {
            $slides[] = [
                'id' => $this->id,
                'slide_index' => 1,
                'primary_button_text' => $this->primary_button_text,
                'secondary_button_text' => $this->secondary_button_text,
                'secondary_button_url' => $this->secondary_button_url,
                'experience_badge_image' => $this->experience_badge_image,
                'image_path' => null,
                'sort_order' => 1,
            ];
        }

        return $slides;
    }

    /**
     * Centralized validation rules for supported hero slider fields.
     */
    public static function validationRules($id = null): array
    {
        return [
            'primary_button_text' => 'nullable|string|max:100',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:500',
            'experience_badge_image' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'background_images' => 'nullable|array',
            'background_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|string',
            'image_url' => 'nullable|string|max:1000',
        ];
    }
}
