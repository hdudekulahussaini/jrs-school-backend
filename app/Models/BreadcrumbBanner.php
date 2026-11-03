<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BreadcrumbBanner extends Model
{
    use HasFactory;

    protected $table = 'breadcrumb_banners';

    protected $fillable = [
        'page_name',
        'page_slug',
        'breadcrumb_title',
        'title',
        'highlighted_title',
        'background_image',
    ];

    protected $casts = [];

    protected $appends = [
        'background_image_url',
    ];

    /**
     * Relationship to dynamic stats cards (e.g. Year of Establishment, CBSE Affiliation No.)
     */
    public function stats(): HasMany
    {
        return $this->hasMany(BreadcrumbBannerStat::class, 'breadcrumb_banner_id');
    }

    /**
     * Scope for active banners (passes through since is_active was removed).
     */
    public function scopeActive($query)
    {
        return $query;
    }

    /**
     * Check if this banner represents the About JRS page (which exclusively showcases impact stats cards).
     */
    public function isAboutBanner(): bool
    {
        return str_contains(strtolower($this->page_slug ?? ''), 'about')
            || str_contains(strtolower($this->page_name ?? ''), 'about');
    }

    /**
     * Full URL accessor for the background image.
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (empty($this->background_image)) {
            // Default school campus banner artwork fallback
            return asset('images/amenities/cta-banner.png');
        }

        if (str_starts_with($this->background_image, 'http://') || str_starts_with($this->background_image, 'https://')) {
            return $this->background_image;
        }

        return url(ltrim($this->background_image, '/'));
    }

    /**
     * Complete list of predefined website header pages with standard titles, breadcrumbs, and defaults.
     * Contains only pages from the website header navigation bar.
     */
    public static function supportedPages(): array
    {
        return [
            [
                'name' => 'About JRS',
                'slug' => 'about',
                'nav_path' => '/about',
                'breadcrumb_title' => 'About JRS',
                'title' => 'About',
                'highlighted_title' => 'JRS',
                'stats' => [
                    ['icon' => 'graduation-cap', 'value' => '2021', 'label' => 'Year of Establishment'],
                    ['icon' => 'shield-check', 'value' => '3630478', 'label' => 'CBSE Affiliation No.'],
                    ['icon' => 'users', 'value' => '1:25', 'label' => 'Teacher-Student Ratio'],
                    ['icon' => 'sparkles', 'value' => '5', 'label' => 'Core Pillars'],
                ],
            ],
            [
                'name' => 'Chairman of JRS',
                'slug' => 'chairman',
                'nav_path' => '/chairman',
                'breadcrumb_title' => 'Chairman of JRS',
                'title' => 'Chairman’s',
                'highlighted_title' => 'Message',
                'stats' => [],
            ],
            [
                'name' => 'Principal',
                'slug' => 'principal',
                'nav_path' => '/principal',
                'breadcrumb_title' => 'Principal',
                'title' => 'Principal’s',
                'highlighted_title' => 'Message',
                'stats' => [],
            ],
            [
                'name' => 'Educational Society',
                'slug' => 'educational-society',
                'nav_path' => '/educational-society',
                'breadcrumb_title' => 'Educational Society',
                'title' => 'Educational Society —',
                'highlighted_title' => 'Managing Committee',
                'stats' => [],
            ],
            [
                'name' => 'School Management Committee',
                'slug' => 'school-management-committee',
                'nav_path' => '/school-management-committee',
                'breadcrumb_title' => 'School Management Committee',
                'title' => 'School Management',
                'highlighted_title' => 'Committee',
                'stats' => [],
            ],
            [
                'name' => 'Mandatory Disclosure',
                'slug' => 'mandatory-disclosure',
                'nav_path' => '/mandatory-disclosure',
                'breadcrumb_title' => 'Mandatory Disclosure',
                'title' => 'CBSE Statutory',
                'highlighted_title' => 'Disclosures',
                'stats' => [],
            ],
            [
                'name' => 'Academics',
                'slug' => 'academics',
                'nav_path' => '/academics',
                'breadcrumb_title' => 'Academics',
                'title' => 'Excellence in',
                'highlighted_title' => 'Academics',
                'stats' => [],
            ],
            [
                'name' => 'Admissions Overview',
                'slug' => 'admissions',
                'nav_path' => '/admissions',
                'breadcrumb_title' => 'Admissions',
                'title' => "Begin Your Child's",
                'highlighted_title' => 'Journey at JRS',
                'stats' => [],
            ],
            [
                'name' => 'Beyond Classroom',
                'slug' => 'beyond',
                'nav_path' => '/beyond',
                'breadcrumb_title' => 'Beyond Classroom',
                'title' => 'Co-Curricular &',
                'highlighted_title' => 'Beyond Classroom',
                'stats' => [],
            ],
            [
                'name' => 'Amenities',
                'slug' => 'facilities',
                'nav_path' => '/facilities',
                'breadcrumb_title' => 'Amenities',
                'title' => 'World-Class',
                'highlighted_title' => 'Campus Amenities',
                'stats' => [],
            ],
            [
                'name' => 'Gallery',
                'slug' => 'gallery',
                'nav_path' => '/gallery',
                'breadcrumb_title' => 'Gallery',
                'title' => 'Moments &',
                'highlighted_title' => 'Memories',
                'stats' => [],
            ],
            [
                'name' => 'Media',
                'slug' => 'media',
                'nav_path' => '/media',
                'breadcrumb_title' => 'Media',
                'title' => 'Press & Media',
                'highlighted_title' => 'Coverage',
                'stats' => [],
            ],
            [
                'name' => '360 Degree Campus',
                'slug' => '360-degree-campus',
                'nav_path' => '/gallery/360-degree-campus',
                'breadcrumb_title' => '360 Degree Campus',
                'title' => 'Virtual Tour &',
                'highlighted_title' => '360° Campus',
                'stats' => [],
            ],
            [
                'name' => 'Videos',
                'slug' => 'videos',
                'nav_path' => '/gallery/videos',
                'breadcrumb_title' => 'Gallery > Create Life Skills',
                'title' => 'Create',
                'highlighted_title' => 'Life Skills',
                'stats' => [],
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'nav_path' => '/contact',
                'breadcrumb_title' => 'Contact Us',
                'title' => 'Connect With',
                'highlighted_title' => 'JRS International',
                'stats' => [],
            ],
            [
                'name' => 'Careers',
                'slug' => 'careers',
                'nav_path' => '/careers',
                'breadcrumb_title' => 'Careers',
                'title' => 'Join Our',
                'highlighted_title' => 'Teaching Community',
                'stats' => [],
            ],
        ];
    }

    /**
     * Find a banner by slug or known alias.
     */
    public static function findBySlugOrAlias(string $slug): ?self
    {
        $normalized = trim(ltrim($slug, '/'));
        
        $banner = self::with('stats')->where('page_slug', $normalized)->first();
        if ($banner) {
            return $banner;
        }

        $aliases = [
            'amenities' => 'facilities',
            'facilities' => 'amenities',
            'beyond-classroom' => 'beyond',
            'principals-message' => 'principal',
            'chairmans-message' => 'chairman',
            'news-media' => 'media',
            'gallery/360-degree-campus' => '360-degree-campus',
            '360-degree-campus' => 'gallery/360-degree-campus',
            'admissions-overview' => 'admissions',
            'gallery/videos' => 'videos',
            'gallery-videos' => 'videos',
            'video-gallery' => 'videos',
            'create-life-skills' => 'videos',
            'gallery/create-life-skills' => 'videos',
        ];

        if (isset($aliases[$normalized])) {
            $banner = self::with('stats')->where('page_slug', $aliases[$normalized])->first();
            if ($banner) {
                return $banner;
            }
        }

        return null;
    }
}
