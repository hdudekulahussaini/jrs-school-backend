<?php

use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\AcademicProgramApiController;
use App\Http\Controllers\Api\FacilityApiController;
use App\Http\Controllers\Api\HeroSliderApiController;
use App\Http\Controllers\Api\NewsTickerApiController;
use App\Http\Controllers\Api\VisionMissionApiController;
use Illuminate\Support\Facades\Route;

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

// News Ticker GET Endpoints
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);
Route::get('/news-tickers', [NewsTickerApiController::class, 'index']);
Route::get('/news-tickers/{id}', [NewsTickerApiController::class, 'show']);

// Hero Slider GET Endpoints
Route::get('/hero-slider', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/hero-sliders', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/sliders', [HeroSliderApiController::class, 'index']);
Route::get('/sliders/{id}', [HeroSliderApiController::class, 'show']);

// Facilities GET Endpoints
Route::get('/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/admin/facilities', [FacilityApiController::class, 'index']);
Route::get('/admin/facilities/{id}', [FacilityApiController::class, 'show']);

// Academic Programs GET Endpoints (for React Homepage)
Route::get('/academic-programs', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/academics', [AcademicProgramApiController::class, 'getActivePrograms']);
Route::get('/admin/programs', [AcademicProgramApiController::class, 'index']);
Route::get('/admin/programs/{id}', [AcademicProgramApiController::class, 'show']);

// About JRS Homepage Section GET Endpoint
Route::get('/about', [AboutApiController::class, 'getAbout']);

// Vision & Mission Cards GET Endpoint
Route::get('/vision-mission', [VisionMissionApiController::class, 'index']);
