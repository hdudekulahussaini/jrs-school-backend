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
use App\Http\Controllers\Api\AdmissionBannerApiController;
use App\Http\Controllers\Api\AdmissionBrochureApiController;
use App\Http\Controllers\Api\ChairmanMessageApiController;
use App\Http\Controllers\Api\PrincipalMessageApiController;
use App\Http\Controllers\Api\EducationalSocietyApiController;
use App\Http\Controllers\Api\SchoolManagementCommitteeApiController;
use App\Http\Controllers\Api\MandatoryDisclosureApiController;
use App\Http\Controllers\Api\AdmissionStepApiController;
use App\Http\Controllers\Api\AdmissionCriterionApiController;
use App\Http\Controllers\Api\AdmissionFaqApiController;
use App\Http\Controllers\Api\AdmissionHeroApiController;
use App\Http\Controllers\Api\AdmissionEnquiryApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\BreadcrumbBannerApiController;

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

// News Ticker Endpoints (Frontend & REST CRUD)
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);
Route::get('/news-tickers', [NewsTickerApiController::class, 'index']);
Route::post('/news-tickers', [NewsTickerApiController::class, 'store']);
Route::get('/news-tickers/{id}', [NewsTickerApiController::class, 'show']);
Route::put('/news-tickers/{id}', [NewsTickerApiController::class, 'update']);
Route::patch('/news-tickers/{id}', [NewsTickerApiController::class, 'update']);
Route::patch('/news-tickers/{id}/toggle', [NewsTickerApiController::class, 'toggle']);
Route::delete('/news-tickers/{id}', [NewsTickerApiController::class, 'destroy']);

// Hero Slider Endpoints (Frontend & REST CRUD)
Route::get('/hero-slider', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/hero-sliders', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/sliders', [HeroSliderApiController::class, 'index']);
Route::post('/sliders', [HeroSliderApiController::class, 'store']);
Route::get('/sliders/{id}', [HeroSliderApiController::class, 'show']);
Route::put('/sliders/{id}', [HeroSliderApiController::class, 'update']);
Route::patch('/sliders/{id}', [HeroSliderApiController::class, 'update']);
Route::patch('/sliders/{id}/toggle', [HeroSliderApiController::class, 'toggle']);
Route::delete('/sliders/{id}', [HeroSliderApiController::class, 'destroy']);

// Campus Amenities / Facilities Endpoints (Frontend & REST CRUD)
Route::get('/amenities-page', [FacilityApiController::class, 'getPageData']);
Route::get('/amenities-cta', [FacilityApiController::class, 'getCta']);
Route::get('/amenities/cta', [FacilityApiController::class, 'getCta']);
Route::get('/amenities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/amenities/{id}', [FacilityApiController::class, 'show']);
Route::get('/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/facilities/{id}', [FacilityApiController::class, 'show']);
Route::get('/campus/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/admin/facilities', [FacilityApiController::class, 'index']);
Route::post('/admin/facilities', [FacilityApiController::class, 'store']);
Route::get('/admin/facilities/{id}', [FacilityApiController::class, 'show']);
Route::put('/admin/facilities/{id}', [FacilityApiController::class, 'update']);
Route::patch('/admin/facilities/{id}', [FacilityApiController::class, 'update']);
Route::patch('/admin/facilities/{id}/toggle', [FacilityApiController::class, 'toggle']);
Route::delete('/admin/facilities/{id}', [FacilityApiController::class, 'destroy']);
Route::post('/facilities', [FacilityApiController::class, 'store']);
Route::put('/facilities/{id}', [FacilityApiController::class, 'update']);
Route::patch('/facilities/{id}', [FacilityApiController::class, 'update']);
Route::delete('/facilities/{id}', [FacilityApiController::class, 'destroy']);

// Academic Programs Endpoints (Frontend & REST CRUD)
Route::get('/academic-programs', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/academics', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/admin/programs', [AcademicProgramApiController::class, 'index']);
Route::post('/admin/programs', [AcademicProgramApiController::class, 'store']);
Route::get('/admin/programs/{id}', [AcademicProgramApiController::class, 'show']);
Route::put('/admin/programs/{id}', [AcademicProgramApiController::class, 'update']);
Route::patch('/admin/programs/{id}', [AcademicProgramApiController::class, 'update']);
Route::patch('/admin/programs/{id}/toggle', [AcademicProgramApiController::class, 'toggle']);
Route::delete('/admin/programs/{id}', [AcademicProgramApiController::class, 'destroy']);
Route::post('/academic-programs', [AcademicProgramApiController::class, 'store']);
Route::put('/academic-programs/{id}', [AcademicProgramApiController::class, 'update']);
Route::patch('/academic-programs/{id}', [AcademicProgramApiController::class, 'update']);
Route::delete('/academic-programs/{id}', [AcademicProgramApiController::class, 'destroy']);

