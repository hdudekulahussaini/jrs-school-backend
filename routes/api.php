<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SchoolApiController;

/*
|--------------------------------------------------------------------------
| API Routes for JRS International School React Frontend
|--------------------------------------------------------------------------
|
| These endpoints provide dynamic data for https://jrs-school.vercel.app/
| and handle form submissions for Admissions, Contacts & Careers.
|
*/

// Single unified homepage bundle for high performance
Route::get('/home-data', [SchoolApiController::class, 'getHomeData']);

// Individual dynamic data endpoints
Route::get('/news-ticker', [SchoolApiController::class, 'getNewsTickers']);
Route::get('/hero-slides', [SchoolApiController::class, 'getHeroSlides']);
Route::get('/academics', [SchoolApiController::class, 'getAcademics']);
Route::get('/facilities', [SchoolApiController::class, 'getFacilities']);
Route::get('/stats', [SchoolApiController::class, 'getStats']);
Route::get('/events', [SchoolApiController::class, 'getEvents']);

// Form Submissions from React Frontend
Route::post('/admissions/enquiry', [SchoolApiController::class, 'submitEnquiry']);
Route::post('/contact', [SchoolApiController::class, 'submitContact']);
Route::post('/careers/apply', [SchoolApiController::class, 'submitCareer']);
