<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AcademicJourneyController;
use App\Http\Controllers\Admin\AcademicProgramController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BeyondClassroomController;
use App\Http\Controllers\Admin\BeyondClassroomCtaController;
use App\Http\Controllers\Admin\CareerBenefitController;
use App\Http\Controllers\Admin\CareerOpportunityController;
use App\Http\Controllers\Admin\CareerSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\HomeFeatureController;
use App\Http\Controllers\Admin\HomeStatController;
use App\Http\Controllers\Admin\NewsTickerController;
use App\Http\Controllers\Admin\SchoolEventController;
use App\Http\Controllers\Admin\VisionMissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampusLifeController;
use App\Http\Controllers\Admin\WhyChooseController;
use App\Http\Controllers\Admin\PtaMemberController;
use App\Http\Controllers\Admin\AmenityCtaController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\NewsMediaController;
use App\Http\Controllers\Admin\TopBarController;
use App\Http\Controllers\Admin\AdmissionBannerController;
use App\Http\Controllers\Admin\AdmissionHeroController;
use App\Http\Controllers\Admin\AdmissionStepController;
use App\Http\Controllers\Admin\AdmissionCriterionController;
use App\Http\Controllers\Admin\AdmissionFaqController;
use App\Http\Controllers\Admin\AdmissionEnquiryController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\ContactInquiryController;
use App\Http\Controllers\Admin\ChairmanMessageController;
use App\Http\Controllers\Admin\PrincipalMessageController;
use App\Http\Controllers\Admin\EducationalSocietyController;
use App\Http\Controllers\Admin\SchoolManagementCommitteeController;
use App\Http\Controllers\Admin\MandatoryDisclosureController;
use App\Http\Controllers\Admin\BreadcrumbBannerController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - JRS International School Admin Dashboard
|--------------------------------------------------------------------------
*/

// Root redirect to Admin Dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication Routes (Only /admin/login exists)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Direct Swagger Documentation Route
Route::get('/swagger', function () {
    return view('admin.swagger');
})->name('swagger');

