<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\NewsTickerController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AcademicStageController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\SchoolStatController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes - JRS International School Admin Dashboard
|--------------------------------------------------------------------------
*/

// Root redirect to Admin Dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard Routes
Route::prefix('admin')->middleware(['web'])->group(function () {
    // Overview Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::match(['GET', 'POST'], '/setup-database', [DashboardController::class, 'setupDatabase'])->name('admin.setup-db');
    Route::get('/setup-db-now', [DashboardController::class, 'setupDatabase']);

    // 1. Admission Enquiries & Leads Management
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries.index');
    Route::get('/enquiries/export', [EnquiryController::class, 'exportCsv'])->name('admin.enquiries.export');
    Route::put('/enquiries/{id}', [EnquiryController::class, 'update'])->name('admin.enquiries.update');
    Route::delete('/enquiries/{id}', [EnquiryController::class, 'destroy'])->name('admin.enquiries.destroy');

    // 2. News Marquee Ticker
    Route::get('/tickers', [NewsTickerController::class, 'index'])->name('admin.tickers.index');
    Route::post('/tickers', [NewsTickerController::class, 'store'])->name('admin.tickers.store');
    Route::put('/tickers/{id}', [NewsTickerController::class, 'update'])->name('admin.tickers.update');
    Route::post('/tickers/{id}/toggle', [NewsTickerController::class, 'toggle'])->name('admin.tickers.toggle');
    Route::delete('/tickers/{id}', [NewsTickerController::class, 'destroy'])->name('admin.tickers.destroy');

    // 3. Hero Banner Slides
    Route::get('/hero', [HeroSlideController::class, 'index'])->name('admin.hero.index');
    Route::post('/hero', [HeroSlideController::class, 'store'])->name('admin.hero.store');
    Route::put('/hero/{id}', [HeroSlideController::class, 'update'])->name('admin.hero.update');
    Route::post('/hero/{id}/toggle', [HeroSlideController::class, 'toggle'])->name('admin.hero.toggle');
    Route::delete('/hero/{id}', [HeroSlideController::class, 'destroy'])->name('admin.hero.destroy');

    // 4. What's Happening Events
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');

    // 5. Academic Stages
    Route::get('/academics', [AcademicStageController::class, 'index'])->name('admin.academics.index');
    Route::post('/academics', [AcademicStageController::class, 'store'])->name('admin.academics.store');
    Route::put('/academics/{id}', [AcademicStageController::class, 'update'])->name('admin.academics.update');
    Route::delete('/academics/{id}', [AcademicStageController::class, 'destroy'])->name('admin.academics.destroy');

    // 6. Campus Facilities & Infrastructure
    Route::get('/facilities', [FacilityController::class, 'index'])->name('admin.facilities.index');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('admin.facilities.store');
    Route::put('/facilities/{id}', [FacilityController::class, 'update'])->name('admin.facilities.update');
    Route::delete('/facilities/{id}', [FacilityController::class, 'destroy'])->name('admin.facilities.destroy');

    // 7. Counter Statistics
    Route::get('/stats', [SchoolStatController::class, 'index'])->name('admin.stats.index');
    Route::post('/stats', [SchoolStatController::class, 'store'])->name('admin.stats.store');
    Route::put('/stats/{id}', [SchoolStatController::class, 'update'])->name('admin.stats.update');
    Route::delete('/stats/{id}', [SchoolStatController::class, 'destroy'])->name('admin.stats.destroy');

    // 8. Contact Messages Inbox
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('admin.messages.index');
    Route::post('/messages/{id}/read', [ContactMessageController::class, 'markAsRead'])->name('admin.messages.read');
    Route::delete('/messages/{id}', [ContactMessageController::class, 'destroy'])->name('admin.messages.destroy');

    // 9. School Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // 10. React API Integration & Testing Documentation
    Route::get('/api-docs', function () {
        return view('admin.api-docs');
    })->name('admin.api.docs');
});
