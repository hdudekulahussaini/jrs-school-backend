<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolManagementMember;
use Illuminate\Http\JsonResponse;

class SchoolManagementCommitteeApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/school-management-committee
     * Returns the School Management Committee (SMC) members and page section header.
     */
    public function index(): JsonResponse
    {
        $members = SchoolManagementMember::orderBy('id', 'asc')->get();

        $data = $members->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'designation' => $item->designation,
                'address' => $item->address,
                'phone' => $item->phone,
                'image_url' => $item->image_full_url,
            ];
        });

        return response()->json([
            'success' => true,
            'section' => [
                'eyebrow' => 'STATUTORY GOVERNANCE & COMPLIANCE',
                'title' => 'School Management Committee',
                'title_highlight' => 'Committee',
                'description' => 'The School Management Committee (SMC) ensures academic integrity, statutory compliance, student welfare, and continuous institutional growth at JRS International School.',
            ],
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
