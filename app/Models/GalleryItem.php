<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    use HasFactory;

    protected $table = 'gallery_items';

    protected $fillable = [
        'gallery_album_id',
        'caption',
        'image_path',
        'video_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'gallery_album_id' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_full_url',
        'video_full_url',
    ];

    /**
     * Relationship: Belongs to a gallery album.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }

    /**
     * Return the fully qualified asset URL for the item image.
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
     * Return the fully qualified asset URL for the item video.
     */
    public function getVideoFullUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        if (Str::startsWith($this->video_url, ['http://', 'https://'])) {
            return $this->video_url;
        }

        return url(ltrim($this->video_url, '/'));
    }

    /**
     * Check if the video is an external link (YouTube, Vimeo, etc.).
     */
    public function getIsExternalVideoAttribute(): bool
    {
        if (empty($this->video_url)) {
            return false;
        }

        return Str::contains($this->video_url, ['youtube.com', 'youtu.be', 'vimeo.com', 'dailymotion.com']);
    }

    /**
     * Convert YouTube URL to embed URL.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return null;
    }

    /**
     * Validation rules for single item store/update.
     */
    public static function validationRules(int $id = null): array
    {
        return [
            'gallery_album_id' => 'required|exists:gallery_albums,id',
            'caption' => 'nullable|string|max:190',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'video_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ];
    }
}
