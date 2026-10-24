<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsTickerApiController;
use App\Http\Controllers\Api\HeroSliderApiController;
use App\Http\Controllers\Api\FacilityApiController;
use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\VisionMissionApiController;

/*
|--------------------------------------------------------------------------
| API Routes for JRS International School
|--------------------------------------------------------------------------
|
| Public endpoints used by the React frontend (https://jrs-school.vercel.app/)
| and external consumers to fetch active announcements, hero sliders, and facilities.
|
*/

// News Ticker Public & REST Endpoints
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);
Route::get('/news-tickers', [NewsTickerApiController::class, 'index']);
Route::post('/news-tickers', [NewsTickerApiController::class, 'store']);
Route::get('/news-tickers/{id}', [NewsTickerApiController::class, 'show']);
Route::match(['put', 'patch', 'post'], '/news-tickers/{id}', [NewsTickerApiController::class, 'update']);
Route::patch('/news-tickers/{id}/toggle', [NewsTickerApiController::class, 'toggle']);
Route::delete('/news-tickers/{id}', [NewsTickerApiController::class, 'destroy']);

// Hero Slider Public & REST Endpoints
Route::get('/hero-slider', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/hero-sliders', [HeroSliderApiController::class, 'getActiveSliders']);
Route::get('/sliders', [HeroSliderApiController::class, 'index']);
Route::post('/sliders', [HeroSliderApiController::class, 'store']);
Route::get('/sliders/{id}', [HeroSliderApiController::class, 'show']);
Route::match(['put', 'patch', 'post'], '/sliders/{id}', [HeroSliderApiController::class, 'update']);
Route::patch('/sliders/{id}/toggle', [HeroSliderApiController::class, 'toggle']);
Route::delete('/sliders/{id}', [HeroSliderApiController::class, 'destroy']);

// Facilities Public & REST Endpoints
Route::get('/facilities', [FacilityApiController::class, 'getActiveFacilities']);
Route::get('/admin/facilities', [FacilityApiController::class, 'index']);
Route::post('/admin/facilities', [FacilityApiController::class, 'store']);
Route::get('/admin/facilities/{id}', [FacilityApiController::class, 'show']);
Route::match(['put', 'patch', 'post'], '/admin/facilities/{id}', [FacilityApiController::class, 'update']);
Route::patch('/admin/facilities/{id}/toggle', [FacilityApiController::class, 'toggle']);
Route::delete('/admin/facilities/{id}', [FacilityApiController::class, 'destroy']);
*/

// News Ticker Marquee
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);

// About JRS Homepage Section
Route::get('/about', [AboutApiController::class, 'getAbout']);

// Vision & Mission Cards
Route::get('/vision-mission', [VisionMissionApiController::class, 'index']);
