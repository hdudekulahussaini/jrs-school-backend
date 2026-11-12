<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionPopup extends Model
{
    protected $fillable = ['image_path'];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Compute full URL for the popup image.
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
