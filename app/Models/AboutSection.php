<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagline',
        'title',
        'title_highlight',
        'description_p1',
        'description_p2',
        'button_text',
        'button_link',
        'image_1_url',
        'image_2_url',
        'video_title',
        'video_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Validation rules for About Section.
     */
    public static function validationRules(): array
    {
        return [
            'tagline' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'title_highlight' => 'nullable|string|max:255',
            'description_p1' => 'required|string',
            'description_p2' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image_1_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image_2_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ];
    }
}
