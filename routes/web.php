<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsTickerController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\Admin\CampusLifeController;
use App\Http\Controllers\Admin\WhyChooseController;
use App\Http\Controllers\Admin\PtaMemberController;

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

    // Hero Sliders Full CRUD Resource
    Route::resource('/sliders', HeroSliderController::class)->names('admin.sliders');

    // Facilities Full CRUD Resource
    Route::resource('/facilities', FacilityController::class)->names('admin.facilities');

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

    // Admin Swagger Documentation
    Route::get('/swagger', function () {
        return view('admin.swagger');
    })->name('admin.swagger');
});

