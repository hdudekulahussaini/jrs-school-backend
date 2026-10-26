<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EducationalSocietyMember;
use Illuminate\Http\JsonResponse;

class EducationalSocietyApiController extends Controller
{
    /**
     * Public GET endpoint for React frontend: GET /api/educational-society
     * Returns the Educational Society Managing Committee members and page section header.
     */
    public function index(): JsonResponse
    {
        $members = EducationalSocietyMember::orderBy('id', 'asc')->get();

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
                'eyebrow' => 'GOVERNING BODY & LEADERSHIP',
                'title' => 'Managing Committee',
                'title_highlight' => 'Committee',
                'description' => 'Distinguished governing body steering the vision, academic excellence, statutory compliance, and strategic growth of JRS International School.',
            ],
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
