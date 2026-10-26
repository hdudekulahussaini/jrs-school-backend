<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalMessage extends Model
{
    use HasFactory;

    protected $table = 'principal_messages';

    protected $fillable = [
        'desk_title',
        'desk_subtitle',
        'official_address_badge',
        'academic_year',
        'section_badge',
        'title',
        'salutation',
        'card_badge',
        'profile_badge',
        'name',
        'sub_title',
        'image_path',
        'paragraph',
        'quote',
        'signoff_note',
        'signoff_signature',
        'signoff_name',
        'signoff_sub',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Compute full URL for portrait photo
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

    /**
     * Return paragraphs as array by splitting on newlines
     */
    public function getParagraphsAttribute(): array
    {
        if (empty($this->paragraph)) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n\r\n|\n\n|\r\n|\n/', $this->paragraph)),
            fn($p) => strlen($p) > 0
        ));
    }
}
