<?php

namespace Tests\Feature;

use App\Models\AcademicProgram;
use App\Models\BreadcrumbBanner;
use App\Models\Facility;
use App\Models\HeroSlider;
use App\Models\NewsTicker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Section 1: Public GET Endpoints
|--------------------------------------------------------------------------
*/

test('GET /api/top-bar returns valid JSON', function () {
    $response = $this->getJson('/api/top-bar');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'phone',
                'phones',
                'email',
                'affiliation',
                'school_prospectus',
                'is_active',
            ],
        ]);
});

test('GET /api/news-ticker and /api/news-tickers return active marquee tickers', function () {
    $this->getJson('/api/news-ticker')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/news-tickers')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/hero-slider, /api/hero-sliders, and /api/sliders return hero slides', function () {
    $this->getJson('/api/hero-slider')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/hero-sliders')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/sliders')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/facilities, /api/amenities, /api/amenities-page, and /api/amenities-cta', function () {
    $this->getJson('/api/facilities')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/amenities')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/amenities-page')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'page', 'data']);

    $this->getJson('/api/amenities-cta')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/academic-programs, /api/academics, and /api/academic-journeys', function () {
    $this->getJson('/api/academic-programs')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/academics')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/academic-journeys')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/about and /api/about-us return About JRS section', function () {
    $this->getJson('/api/about')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/about-us')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/vision-mission returns vision and mission cards', function () {
    $this->getJson('/api/vision-mission')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/beyond-classrooms, /api/beyond-classroom-page, and /api/beyond-classroom-cta', function () {
    $this->getJson('/api/beyond-classrooms')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/beyond-classroom-page')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'page', 'data']);

    $this->getJson('/api/beyond-classroom-cta')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/events and /api/latest-events return school events', function () {
    $this->getJson('/api/events')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/latest-events')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/features and /api/home-features return value cards', function () {
    $this->getJson('/api/features')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/home-features')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/stats and /api/home-stats return statistics', function () {
    $this->getJson('/api/stats')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/home-stats')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);
});

test('GET /api/careers-page, /api/careers/teaching, /api/careers/benefits, and /api/careers/openings', function () {
    $this->getJson('/api/careers-page')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'teaching_section', 'benefits_section']);

    $this->getJson('/api/careers/teaching')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/careers/benefits')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/careers/openings')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/campus-tour and /api/campus-life', function () {
    $this->getJson('/api/campus-tour')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);

    $this->getJson('/api/campus-life')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);
});

test('GET /api/why-choose returns features', function () {
    $this->getJson('/api/why-choose')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);
});

test('GET /api/pta-members and /api/pta', function () {
    $this->getJson('/api/pta-members')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);

    $this->getJson('/api/pta')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);
});

test('GET /api/gallery-page, /api/gallery-albums, and /api/gallery-items', function () {
    $this->getJson('/api/gallery-page')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/gallery-albums')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/gallery-items')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/media-page and /api/news-media', function () {
    $this->getJson('/api/media-page')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/news-media')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/educational-society and /api/school-management-committee', function () {
    $this->getJson('/api/educational-society')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);

    $this->getJson('/api/school-management-committee')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'section', 'data']);
});

test('GET /api/admission-banner, /api/chairman, and /api/principal', function () {
    $this->getJson('/api/admission-banner')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/chairman')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/principal')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/mandatory-disclosure', function () {
    $this->getJson('/api/mandatory-disclosure')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/admission-hero, /api/admission-process, /api/admission-criteria, /api/admission-faqs', function () {
    $this->getJson('/api/admission-hero')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/admission-process')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/admission-criteria')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/admission-faqs')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/admission-brochure and /api/brochure', function () {
    $this->getJson('/api/admission-brochure')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message']);

    $this->getJson('/api/brochure')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'message']);
});

test('GET /api/contact and /api/contact/grades', function () {
    $this->getJson('/api/contact')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/contact/grades')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/admission-enquiries/options', function () {
    $this->getJson('/api/admission-enquiries/options')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});

test('GET /api/breadcrumb-banners, /api/breadcrumb-banners/pages, and /api/breadcrumb-banners/page/{slug}', function () {
    $this->getJson('/api/breadcrumb-banners')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'count', 'data']);

    $this->getJson('/api/breadcrumb-banners/pages')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);

    $this->getJson('/api/breadcrumb-banners/page/about')
        ->assertStatus(200)
        ->assertJsonStructure(['success', 'data']);
});


