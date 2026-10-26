<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Http\Requests\FacilityRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FacilityApiController extends Controller
{
    /**
     * Public endpoint for React frontend: GET /api/facilities, /api/amenities
     */
    public function getActiveFacilities(): JsonResponse
    {
        $facilities = Facility::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active campus amenities retrieved successfully',
            'count' => $facilities->count(),
            'total' => $facilities->count(),
            'data' => $facilities
        ], 200);
    }

    /**
     * Public endpoint for dedicated Amenities page: GET /api/amenities-page
     */
    public function getPageData(): JsonResponse
    {
        $amenities = Facility::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Campus amenities page data retrieved successfully',
            'page' => [
                'badge' => 'OUR CAMPUS',
                'title' => 'State-Of-The-Art Facilities',
                'highlight_title' => 'Facilities',
                'subtitle' => 'The campus boasts of the following unique facilities to make this happen:'
            ],
            'count' => $amenities->count(),
            'total' => $amenities->count(),
            'data' => $amenities
        ], 200);
    }

    /**
     * REST endpoint: GET /api/admin/facilities
     */
    public function index(Request $request): JsonResponse
    {
        $query = Facility::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $facilities = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $facilities->count(),
            'data' => $facilities
        ], 200);
    }

    /**
     * REST endpoint: POST /api/admin/facilities
     */
    public function store(FacilityRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/facilities');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'facility_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/facilities/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $facility = Facility::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Facility created successfully',
            'data' => $facility
        ], 201);
    }

    /**
     * REST endpoint: GET /api/admin/facilities/{id}
     */
    public function show($id): JsonResponse
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $facility
        ], 200);
    }

    /**
     * REST endpoint: PUT/POST /api/admin/facilities/{id}
     */
    public function update(FacilityRequest $request, $id): JsonResponse
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found'
            ], 404);
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deletePhysicalImage($facility->image_path);
            $file = $request->file('image');
            $uploadDir = public_path('uploads/facilities');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'facility_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/facilities/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $facility->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Facility updated successfully',
            'data' => $facility
        ], 200);
    }

    /**
     * REST endpoint: PATCH /api/admin/facilities/{id}/toggle
     */
    public function toggle($id): JsonResponse
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found'
            ], 404);
        }

        $facility->is_active = !$facility->is_active;
        $facility->save();

        return response()->json([
            'success' => true,
            'message' => 'Facility status toggled to ' . ($facility->is_active ? 'active' : 'inactive'),
            'is_active' => $facility->is_active,
            'data' => $facility
        ], 200);
    }

    /**
     * REST endpoint: DELETE /api/admin/facilities/{id}
     */
    public function destroy($id): JsonResponse
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json([
                'success' => false,
                'message' => 'Facility not found'
            ], 404);
        }

        $this->deletePhysicalImage($facility->image_path);
        $facility->delete();

        return response()->json([
            'success' => true,
            'message' => 'Facility deleted successfully'
        ], 200);
    }

    private function deletePhysicalImage(?string $path): void
    {
        if (!empty($path) && !str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
