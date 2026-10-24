<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusLife extends Model
{
    use HasFactory;

    protected $table = 'campus_lives';

    protected $fillable = [
        'title',
        'subtitle',
        'icon',
        'image_path',
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
     * Compute full URL for the image.
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
}
