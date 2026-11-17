<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdmissionFaq;
use Illuminate\Http\JsonResponse;

class AdmissionFaqApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/admission-faqs
     */
    public function index(): JsonResponse
    {
        $faqs = AdmissionFaq::orderBy('id', 'asc')->get();

        $data = $faqs->map(function ($faq) {
            return [
                'id'       => $faq->id,
                'question' => $faq->question,
                'answer'   => $faq->answer,
            ];
        });

        return response()->json([
            'success' => true,
            'count'   => $data->count(),
            'data'    => $data,
        ], 200);
    }
}
