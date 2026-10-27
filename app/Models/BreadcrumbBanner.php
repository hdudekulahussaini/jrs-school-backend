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
        'subtitle',
        'description',
        'background_image',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
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
                'subtitle' => 'Learning Today. Leading Tomorrow.',
                'description' => 'At JRS International School, we are dedicated to providing a transformative educational experience that nurtures academic excellence, character development, and global readiness.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'Watch Campus Video',
                'secondary_button_url' => '#campus-video',
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
                'subtitle' => 'Visionary Leadership & Academic Excellence',
                'description' => 'Guiding JRS International School toward global benchmarks in quality education, character building, and innovation.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'About JRS',
                'secondary_button_url' => '/about',
                'stats' => [],
            ],
            [
                'name' => 'Principal',
                'slug' => 'principal',
                'nav_path' => '/principal',
                'breadcrumb_title' => 'Principal',
                'title' => 'Principal’s',
                'highlighted_title' => 'Message',
                'subtitle' => 'Empowering Minds and Enriching Lives.',
                'description' => 'At JRS International School, we believe that every child has unique potential, and meaningful education is about discovering, nurturing and transforming that potential into purpose.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'About JRS',
                'secondary_button_url' => '/about',
                'stats' => [],
            ],
            [
                'name' => 'Educational Society',
                'slug' => 'educational-society',
                'nav_path' => '/educational-society',
                'breadcrumb_title' => 'Educational Society',
                'title' => 'Educational Society —',
                'highlighted_title' => 'Managing Committee',
                'subtitle' => 'Distinguished Governing Body & Leadership',
                'description' => 'Distinguished governing body steering the vision, academic excellence, statutory compliance, and strategic growth of JRS International School.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'School Management Committee',
                'slug' => 'school-management-committee',
                'nav_path' => '/school-management-committee',
                'breadcrumb_title' => 'School Management Committee',
                'title' => 'School Management',
                'highlighted_title' => 'Committee',
                'subtitle' => 'Governing Body & Institutional Leadership',
                'description' => 'The School Management Committee (SMC) ensures academic integrity, statutory compliance, student welfare, and continuous institutional growth at JRS International School.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'Mandatory Disclosure',
                'slug' => 'mandatory-disclosure',
                'nav_path' => '/mandatory-disclosure',
                'breadcrumb_title' => 'Mandatory Disclosure',
                'title' => 'CBSE Statutory',
                'highlighted_title' => 'Disclosures',
                'subtitle' => 'Transparency, Compliance, and Official Certifications',
                'description' => 'Official regulatory compliance documents, fee structures, academic calendars, and safety certificates.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'Academics',
                'slug' => 'academics',
                'nav_path' => '/academics',
                'breadcrumb_title' => 'Academics',
                'title' => 'Excellence in',
                'highlighted_title' => 'Academics',
                'subtitle' => 'CBSE Curriculum with Global Learning Standards',
                'description' => 'Comprehensive academic pathways from Early Years to Senior Secondary, emphasizing inquiry-based learning.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'Admission Guide',
                'secondary_button_url' => '/admissions',
                'stats' => [],
            ],
            [
                'name' => 'Admissions Overview',
                'slug' => 'admissions',
                'nav_path' => '/admissions',
                'breadcrumb_title' => 'Admissions',
                'title' => "Begin Your Child's",
                'highlighted_title' => 'Journey at JRS',
                'subtitle' => 'Admissions Open for Academic Year 2026-2027',
                'description' => 'Simple, transparent admission process with personalized campus visits and counseling support.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'Download Brochure',
                'secondary_button_url' => 'https://jrsinternationalschooluppal.com/wp-content/uploads/2022/01/Brochure-2020-JRS.pdf',
                'stats' => [],
            ],
            [
                'name' => 'Beyond Classroom',
                'slug' => 'beyond',
                'nav_path' => '/beyond',
                'breadcrumb_title' => 'Beyond Classroom',
                'title' => 'Co-Curricular &',
                'highlighted_title' => 'Beyond Classroom',
                'subtitle' => 'Unleashing Talents in Sports, Arts, and Innovation',
                'description' => 'Discover vibrant clubs, performing arts, robotics, martial arts, and leadership programs.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'Amenities',
                'slug' => 'facilities',
                'nav_path' => '/facilities',
                'breadcrumb_title' => 'Amenities',
                'title' => 'World-Class',
                'highlighted_title' => 'Campus Amenities',
                'subtitle' => 'State-of-the-Art Infrastructure Designed for Holistic Growth',
                'description' => 'Explore our modern classrooms, advanced STEM laboratories, digital library, and Olympic-grade sports amenities.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'Contact Us',
                'secondary_button_url' => '/contact',
                'stats' => [],
            ],
            [
                'name' => 'Gallery',
                'slug' => 'gallery',
                'nav_path' => '/gallery',
                'breadcrumb_title' => 'Gallery',
                'title' => 'Moments &',
                'highlighted_title' => 'Memories',
                'subtitle' => 'Capturing Life and Achievements at JRS International School',
                'description' => 'Explore our photo and video albums documenting celebrations, campus life, and sports triumphs.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'Media',
                'slug' => 'media',
                'nav_path' => '/media',
                'breadcrumb_title' => 'Media',
                'title' => 'Press & Media',
                'highlighted_title' => 'Coverage',
                'subtitle' => 'Recognitions and Headlines in the News',
                'description' => 'Read about JRS International School\'s achievements, academic accolades, and community outreach.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => '360 Degree Campus',
                'slug' => '360-degree-campus',
                'nav_path' => '/gallery/360-degree-campus',
                'breadcrumb_title' => '360 Degree Campus',
                'title' => 'Virtual Tour &',
                'highlighted_title' => '360° Campus',
                'subtitle' => 'Experience Our World-Class Campus Interactively',
                'description' => 'Take an immersive 360-degree virtual tour of our classrooms, labs, playgrounds, and amenities.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
                'stats' => [],
            ],
            [
                'name' => 'Contact',
                'slug' => 'contact',
                'nav_path' => '/contact',
                'breadcrumb_title' => 'Contact Us',
                'title' => 'Connect With',
                'highlighted_title' => 'JRS International',
                'subtitle' => "We'd Love to Hear From You",
                'description' => 'Get in touch with our admissions office, schedule a campus visit, or submit your inquiries online.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => 'Campus Location',
                'secondary_button_url' => '#map',
                'stats' => [],
            ],
            [
                'name' => 'Careers',
                'slug' => 'careers',
                'nav_path' => '/careers',
                'breadcrumb_title' => 'Careers',
                'title' => 'Join Our',
                'highlighted_title' => 'Teaching Community',
                'subtitle' => 'Inspire the Next Generation of Thinkers and Leaders',
                'description' => 'Explore rewarding teaching and administrative career opportunities with professional growth.',
                'primary_button_text' => null,
                'primary_button_url' => null,
                'secondary_button_text' => null,
                'secondary_button_url' => null,
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
