<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalSocietyMember extends Model
{
    use HasFactory;

    protected $table = 'educational_society_members';

    protected $fillable = [
        'name',
        'designation',
        'address',
        'phone',
        'image_path',
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
}
