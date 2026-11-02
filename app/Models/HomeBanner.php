<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class HomeBanner extends Model
{
    use HasFactory;

    protected $table = 'home_banners';

    protected $fillable = [
        'image_path',
    ];

    protected $appends = [
        'image_full_url',
    ];

    /**
     * Compute full URL for the home banner image.
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
     * Ensure the table exists in database.
     */
    public static function ensureTableExists(): void
    {
        if (!Schema::hasTable('home_banners')) {
            Schema::create('home_banners', function (Blueprint $table) {
                $table->id();
                $table->string('image_path')->nullable()->comment('Uploaded home banner image path');
                $table->timestamps();
            });
        }
    }
}
