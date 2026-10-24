<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AcademicProgramController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BeyondClassroomController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\HeroSliderController;
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

    // Facilities Full CRUD Resource
    Route::resource('/facilities', FacilityController::class)->names('admin.facilities');
    Route::post('/facilities/{id}/toggle', [FacilityController::class, 'toggle'])->name('admin.facilities.toggle');
    // About JRS Section Full CRUD Resource
    Route::resource('/about', AboutSectionController::class)->names('admin.about');

    // Vision & Mission Full CRUD Resource
    Route::resource('/vision-mission', VisionMissionController::class)->names('admin.vision-mission');
    Route::post('/vision-mission/{id}/toggle', [VisionMissionController::class, 'toggle'])->name('admin.vision-mission.toggle');

    // Academic Programs Full CRUD Resource
    Route::resource('/programs', AcademicProgramController::class)->names('admin.programs');
    Route::post('/programs/{id}/toggle', [AcademicProgramController::class, 'toggle'])->name('admin.programs.toggle');

    // Beyond Classroom Full CRUD Resource
    Route::resource('/beyond-classrooms', BeyondClassroomController::class)->names('admin.beyond-classrooms');
    Route::post('/beyond-classrooms/{id}/toggle', [BeyondClassroomController::class, 'toggle'])->name('admin.beyond-classrooms.toggle');

    // Latest Events Full CRUD Resource
    Route::resource('/events', SchoolEventController::class)->names('admin.events');
    Route::post('/events/{id}/toggle', [SchoolEventController::class, 'toggle'])->name('admin.events.toggle');

    // Admin Swagger Documentation
    Route::get('/swagger', function () {
        return view('admin.swagger');
    })->name('admin.swagger');
});
