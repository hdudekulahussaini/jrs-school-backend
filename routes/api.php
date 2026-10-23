<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsTickerApiController;

/*
|--------------------------------------------------------------------------
| API Routes for JRS International School
|--------------------------------------------------------------------------
|
| Public GET endpoint used by the React frontend (https://jrs-school.vercel.app/)
| to fetch active rolling marquee news ticker announcements.
|
*/

Route::get('/news-ticker', [NewsTickerApiController::class, 'getActiveTickers']);
