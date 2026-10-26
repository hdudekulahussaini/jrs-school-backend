<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerBenefit;
use App\Models\CareerOpportunity;
use App\Models\CareerSection;
use App\Models\JobOpening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CareerApiController extends Controller
{
    /**
     * Dedicated bundled endpoint for the entire Careers page on React site: GET /api/careers-page
     */
    public function getPageData(): JsonResponse
    {
        $overview = CareerSection::where('is_active', true)->first();
        
        $benefits = CareerBenefit::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $opportunity = CareerOpportunity::where('is_active', true)->first();

        $openings = JobOpening::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Careers page data retrieved successfully',
            'teaching_section' => $overview,
            'benefits_section' => [
                'badge' => 'WORK CULTURE & BENEFITS',
                'title' => 'Why Join JRS?',
                'highlight' => 'JRS?',
                'count' => $benefits->count(),
                'items' => $benefits,
            ],
            'application_process' => $opportunity,
            'openings_count' => $openings->count(),
            'openings' => $openings,
        ], 200);
    }

    /**
     * Public endpoint for the "Teaching at JRS" overview section: GET /api/careers/teaching
     */
    public function getTeachingSection(): JsonResponse
    {
        $section = CareerSection::where('is_active', true)->first();

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'No active Teaching at JRS section found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Teaching at JRS overview retrieved successfully',
            'data' => $section
        ], 200);
    }

    /**
     * Public endpoint for "Why Join JRS? / Work Culture & Benefits": GET /api/careers/benefits, GET /api/careers/why-join
     */
    public function getBenefits(): JsonResponse
    {
        $benefits = CareerBenefit::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Work Culture & Benefits retrieved successfully',
            'badge' => 'WORK CULTURE & BENEFITS',
            'title' => 'Why Join JRS?',
            'highlight' => 'JRS?',
            'count' => $benefits->count(),
            'data' => $benefits,
        ], 200);
    }

    /**
     * Public endpoint for single benefit item: GET /api/careers/benefits/{id}
     */
    public function showBenefit($id): JsonResponse
    {
        $benefit = CareerBenefit::find($id);

        if (!$benefit) {
            return response()->json([
                'success' => false,
                'message' => 'Benefit item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $benefit
        ], 200);
    }

    /**
     * Public endpoint for Career Opportunities & How To Apply: GET /api/careers/how-to-apply, GET /api/careers/application-process
     */
    public function getApplicationProcess(): JsonResponse
    {
        $opportunity = CareerOpportunity::where('is_active', true)->first();

        if (!$opportunity) {
            return response()->json([
                'success' => false,
                'message' => 'No active Career Opportunities / How To Apply section found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'How To Apply / Application Process retrieved successfully',
            'data' => $opportunity
        ], 200);
    }

    /**
     * Public endpoint for active job openings: GET /api/careers, /api/careers/openings
     */
    public function getJobOpenings(): JsonResponse
    {
        $openings = JobOpening::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active job openings retrieved successfully',
            'count' => $openings->count(),
            'total' => $openings->count(),
            'data' => $openings
        ], 200);
    }

    /**
     * Public endpoint for single job opening: GET /api/careers/openings/{id}
     */
    public function showOpening($id): JsonResponse
    {
        $opening = JobOpening::find($id);

        if (!$opening) {
            return response()->json([
                'success' => false,
                'message' => 'Job opening not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $opening
        ], 200);
    }
}
