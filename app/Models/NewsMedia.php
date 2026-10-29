<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsMedia extends Model
{
    use HasFactory;

    protected $table = 'news_media';

    protected $fillable = [
        'title',
        'english_title',
        'newspaper_name',
        'location',
        'published_date',
        'description',
        'image_path',
        'article_url',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_full_url',
        'formatted_date',
    ];

    /**
     * Get the full URL for the newspaper clipping image.
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
     * Get uppercase formatted date e.g. "15 FEB 2023".
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->published_date ? strtoupper($this->published_date->format('d M Y')) : '';
    }

    /**
     * Validation rules for store/update.
     */
    public static function validationRules(int $id = null): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'english_title' => 'nullable|string|max:255',
            'newspaper_name' => 'nullable|string|max:190',
            'location' => 'nullable|string|max:100',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'media_photos' => 'nullable|array',
            'media_photos.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'removed_item_ids' => 'nullable|array',
            'removed_item_ids.*' => 'integer',
            'article_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }
}
