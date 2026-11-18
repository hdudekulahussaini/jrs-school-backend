<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBrochure;
use Illuminate\Http\JsonResponse;

class AdmissionBrochureApiController extends Controller
{
    /**
     * Return admission brochure details for frontend.
     */
    public function index(): JsonResponse
    {
        $brochure = AdmissionBrochure::first();

        return response()->json([
            'success' => true,
            'message' => 'Admission brochure retrieved successfully',
            'data' => $brochure ? [
                'id' => $brochure->id,
                'title' => $brochure->title,
                'pdf_path' => $brochure->pdf_path,
                'brochure_link' => $brochure->brochure_link,
                'file_size' => $brochure->file_size,
                'is_active' => (bool)$brochure->is_active,
            ] : null,
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
