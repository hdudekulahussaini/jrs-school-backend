<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $table = 'gallery_albums';

    protected $fillable = [
        'slug',
        'badge',
        'title',
        'highlight_text',
        'description',
        'media_type',
        'cover_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'cover_full_url',
    ];

    /**
     * Relationship: An album has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'gallery_album_id')->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Relationship: Active items only.
     */
    public function activeItems(): HasMany
    {
        return $this->items()->where('is_active', true);
    }

    /**
     * Get the full URL for cover image.
     */
    public function getCoverFullUrlAttribute(): ?string
    {
        if (empty($this->cover_image)) {
            // Fallback to first item's image if available
            $firstItem = $this->items()->first();
            return $firstItem ? $firstItem->image_full_url : null;
        }

        if (Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }

        return url(ltrim($this->cover_image, '/'));
    }

    /**
     * Boot model to automatically generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->title) . '-' . Str::random(4);
            }
        });
    }

    /**
     * Validation rules for store/update.
     */
    public static function validationRules(int $id = null): array
    {
        return [
            'title' => 'nullable|string|max:190',
            'slug' => 'nullable|string|max:190|unique:gallery_albums,slug,' . $id,
            'badge' => 'nullable|string|max:190',
            'highlight_text' => 'nullable|string|max:190',
            'description' => 'nullable|string',
            'media_type' => 'nullable|string|in:image,video',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'gallery_photos' => 'nullable|array',
            'gallery_photos.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'removed_item_ids' => 'nullable|array',
            'removed_item_ids.*' => 'integer',
        ];
    }
}