// Academics Page (Academic Journeys) GET Endpoints (Read-Only GET for React site)
Route::get('/academic-journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/academics/journeys', [AcademicJourneyApiController::class, 'index']);
Route::get('/academic-journeys/{id}', [AcademicJourneyApiController::class, 'show']);
Route::get('/academics/journeys/{id}', [AcademicJourneyApiController::class, 'show']);

// About JRS Homepage Section GET Endpoint
Route::get('/about', [AboutApiController::class, 'getAbout']);
Route::get('/about-us', [AboutApiController::class, 'getAbout']);

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
Route::get('/home-stats/{id}', [HomeStatApiController::class, 'show']);

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
Route::get('/campus-life', [CampusLifeApiController::class, 'index']);

// Why Choose JRS ("What Makes JRS Different?")
Route::get('/why-choose', [WhyChooseApiController::class, 'index']);

// Parent Teacher Association (PTA)
Route::get('/pta-members', [PtaMemberApiController::class, 'index']);
Route::get('/pta', [PtaMemberApiController::class, 'index']);

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



// Educational Society Managing Committee
Route::get('/educational-society', [EducationalSocietyApiController::class, 'index']);

// School Management Committee (SMC)
Route::get('/school-management-committee', [SchoolManagementCommitteeApiController::class, 'index']);

// Admission & Campus Tour CTA Banner (About Page)
Route::get('/admission-banner', [AdmissionBannerApiController::class, 'index']);

// Chairman of JRS - Leadership Page
Route::get('/chairman', [ChairmanMessageApiController::class, 'index']);
Route::get('/leadership/chairman', [ChairmanMessageApiController::class, 'index']);

// Principal of JRS - Leadership Page
Route::get('/principal', [PrincipalMessageApiController::class, 'index']);
Route::get('/leadership/principal', [PrincipalMessageApiController::class, 'index']);

// Mandatory Public Disclosure (CBSE Compliance & Statutory Certificates)
Route::get('/mandatory-disclosure', [MandatoryDisclosureApiController::class, 'index']);
Route::get('/mandatory-disclosures', [MandatoryDisclosureApiController::class, 'index']);
// Admission Open Hero Section (Header) - Admission Page
Route::get('/admission-hero', [AdmissionHeroApiController::class, 'index']);
Route::get('/admission-open', [AdmissionHeroApiController::class, 'index']);

// Admission Process (6 Steps) - Admission Page
Route::get('/admission-process', [AdmissionStepApiController::class, 'index']);
Route::get('/admission-steps', [AdmissionStepApiController::class, 'index']);

// Admission Criteria & Guidelines - Admission Page
Route::get('/admission-criteria', [AdmissionCriterionApiController::class, 'index']);

// Admission FAQs - Admission Page
Route::get('/admission-faqs', [AdmissionFaqApiController::class, 'index']);

// Admission Brochure (PDF & Link) - Admission Page
Route::get('/admission-brochure', [AdmissionBrochureApiController::class, 'index']);
Route::get('/brochure', [AdmissionBrochureApiController::class, 'index']);

// Contact Us & Campus Location
Route::get('/contact', [ContactApiController::class, 'index']);
Route::get('/contact-us', [ContactApiController::class, 'index']);
Route::post('/contact/inquiry', [ContactApiController::class, 'storeInquiry']);
Route::post('/contact-inquiries', [ContactApiController::class, 'storeInquiry']);
Route::get('/contact/grades', [ContactApiController::class, 'grades']);

// Admission Form Enquiries (Submission & Options)
Route::post('/admission-enquiries', [AdmissionEnquiryApiController::class, 'store']);
Route::get('/admission-enquiries/options', [AdmissionEnquiryApiController::class, 'options']);

// Breadcrumb Banners REST APIs (Dynamic Header Banners for React Frontend)
Route::get('/breadcrumb-banners/pages', [BreadcrumbBannerApiController::class, 'pages']);
Route::get('/breadcrumb-banners/page/{slug}', [BreadcrumbBannerApiController::class, 'getBySlug']);
Route::get('/breadcrumb-banners/by-slug/{slug}', [BreadcrumbBannerApiController::class, 'getBySlug']);
Route::get('/breadcrumb-banners', [BreadcrumbBannerApiController::class, 'index']);
Route::post('/breadcrumb-banners', [BreadcrumbBannerApiController::class, 'store']);
Route::get('/breadcrumb-banners/{idOrSlug}', [BreadcrumbBannerApiController::class, 'show']);
Route::put('/breadcrumb-banners/{id}', [BreadcrumbBannerApiController::class, 'update']);
Route::patch('/breadcrumb-banners/{id}', [BreadcrumbBannerApiController::class, 'update']);
Route::delete('/breadcrumb-banners/{id}', [BreadcrumbBannerApiController::class, 'destroy']);