/*
|--------------------------------------------------------------------------
| Section 2: Form Inquiries (POST Validation & Database Operations)
|--------------------------------------------------------------------------
*/

test('POST /api/contact/inquiry validation fails on missing required fields', function () {
    $response = $this->postJson('/api/contact/inquiry', []);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors']);
});

test('POST /api/contact/inquiry successfully creates an inquiry in database', function () {
    $payload = [
        'parent_name' => 'API Test Parent',
        'phone' => '+91 9876543210',
        'grade' => 'Grade 5',
        'email' => 'testparent@example.com',
        'message' => 'Automated API testing message for contact inquiry.',
    ];

    $response = $this->postJson('/api/contact/inquiry', $payload);
    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
        ]);

    $this->assertDatabaseHas('contact_inquiries', [
        'parent_name' => 'API Test Parent',
        'email' => 'testparent@example.com',
    ]);
});

test('POST /api/admission-enquiries validation fails on missing required fields', function () {
    $response = $this->postJson('/api/admission-enquiries', []);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'errors']);
});

test('POST /api/admission-enquiries successfully submits an admission enquiry', function () {
    $payload = [
        'academic_year' => '2026-2027',
        'branch' => 'JRS INTERNATIONAL SCHOOL',
        'admission_type' => 'DAY SCHOLAR',
        'grade' => 'Grade 1',
        'parent_mobile' => '9876543210',
        'student_dob' => '2020-05-15',
    ];

    $response = $this->postJson('/api/admission-enquiries', $payload);
    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
        ]);

    $this->assertDatabaseHas('admission_enquiries', [
        'parent_mobile' => '9876543210',
        'grade' => 'Grade 1',
    ]);
});


/*
|--------------------------------------------------------------------------
| Section 3: Verified Disabled Mutation Routes & Resource Fetch Endpoints
|--------------------------------------------------------------------------
*/

test('Mutation API routes (POST/PUT/PATCH/DELETE) are removed or restricted', function () {
    // Attempting to post/put/delete on former CRUD endpoints should fail with 404 or 405
    $this->postJson('/api/news-tickers', ['title' => 'test'])->assertStatus(405);
    $this->postJson('/api/sliders', ['title' => 'test'])->assertStatus(405);
    $this->deleteJson('/api/sliders/1')->assertStatus(405);
    $this->postJson('/api/admin/facilities', ['title' => 'test'])->assertStatus(404);
    $this->deleteJson('/api/admin/programs/1')->assertStatus(404);
});

test('GET resource by ID or slug endpoints function properly', function () {
    $existingTicker = NewsTicker::first();
    if ($existingTicker) {
        $this->getJson("/api/news-tickers/{$existingTicker->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $existingTicker->id);
    }

    $existingSlider = HeroSlider::first();
    if ($existingSlider) {
        $this->getJson("/api/sliders/{$existingSlider->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $existingSlider->id);
    }

    $existingFacility = Facility::first();
    if ($existingFacility) {
        $this->getJson("/api/facilities/{$existingFacility->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $existingFacility->id);
    }

    $existingBanner = BreadcrumbBanner::first();
    if ($existingBanner) {
        $this->getJson("/api/breadcrumb-banners/{$existingBanner->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $existingBanner->id);

        $this->getJson("/api/breadcrumb-banners/{$existingBanner->page_slug}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $existingBanner->id);
    }
});

/*
|--------------------------------------------------------------------------
| Section 7: Swagger Documentation & OpenAPI Spec Endpoints
|--------------------------------------------------------------------------
*/

test('GET /swagger returns Swagger UI documentation page', function () {
    $response = $this->get('/swagger');
    $response->assertStatus(200)
        ->assertSee('swagger-ui')
        ->assertSee('Swagger API Docs')
        ->assertSee('spec: spec', false);
});


