<?php

use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\AcademicJourneyApiController;
use App\Http\Controllers\Api\AcademicProgramApiController;
use App\Http\Controllers\Api\BeyondClassroomApiController;
use App\Http\Controllers\Api\CareerApiController;
use App\Http\Controllers\Api\FacilityApiController;
use App\Http\Controllers\Api\HeroSliderApiController;
use App\Http\Controllers\Api\HomeFeatureApiController;
use App\Http\Controllers\Api\HomeStatApiController;
use App\Http\Controllers\Api\NewsTickerApiController;
use App\Http\Controllers\Api\SchoolEventApiController;
use App\Http\Controllers\Api\VisionMissionApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampusLifeApiController;
use App\Http\Controllers\Api\WhyChooseApiController;
use App\Http\Controllers\Api\PtaMemberApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\NewsMediaApiController;
use App\Http\Controllers\Api\TopBarApiController;

/*
|--------------------------------------------------------------------------
| API Routes for JRS International School (Read-Only GET Endpoints)
|--------------------------------------------------------------------------
|
| Public GET endpoints used by the React frontend (https://jrs-school.vercel.app/)
| to fetch active announcements, hero sliders, facilities, academic programs,
| about section, and vision & mission cards. All mutations are managed via
| the authenticated admin web dashboard.
|
*/

// Header Top Bar GET Endpoint (Global Phone, Email, CBSE Affiliation & Documents)
Route::get('/top-bar', [TopBarApiController::class, 'getTopBar']);

// News Ticker GET Endpoints
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);
Route::get('/news-tickers', [NewsTickerApiController::class, 'index']);
Route::get('/news-tickers/{id}', [NewsTickerApiController::class, 'show']);

// Hero Slider GET Endpoints
Route::get('/hero-slider', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/hero-sliders', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/sliders', [HeroSliderApiController::class, 'index']);
Route::get('/sliders/{id}', [HeroSliderApiController::class, 'show']);

// Campus Amenities / Facilities GET Endpoints (Read-Only GET for React site & Amenities page)
Route::get('/amenities-page', [FacilityApiController::class, 'getPageData']);
Route::get('/amenities-cta', [FacilityApiController::class, 'getCta']);
Route::get('/amenities/cta', [FacilityApiController::class, 'getCta']);
Route::get('/amenities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/amenities/{id}', [FacilityApiController::class, 'show']);
Route::get('/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/facilities/{id}', [FacilityApiController::class, 'show']);
Route::get('/campus/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/admin/facilities', [FacilityApiController::class, 'index']);
Route::get('/admin/facilities/{id}', [FacilityApiController::class, 'show']);

// Academic Programs GET Endpoints (for React Homepage)
Route::get('/academic-programs', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/academics', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/admin/programs', [AcademicProgramApiController::class, 'index']);
Route::get('/admin/programs/{id}', [AcademicProgramApiController::class, 'show']);

// Academics Page (Academic Journeys) GET Endpoints (Read-Only GET for React site)
Route::get('/academic-journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/academics/journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/academic-journeys/{idOrSlug}', [AcademicJourneyApiController::class, 'show']);
Route::get('/academics/journeys/{idOrSlug}', [AcademicJourneyApiController::class, 'show']);

// About JRS Homepage Section GET Endpoint
Route::get('/about', [AboutApiController::class, 'getAbout']);

// Vision & Mission Cards GET Endpoint
Route::get('/vision-mission', [VisionMissionApiController::class, 'index']);

// Beyond Classroom Page & CTA GET Endpoints (Read-Only GET for React site & Beyond Classroom page)
Route::get('/beyond-classroom-page', [BeyondClassroomApiController::class, 'getPageData']);
Route::get('/beyond-page', [BeyondClassroomApiController::class, 'getPageData']);
Route::get('/beyond-classroom-cta', [BeyondClassroomApiController::class, 'getCta']);
Route::get('/beyond-cta', [BeyondClassroomApiController::class, 'getCta']);
Route::get('/beyond-classrooms', [BeyondClassroomApiController::class, 'getActiveActivities']);
Route::get('/beyond-classroom', [BeyondClassroomApiController::class, 'getActiveActivities']);
Route::get('/beyond', [BeyondClassroomApiController::class, 'getActiveActivities']);
Route::get('/beyond/activities', [BeyondClassroomApiController::class, 'getActiveActivities']);
Route::get('/beyond-classrooms/{id}', [BeyondClassroomApiController::class, 'show']);
Route::get('/beyond-classroom/{id}', [BeyondClassroomApiController::class, 'show']);
Route::get('/beyond/{id}', [BeyondClassroomApiController::class, 'show']);

// Latest Events GET Endpoints (for React Homepage)
Route::get('/events', [SchoolEventApiController::class, 'getActiveEvents']);
Route::get('/latest-events', [SchoolEventApiController::class, 'getActiveEvents']);
Route::get('/events/{id}', [SchoolEventApiController::class, 'show']);

// Key Features GET Endpoints (for React Homepage)
Route::get('/features', [HomeFeatureApiController::class, 'getActiveFeatures']);
Route::get('/home-features', [HomeFeatureApiController::class, 'getActiveFeatures']);
Route::get('/features/{id}', [HomeFeatureApiController::class, 'show']);

// Stats Section GET Endpoints (for React Homepage)
Route::get('/stats', [HomeStatApiController::class, 'getActiveStats']);
Route::get('/home-stats', [HomeStatApiController::class, 'getActiveStats']);
Route::get('/stats/{id}', [HomeStatApiController::class, 'show']);

// Careers Page GET Endpoints (Read-Only GET for React site & Careers page)
Route::get('/careers-page', [CareerApiController::class, 'getPageData']);
Route::get('/careers/teaching', [CareerApiController::class, 'getTeachingSection']);
Route::get('/careers/benefits', [CareerApiController::class, 'getBenefits']);
Route::get('/careers/why-join', [CareerApiController::class, 'getBenefits']);
Route::get('/careers/benefits/{id}', [CareerApiController::class, 'showBenefit']);
Route::get('/careers/how-to-apply', [CareerApiController::class, 'getApplicationProcess']);
Route::get('/careers/application-process', [CareerApiController::class, 'getApplicationProcess']);
Route::get('/careers/openings', [CareerApiController::class, 'getJobOpenings']);
Route::get('/careers', [CareerApiController::class, 'getJobOpenings']);
Route::get('/careers/openings/{id}', [CareerApiController::class, 'showOpening']);

// Campus Tour & Life At JRS
Route::get('/campus-tour', [CampusLifeApiController::class, 'index']);

// Why Choose JRS ("What Makes JRS Different?")
Route::get('/why-choose', [WhyChooseApiController::class, 'index']);

// Parent Teacher Association (PTA)
Route::get('/pta-members', [PtaMemberApiController::class, 'index']);

// Gallery Page Endpoints (Albums & Media for React Frontend)
Route::get('/gallery-page', [GalleryApiController::class, 'getPageData']);
Route::get('/gallery', [GalleryApiController::class, 'getPageData']);
Route::get('/gallery-albums', [GalleryApiController::class, 'getAlbums']);
Route::get('/gallery-albums/{idOrSlug}', [GalleryApiController::class, 'getAlbum']);
Route::get('/gallery-items', [GalleryApiController::class, 'getItems']);

// News & Media Endpoints (Press Coverage & Achievements for React Frontend)
Route::get('/media-page', [NewsMediaApiController::class, 'getPageData']);
Route::get('/news-media', [NewsMediaApiController::class, 'getItems']);
Route::get('/news-media/{id}', [NewsMediaApiController::class, 'show']);




