<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerBenefit;
use App\Models\CareerOpportunity;
use App\Models\CareerSection;
use App\Models\JobOpening;
use Illuminate\Http\JsonResponse;

class CareerApiController extends Controller
{
    /**
     * Public endpoint for the "Teaching at JRS" overview section: GET /api/careers/teaching
     */
    public function getTeachingSection(): JsonResponse
    {
        $section = CareerSection::select([
            'id',
            'title',
            'description',
            'image_path',
            'created_at',
            'updated_at',
        ])->first();

        if (!$section) {
            return response()->json([
                'success' => false,
                'message' => 'No Teaching at JRS section found',
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
     * Public endpoint for "Why Join JRS? / Work Culture & Benefits": GET /api/careers/benefits
     */
    public function getBenefits(): JsonResponse
    {
        $benefits = CareerBenefit::where('is_active', true)
            ->select([
                'id',
                'title',
                'icon',
                'description',
                'sort_order',
                'is_active',
                'created_at',
                'updated_at',
            ])
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Work Culture & Benefits retrieved successfully',
            'count' => $benefits->count(),
            'total' => $benefits->count(),
            'data' => $benefits,
        ], 200);
    }

    /**
     * Public endpoint for Career Opportunities & How To Apply: GET /api/careers/how-to-apply
     */
    public function getApplicationProcess(): JsonResponse
    {
        $opportunity = CareerOpportunity::where('is_active', true)
            ->select([
                'id',
                'title',
                'description',
                'card_title',
                'card_description',
                'email',
                'checklist_items',
                'is_active',
                'created_at',
                'updated_at',
            ])
            ->first();

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
     * Public endpoint for active job openings: GET /api/careers/openings
     */
    public function getJobOpenings(): JsonResponse
    {
        $openings = JobOpening::where('is_active', true)
            ->select([
                'id',
                'title',
                'department',
                'job_type',
                'experience',
                'qualification',
                'description',
                'sort_order',
                'is_active',
                'created_at',
                'updated_at',
            ])
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
}
