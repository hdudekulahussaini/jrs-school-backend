<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsTickerController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\AcademicProgramController;

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

    // Academic Programs Full CRUD Resource
    Route::resource('/programs', AcademicProgramController::class)->names('admin.programs');
    Route::post('/programs/{id}/toggle', [AcademicProgramController::class, 'toggle'])->name('admin.programs.toggle');

    // Admin Swagger Documentation
    Route::get('/swagger', function () {
        return view('admin.swagger');
    })->name('admin.swagger');
});
