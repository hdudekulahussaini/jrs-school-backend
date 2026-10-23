<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\NewsTicker;
use App\Models\HeroSlide;
use App\Models\SchoolEvent;
use App\Models\AcademicStage;
use App\Models\Facility;
use App\Models\SchoolStat;
use App\Models\SchoolSetting;
use App\Models\AdmissionEnquiry;
use App\Models\ContactMessage;
use App\Models\CareerApplication;

class SchoolApiController extends Controller
{
    /**
     * Get all homepage dynamic data in a single optimized payload.
     */
    public function getHomeData()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'news_tickers' => NewsTicker::where('is_active', true)->orderBy('sort_order')->get(),
                'hero_slides' => HeroSlide::where('is_active', true)->orderBy('sort_order')->get(),
                'academic_stages' => AcademicStage::where('is_active', true)->orderBy('sort_order')->get(),
                'facilities' => Facility::where('is_active', true)->orderBy('sort_order')->get(),
                'stats' => SchoolStat::where('is_active', true)->orderBy('sort_order')->get(),
                'events' => SchoolEvent::where('is_active', true)->where('is_featured', true)->orderBy('event_date', 'asc')->get(),
                'settings' => SchoolSetting::pluck('value', 'key'),
            ]
        ]);
    }

    /**
     * Get active news ticker announcements.
     */
    public function getNewsTickers()
    {
        $tickers = NewsTicker::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $tickers]);
    }

    /**
     * Get active hero slider items.
     */
    public function getHeroSlides()
    {
        $slides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $slides]);
    }

    /**
     * Get academic stages / curriculum details.
     */
    public function getAcademics()
    {
        $stages = AcademicStage::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $stages]);
    }

    /**
     * Get campus facilities and infrastructure.
     */
    public function getFacilities()
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $facilities]);
    }

    /**
     * Get counter statistics.
     */
    public function getStats()
    {
        $stats = SchoolStat::where('is_active', true)->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $stats]);
    }

    /**
     * Get school events / What's Happening.
     */
    public function getEvents()
    {
        $events = SchoolEvent::where('is_active', true)->orderBy('event_date', 'asc')->get();
        return response()->json(['success' => true, 'data' => $events]);
    }

    /**
     * Submit an admission enquiry from the home page enquiry form.
     */
    public function submitEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_name' => 'required|string|max:150',
            'student_name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'grade_applying' => 'required|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $enquiry = AdmissionEnquiry::create([
            'parent_name' => $request->parent_name,
            'student_name' => $request->student_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'grade_applying' => $request->grade_applying,
            'academic_year' => $request->academic_year ?? '2026-2027',
            'city' => $request->city,
            'message' => $request->message,
            'status' => 'new',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your admission enquiry has been submitted successfully. Our admissions team will contact you shortly.',
            'data' => $enquiry,
        ], 201);
    }

    /**
     * Submit a contact message.
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting JRS International School. We will get back to you soon.',
            'data' => $contact,
        ], 201);
    }

    /**
     * Submit a career application.
     */
    public function submitCareer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'position' => 'required|string|max:150',
            'experience_years' => 'nullable|string|max:50',
            'qualification' => 'nullable|string|max:150',
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        $application = CareerApplication::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'experience_years' => $request->experience_years,
            'qualification' => $request->qualification,
            'resume_path' => $resumePath,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your application has been received. Our HR team will review your profile.',
            'data' => $application,
        ], 201);
    }
}