// Protected Admin Dashboard Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Profile Management (Update Profile, Email, Password)
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/email', [ProfileController::class, 'updateEmail'])->name('admin.profile.email');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    Route::get('/top-bar', [TopBarController::class, 'index'])->name('admin.top-bar.index');
    Route::get('/top-bar/edit', [TopBarController::class, 'edit'])->name('admin.top-bar.edit');
    Route::post('/top-bar', [TopBarController::class, 'update'])->name('admin.top-bar.update');

    // News Tickers Full CRUD Resource
    Route::resource('/tickers', NewsTickerController::class)->names('admin.tickers');

    // Hero Sliders Full CRUD Resource
    Route::resource('/sliders', HeroSliderController::class)->names('admin.sliders');

    // Key Features Full CRUD Resource
    Route::resource('/features', HomeFeatureController::class)->names('admin.features');
    Route::post('/features/{id}/toggle', [HomeFeatureController::class, 'toggle'])->name('admin.features.toggle');

    // Stats Section Full CRUD Resource (Homepage Impact Numbers)
    Route::resource('/stats', HomeStatController::class)->names('admin.stats');
    Route::post('/stats/{id}/toggle', [HomeStatController::class, 'toggle'])->name('admin.stats.toggle');

    // Campus Amenities / Facilities Full CRUD Resource
    Route::resource('/facilities', FacilityController::class)->names('admin.facilities');
    Route::post('/facilities/{id}/toggle', [FacilityController::class, 'toggle'])->name('admin.facilities.toggle');
    Route::resource('/amenities', FacilityController::class)->names('admin.amenities');
    Route::post('/amenities/{id}/toggle', [FacilityController::class, 'toggle'])->name('admin.amenities.toggle');
    Route::resource('/amenities-cta', AmenityCtaController::class)->names('admin.amenities-cta');
    Route::post('/amenities-cta/{id}/toggle', [AmenityCtaController::class, 'toggle'])->name('admin.amenities-cta.toggle');

    // About JRS Section Full CRUD Resource
    Route::resource('/about', AboutSectionController::class)->names('admin.about');

    // Vision & Mission Full CRUD Resource
    Route::resource('/vision-mission', VisionMissionController::class)->names('admin.vision-mission');

    // Campus Tour & Life Full CRUD Resource
    Route::resource('/campus-life', CampusLifeController::class)->names('admin.campus-life');

    // Why Choose JRS Full CRUD Resource
    Route::resource('/why-choose', WhyChooseController::class)->names('admin.why-choose');

    // Parent Teacher Association (PTA) Full CRUD Resource
    Route::resource('/pta-members', PtaMemberController::class)->names('admin.pta-members');

    // Educational Society Managing Committee Full CRUD Resource
    Route::resource('/educational-society', EducationalSocietyController::class)->names('admin.educational-society');

    // School Management Committee (SMC) Full CRUD Resource
    Route::resource('/school-management-committee', SchoolManagementCommitteeController::class)->names('admin.school-management-committee');

    // Admission & Campus Tour CTA Banner (About Page)
    Route::resource('/admission-banner', AdmissionBannerController::class)->names('admin.admission-banner');

    // Mandatory Disclosure (About Page) Full CRUD Resource
    Route::resource('/mandatory-disclosure', MandatoryDisclosureController::class)->names('admin.mandatory-disclosure');
    Route::post('/mandatory-disclosure/{id}/toggle', [MandatoryDisclosureController::class, 'toggle'])->name('admin.mandatory-disclosure.toggle');
    // Admission Open Hero Section (Header)
    Route::get('/admission-hero', [AdmissionHeroController::class, 'index'])->name('admin.admission-hero.index');
    Route::put('/admission-hero', [AdmissionHeroController::class, 'update'])->name('admin.admission-hero.update');

    // Admission Process (6 Steps) Full CRUD Resource
    Route::resource('/admission-steps', AdmissionStepController::class)->names('admin.admission-steps');

    // Admission Criteria & Guidelines Full CRUD Resource
    Route::resource('/admission-criteria', AdmissionCriterionController::class)->names('admin.admission-criteria');

    // Admission FAQs Full CRUD Resource
    Route::resource('/admission-faqs', AdmissionFaqController::class)->names('admin.admission-faqs');

    // Admission Form Enquiries CRM
    Route::resource('/admission-enquiries', AdmissionEnquiryController::class)->only(['index', 'update', 'destroy'])->names('admin.admission-enquiries');

    // Chairman of JRS - Leadership Page Sections
    Route::get('/chairman', [ChairmanMessageController::class, 'index'])->name('admin.chairman.index');
    Route::get('/chairman/{id}/edit', [ChairmanMessageController::class, 'edit'])->name('admin.chairman.edit');
    Route::put('/chairman/{id}', [ChairmanMessageController::class, 'update'])->name('admin.chairman.update');
    Route::post('/chairman/{id}/toggle', [ChairmanMessageController::class, 'toggle'])->name('admin.chairman.toggle');

    // Principal of JRS - Leadership Page Sections
    Route::get('/principal', [PrincipalMessageController::class, 'index'])->name('admin.principal.index');
    Route::get('/principal/{id}/edit', [PrincipalMessageController::class, 'edit'])->name('admin.principal.edit');
    Route::put('/principal/{id}', [PrincipalMessageController::class, 'update'])->name('admin.principal.update');
    Route::post('/principal/{id}/toggle', [PrincipalMessageController::class, 'toggle'])->name('admin.principal.toggle');

    // Academic Programs Full CRUD Resource
    Route::resource('/programs', AcademicProgramController::class)->names('admin.programs');
    Route::post('/programs/{id}/toggle', [AcademicProgramController::class, 'toggle'])->name('admin.programs.toggle');

    // Academics Page (Academic Journeys) Full CRUD Resource
    Route::resource('/academic-journeys', AcademicJourneyController::class)->names('admin.academic-journeys');
    Route::post('/academic-journeys/{id}/toggle', [AcademicJourneyController::class, 'toggle'])->name('admin.academic-journeys.toggle');

    // Beyond Classroom Full CRUD Resource
    Route::resource('/beyond-classrooms', BeyondClassroomController::class)->names('admin.beyond-classrooms');
    Route::post('/beyond-classrooms/{id}/toggle', [BeyondClassroomController::class, 'toggle'])->name('admin.beyond-classrooms.toggle');

    // Beyond Classroom CTA Banner Full CRUD Resource
    Route::resource('/beyond-classroom-cta', BeyondClassroomCtaController::class)->names('admin.beyond-classroom-cta');
    Route::post('/beyond-classroom-cta/{id}/toggle', [BeyondClassroomCtaController::class, 'toggle'])->name('admin.beyond-classroom-cta.toggle');

    // Latest Events Full CRUD Resource
    Route::resource('/events', SchoolEventController::class)->names('admin.events');
    Route::post('/events/{id}/toggle', [SchoolEventController::class, 'toggle'])->name('admin.events.toggle');

    // Careers Page - Teaching at JRS Overview Full CRUD Resource
    Route::resource('/careers-teaching', CareerSectionController::class)->names('admin.careers-teaching');
    Route::post('/careers-teaching/{id}/toggle', [CareerSectionController::class, 'toggle'])->name('admin.careers-teaching.toggle');

    // Careers Page - Work Culture & Benefits Full CRUD Resource
    Route::resource('/careers-benefits', CareerBenefitController::class)->names('admin.careers-benefits');
    Route::post('/careers-benefits/{id}/toggle', [CareerBenefitController::class, 'toggle'])->name('admin.careers-benefits.toggle');

    // Careers Page - Career Opportunities & How To Apply Full CRUD Resource
    Route::resource('/careers-opportunities', CareerOpportunityController::class)->names('admin.careers-opportunities');
    Route::post('/careers-opportunities/{id}/toggle', [CareerOpportunityController::class, 'toggle'])->name('admin.careers-opportunities.toggle');

    // Gallery Page Full CRUD Resource (Albums & Photos/Videos & News Media)
    Route::resource('/gallery-albums', GalleryAlbumController::class)->names('admin.gallery-albums');
    Route::post('/gallery-albums/{id}/toggle', [GalleryAlbumController::class, 'toggle'])->name('admin.gallery-albums.toggle');
    Route::resource('/gallery-items', GalleryItemController::class)->names('admin.gallery-items');
    Route::post('/gallery-items/{id}/toggle', [GalleryItemController::class, 'toggle'])->name('admin.gallery-items.toggle');
    Route::resource('/news-media', NewsMediaController::class)->names('admin.news-media');
    Route::post('/news-media/{id}/toggle', [NewsMediaController::class, 'toggle'])->name('admin.news-media.toggle');

    // Contact Us Settings
    Route::get('/contact-settings', [ContactSettingController::class, 'index'])->name('admin.contact-settings.index');
    Route::put('/contact-settings', [ContactSettingController::class, 'update'])->name('admin.contact-settings.update');

    // Contact Us Online Inquiries CRM
    Route::resource('/contact-inquiries', ContactInquiryController::class)->only(['index', 'show', 'update', 'destroy'])->names('admin.contact-inquiries');

    // Breadcrumb Banners Full CRUD Resource
    Route::post('/breadcrumb-banners/{id}/toggle', [BreadcrumbBannerController::class, 'toggle'])->name('admin.breadcrumb-banners.toggle');
    Route::resource('/breadcrumb-banners', BreadcrumbBannerController::class)->names('admin.breadcrumb-banners');

    // Admin Swagger Documentation
    Route::get('/swagger', function () {
        return view('admin.swagger');
    })->name('admin.swagger');

});



