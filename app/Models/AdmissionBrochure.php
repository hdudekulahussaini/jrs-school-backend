<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdmissionBrochure extends Model
{
    use HasFactory;

    protected $table = 'admission_brochures';

    protected $fillable = [
        'title',
        'pdf_path',
        'brochure_link',
        'file_size',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'pdf_full_url',
        'download_url',
        'has_file',
    ];

    /**
     * Compute full URL for the uploaded PDF.
     */
    public function getPdfFullUrlAttribute(): ?string
    {
        if (empty($this->pdf_path)) {
            return null;
        }

        if (Str::startsWith($this->pdf_path, ['http://', 'https://'])) {
            return $this->pdf_path;
        }

        return url(ltrim($this->pdf_path, '/'));
    }

    /**
     * Get active download URL (uploaded PDF or external link).
     */
    public function getDownloadUrlAttribute(): ?string
    {
        if (!empty($this->pdf_path)) {
            return $this->pdf_full_url;
        }

        return $this->brochure_link;
    }

    /**
     * Check if a PDF file is uploaded.
     */
    public function getHasFileAttribute(): bool
    {
        return !empty($this->pdf_path);
    }
}
