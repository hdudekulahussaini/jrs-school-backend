<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChairmanMessage extends Model
{
    use HasFactory;

    protected $table = 'chairman_messages';

    protected $fillable = [
        // Section 1: Chairman's Address & Profile
        'section_badge',
        'title',
        'profile_badge',
        'name',
        'sub_title',
        'quote',
        'image_path',
        'paragraph',
        'signoff_note',
        'signoff_name',
        'signoff_sub',

        // Section 2: Strategic Commitment Banner
        'commitment_badge',
        'commitment_title',
        'commitment_description',

        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_full_url',
        'paragraphs',
    ];

    /**
     * Compute full URL for the chairman's portrait photo.
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
     * Return non-empty paragraphs as an indexed list.
     */
    public function getParagraphsAttribute(): array
    {
        if (empty($this->paragraph)) {
            return [];
        }

        // Split by double newline or single newline if formatted in blocks
        $parts = preg_split('/\r\n\r\n|\n\n/', $this->paragraph);
        return array_values(array_filter(array_map('trim', $parts), fn ($p) => $p !== ''));
    }
}
