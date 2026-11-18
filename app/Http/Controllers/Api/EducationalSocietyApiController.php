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
                'image_path' => $item->image_path,
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'data' => $data,
        ], 200);
    }
}
