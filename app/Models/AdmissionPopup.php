<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionPopup extends Model
{
    use HasFactory;

    protected $table = 'admission_popups';

    protected $fillable = [
        'is_active',
        'image_path',
        'badge_text',
        'cbse_affiliation_text',
        'school_name',
        'school_location',
        'academic_year_badge',
        'title_prefix',
        'academic_year_highlight',
        'description',
        'features',
        'phone_number',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'features'  => 'array',
    ];

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
