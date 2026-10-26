<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MandatoryDisclosure;
use Illuminate\Http\JsonResponse;

class MandatoryDisclosureApiController extends Controller
{
    /**
     * Return public Mandatory Disclosure page bundle for React frontend.
     */
    public function index(): JsonResponse
    {
        $generalInfo = MandatoryDisclosure::where('category', 'general_info')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $documents = MandatoryDisclosure::where('category', 'document')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Mandatory Disclosure data retrieved successfully',
            'data' => [
                'header' => [
                    'breadcrumb' => 'Home > Mandatory Disclosure',
                    'eyebrow' => 'STATUTORY COMPLIANCE & PUBLIC DISCLOSURE',
                    'title' => 'Mandatory Public Disclosure',
                    'subtitle' => 'CBSE Public Disclosure & Statutory Compliance',
                    'description' => 'In compliance with CBSE regulations, here are the mandatory public disclosures, statutory certificates, infrastructure details, and academic records for JRS International School.',
                ],
                'general_information' => [
                    'title' => 'General Information',
                    'count' => $generalInfo->count(),
                    'items' => $generalInfo,
                ],
                'documents_and_information' => [
                    'title' => 'Documents And Information',
                    'count' => $documents->count(),
                    'items' => $documents,
                ],
            ],
        ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
