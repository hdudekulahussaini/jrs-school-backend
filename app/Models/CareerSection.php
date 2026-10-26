<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSection extends Model
{
    use HasFactory;

    protected $table = 'career_sections';

    protected $fillable = [
        'badge',
        'title',
        'highlight_1',
        'highlight_2',
        'description',
        'image_path',
        'apply_email',
        'apply_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Compute full URL for image
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return asset('images/careers/teaching-at-jrs.png');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset(ltrim($this->image_path, '/'));
    }

    /**
     * Validation rules
     */
    public static function validationRules(): array
    {
        return [
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'highlight_1' => 'nullable|string|max:100',
            'highlight_2' => 'nullable|string|max:100',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'apply_email' => 'nullable|email|max:150',
            'apply_phone' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ];
    }
}
