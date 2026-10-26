<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionCriterion;
use Illuminate\Http\JsonResponse;

class AdmissionCriterionApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/admission-criteria
     */
    public function index(): JsonResponse
    {
        $criteria = AdmissionCriterion::orderBy('step_number', 'asc')->get();

        $data = $criteria->map(function ($item) {
            return [
                'id'          => $item->id,
                'step_number' => $item->step_number,
                'watermark'   => $item->watermark_number,
                'badge_tag'   => $item->badge_tag,
                'title'       => $item->title,
                'description' => $item->description,
                'icon'        => $item->icon,
                'note'        => $item->note,
                'points'      => $item->points ?? [],
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'eyebrow'         => 'ADMISSION ARRANGEMENTS & POLICY',
                'title'           => 'Admission Criteria & Guidelines',
                'title_prefix'    => 'Admission Criteria &',
                'title_highlight' => 'Guidelines',
                'description'     => 'Essential guidelines for parents applying to Nursery and Grades 1 through 12, designed to ensure a fair, supportive, and child-centered enrollment process.',
            ],
            'count'   => $data->count(),
            'data'    => $data,
        ], 200);
    }
}
