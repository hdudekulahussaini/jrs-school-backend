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
use App\Http\Controllers\Admin\JobOpeningController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\HomeFeatureController;
use App\Http\Controllers\Admin\HomeStatController;
use App\Http\Controllers\Admin\NewsTickerController;
use App\Http\Controllers\Admin\SchoolEventController;
use App\Http\Controllers\Admin\VisionMissionController;
use Illuminate\Support\Facades\Route;

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

    // News Tickers Full CRUD Resource
    Route::resource('/tickers', NewsTickerController::class)->names('admin.tickers');
    Route::post('/tickers/{id}/toggle', [NewsTickerController::class, 'toggle'])->name('admin.tickers.toggle');

    // Hero Sliders Full CRUD Resource
    Route::resource('/sliders', HeroSliderController::class)->names('admin.sliders');
    Route::post('/sliders/{id}/toggle', [HeroSliderController::class, 'toggle'])->name('admin.sliders.toggle');

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
    // About JRS Section Full CRUD Resource
    Route::resource('/about', AboutSectionController::class)->names('admin.about');

    // Vision & Mission Full CRUD Resource
    Route::resource('/vision-mission', VisionMissionController::class)->names('admin.vision-mission');
    Route::post('/vision-mission/{id}/toggle', [VisionMissionController::class, 'toggle'])->name('admin.vision-mission.toggle');

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

    // Careers Page - Job Openings Full CRUD Resource
    Route::resource('/job-openings', JobOpeningController::class)->names('admin.job-openings');
    Route::post('/job-openings/{id}/toggle', [JobOpeningController::class, 'toggle'])->name('admin.job-openings.toggle');

    // Admin Swagger Documentation
    Route::get('/swagger', function () {
        return view('admin.swagger');
    })->name('admin.swagger');
});
