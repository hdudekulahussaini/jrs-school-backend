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
        'experience_badge_image',
        'background_images',
        'image_path',
    ];

    protected $casts = [
        'background_images' => 'array',
    ];

    protected $appends = [
        'image_full_url',
        'background_images_full_urls',
        'experience_badge_image_url',
        'slides',
    ];

    /**
     * Compute full URL for primary hero slider background image.
     */
    public function getImageFullUrlAttribute(): ?string
    {
        $primary = $this->image_path;

        if (empty($primary) && !empty($this->background_images) && is_array($this->background_images)) {
            $primary = $this->background_images[0] ?? null;
        }

        if (empty($primary)) {
            return null;
        }

        if (str_starts_with($primary, 'http://') || str_starts_with($primary, 'https://')) {
            return $primary;
        }

        return url($primary);
    }

    /**
     * Compute full URLs for all background photos in the slider.
     *
     * @return array<string>
     */
    public function getBackgroundImagesFullUrlsAttribute(): array
    {
        $images = $this->background_images;
        if (!is_array($images) || empty($images)) {
            if (!empty($this->image_path)) {
                $images = [$this->image_path];
            } else {
                return [];
            }
        }

        $urls = [];
        foreach ($images as $img) {
            if (empty($img)) {
                continue;
            }
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                $urls[] = $img;
            } else {
                $urls[] = url($img);
            }
        }

        return $urls;
    }

    /**
     * Compute full URL for Experience Badge Image (e.g. 38 Years Experience).
     */
    public function getExperienceBadgeImageUrlAttribute(): ?string
    {
        $badge = $this->experience_badge_image;

        if (empty($badge)) {
            return url('images/experience-badge-38.svg');
        }

        if (str_starts_with($badge, 'http://') || str_starts_with($badge, 'https://')) {
            return $badge;
        }

        return url($badge);
    }

    /**
     * Slides accessor: transforms the hero content into slide items,
     * maintaining the same CTA buttons and experience badge across each background photograph.
     *
     * @return array<array<string, mixed>>
     */
    public function getSlidesAttribute(): array
    {
        $urls = $this->background_images_full_urls;
        $rawImages = $this->background_images;

        if (!is_array($rawImages) || empty($rawImages)) {
            $rawImages = !empty($this->image_path) ? [$this->image_path] : [];
        }

        if (empty($urls) && !empty($this->image_full_url)) {
            $urls = [$this->image_full_url];
        }

        $badgeUrl = $this->experience_badge_image_url;
        $slides = [];

        foreach ($urls as $index => $fullUrl) {
            $rawPath = $rawImages[$index] ?? $this->image_path ?? $fullUrl;
            $slides[] = [
                'id' => $this->id,
                'slide_index' => $index + 1,
                'primary_button_text' => $this->primary_button_text,
                'secondary_button_text' => $this->secondary_button_text,
                'secondary_button_url' => $this->secondary_button_url,
                'experience_badge_image' => $this->experience_badge_image,
                'experience_badge_image_url' => $badgeUrl,
                'image_path' => $rawPath,
                'image_full_url' => $fullUrl,
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
                'experience_badge_image_url' => $badgeUrl,
                'image_path' => null,
                'image_full_url' => null,
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
            'experience_badge_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
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
