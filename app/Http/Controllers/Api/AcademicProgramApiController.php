<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use App\Http\Requests\AcademicProgramRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AcademicProgramApiController extends Controller
{
    /**
     * Public endpoint for React frontend: GET /api/academic-programs
     */
    public function getActivePrograms(): JsonResponse
    {
        $programs = AcademicProgram::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $programs->count(),
            'data' => $programs
        ], 200);
    }

    /**
     * REST endpoint: GET /api/admin/programs
     */
    public function index(Request $request): JsonResponse
    {
        $query = AcademicProgram::query();

        if ($request->has('active')) {
            $query->where('is_active', filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }

        $programs = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $programs->count(),
            'data' => $programs
        ], 200);
    }

    /**
     * REST endpoint: POST /api/admin/programs
     */
    public function store(AcademicProgramRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = $request->boolean('is_active', true);
        }

        // Parse highlights array
        if ($request->has('highlights')) {
            $validated['highlights'] = $this->parseHighlights($request->input('highlights'));
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/programs');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'program_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/programs/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $program = AcademicProgram::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Academic program created successfully.',
            'data' => $program
        ], 201);
    }

    /**
     * REST endpoint: GET /api/admin/programs/{id}
     */
    public function show($id): JsonResponse
    {
        $program = AcademicProgram::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Academic program not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $program
        ], 200);
    }

    /**
     * REST endpoint: PUT/PATCH/POST /api/admin/programs/{id}
     */
    public function update(AcademicProgramRequest $request, $id): JsonResponse
    {
        $program = AcademicProgram::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Academic program not found.'
            ], 404);
        }

        $validated = $request->validated();
        if ($request->has('is_active')) {
            $validated['is_active'] = $request->boolean('is_active');
        }

        if ($request->has('highlights')) {
            $validated['highlights'] = $this->parseHighlights($request->input('highlights'));
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/programs');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'program_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            if ($program->image_path && str_starts_with($program->image_path, 'uploads/programs/')) {
                $oldPath = public_path($program->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $validated['image_path'] = 'uploads/programs/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $program->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Academic program updated successfully.',
            'data' => $program
        ], 200);
    }

    /**
     * REST endpoint: PATCH /api/admin/programs/{id}/toggle
     */
    public function toggle($id): JsonResponse
    {
        $program = AcademicProgram::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Academic program not found.'
            ], 404);
        }

        $program->is_active = !$program->is_active;
        $program->save();

        return response()->json([
            'success' => true,
            'message' => 'Academic program status updated.',
            'is_active' => $program->is_active,
            'data' => $program
        ], 200);
    }

    /**
     * REST endpoint: DELETE /api/admin/programs/{id}
     */
    public function destroy($id): JsonResponse
    {
        $program = AcademicProgram::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Academic program not found.'
            ], 404);
        }

        if ($program->image_path && str_starts_with($program->image_path, 'uploads/programs/')) {
            $oldPath = public_path($program->image_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Academic program deleted successfully.'
        ], 200);
    }

    protected function parseHighlights($raw): array
    {
        if (is_array($raw)) {
            return array_values(array_filter(array_map('trim', $raw)));
        }

        if (is_string($raw)) {
            $lines = preg_split('/\r\n|\r|\n/', $raw);
            return array_values(array_filter(array_map('trim', $lines)));
        }

        return [];
    }
}
