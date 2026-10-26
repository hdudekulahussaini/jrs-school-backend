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
            'section' => [
                'eyebrow'         => 'ADMISSIONS FAQS',
                'title'           => 'Frequently Asked Questions',
                'title_prefix'    => 'Frequently Asked',
                'title_highlight' => 'Questions',
                'description'     => 'Find answers to commonly asked questions about admissions, academics, and life at JRS.',
            ],
            'count'   => $data->count(),
            'data'    => $data,
        ], 200);
    }
}
