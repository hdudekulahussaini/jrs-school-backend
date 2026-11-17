<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionStep;
use Illuminate\Http\JsonResponse;

class AdmissionStepApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/admission-process or /api/admission-steps
     */
    public function index(): JsonResponse
    {
        $steps = AdmissionStep::orderBy('step_number', 'asc')->get();

        $data = $steps->map(function ($step) {
            return [
                'id'          => $step->id,
                'step_number' => $step->step_number,
                'title'       => $step->title,
                'description' => $step->description,
                'icon'        => $step->icon,
            ];
        });

        return response()->json([
            'success' => true,
            'count'   => $data->count(),
            'data'    => $data,
        ], 200);
    }
}
