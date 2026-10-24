<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsTickerApiController;
use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\VisionMissionApiController;

/*
|--------------------------------------------------------------------------
| API Routes for JRS International School
|--------------------------------------------------------------------------
*/

// News Ticker Marquee
Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);

// About JRS Homepage Section
Route::get('/about', [AboutApiController::class, 'getAbout']);

// Vision & Mission Cards
Route::get('/vision-mission', [VisionMissionApiController::class, 'index']);
