<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionEnquiry;
use App\Models\ContactMessage;
use App\Models\CareerApplication;
use App\Models\NewsTicker;
use App\Models\HeroSlide;
use App\Models\SchoolEvent;
use App\Models\Facility;
use App\Models\AcademicStage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Show Admin Dashboard overview.
     */
    public function index()
    {
        $dbConnected = true;
        $dbError = null;

        $totalEnquiries = 0;
        $newEnquiriesToday = 0;
        $pendingEnquiries = 0;
        $totalMessages = 0;
        $unreadMessages = 0;
        $activeTickers = 0;
        $totalEvents = 0;
        $activeSlides = 0;
        $recentEnquiries = collect();
        $recentMessages = collect();
        $tickers = collect();
        $statusCounts = [
            'new' => 0,
            'contacted' => 0,
            'scheduled_tour' => 0,
            'admitted' => 0,
            'closed' => 0,
        ];

        try {
            if (Schema::hasTable('admission_enquiries')) {
                $totalEnquiries = AdmissionEnquiry::count();
                $newEnquiriesToday = AdmissionEnquiry::whereDate('created_at', today())->count();
                $pendingEnquiries = AdmissionEnquiry::where('status', 'new')->count();
                $recentEnquiries = AdmissionEnquiry::latest()->take(6)->get();

                $statusCounts = [
                    'new' => AdmissionEnquiry::where('status', 'new')->count(),
                    'contacted' => AdmissionEnquiry::where('status', 'contacted')->count(),
                    'scheduled_tour' => AdmissionEnquiry::where('status', 'scheduled_tour')->count(),
                    'admitted' => AdmissionEnquiry::where('status', 'admitted')->count(),
                    'closed' => AdmissionEnquiry::where('status', 'closed')->count(),
                ];
            }

            if (Schema::hasTable('contact_messages')) {
                $totalMessages = ContactMessage::count();
                $unreadMessages = ContactMessage::where('status', 'unread')->count();
                $recentMessages = ContactMessage::latest()->take(5)->get();
            }

            if (Schema::hasTable('news_tickers')) {
                $activeTickers = NewsTicker::where('is_active', true)->count();
                $tickers = NewsTicker::where('is_active', true)->orderBy('sort_order')->get();
            }

            if (Schema::hasTable('school_events')) {
                $totalEvents = SchoolEvent::count();
            }

            if (Schema::hasTable('hero_slides')) {
                $activeSlides = HeroSlide::where('is_active', true)->count();
            }
        } catch (\Throwable $e) {
            $dbConnected = false;
            $dbError = $e->getMessage();
        }

        return view('admin.dashboard', compact(
            'dbConnected',
            'dbError',
            'totalEnquiries',
            'newEnquiriesToday',
            'pendingEnquiries',
            'totalMessages',
            'unreadMessages',
            'activeTickers',
            'totalEvents',
            'activeSlides',
            'recentEnquiries',
            'recentMessages',
            'tickers',
            'statusCounts'
        ));
    }

    /**
     * One-click Setup/Reset Initial Seed Data right from the dashboard.
     */
    public function setupDatabase()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--class' => 'JrsSchoolSeeder', '--force' => true]);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Database tables and JRS School sample data initialized successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error setting up database: ' . $e->getMessage());
        }
    }
}
