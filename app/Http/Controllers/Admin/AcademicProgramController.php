<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use App\Http\Requests\AcademicProgramRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AcademicProgramController extends Controller
{
    /**
     * [READ - Index] Listing of all academic programs.
     */
    public function index(Request $request)
    {
        $query = AcademicProgram::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('subtitle', 'like', "%{$term}%")
                  ->orWhere('stage_badge', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $programs = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = AcademicProgram::count();
        $activeCount = AcademicProgram::where('is_active', true)->count();
        $inactiveCount = AcademicProgram::where('is_active', false)->count();

        return view('admin.programs.index', compact('programs', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new academic program.
     */
    public function create()
    {
        $nextOrder = (AcademicProgram::max('sort_order') ?? 0) + 1;
        return view('admin.programs.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new academic program.
     */
    public function store(AcademicProgramRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['button_text'] = $request->filled('button_text') ? $request->input('button_text') : null;
        $validated['button_url'] = $request->filled('button_url') ? $request->input('button_url') : null;

        // Parse highlights array
        $validated['highlights'] = $this->parseHighlights($request->input('highlights'));

        // Handle Image Upload
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

        AcademicProgram::create($validated);

        flash()->success('Academic Program created successfully.', 'Program Created');

        return redirect()->route('admin.programs.index')
            ->with('success', 'Academic Program created successfully.');
    }

    /**
     * [READ - Show] Display academic program details with official card layout.
     */
    public function show($id)
    {
        $program = AcademicProgram::findOrFail($id);
        return view('admin.programs.show', compact('program'));
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $program = AcademicProgram::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * [UPDATE - Action] Save updates to an existing academic program.
     */
    public function update(AcademicProgramRequest $request, $id)
    {
        $program = AcademicProgram::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['button_text'] = $request->filled('button_text') ? $request->input('button_text') : null;
        $validated['button_url'] = $request->filled('button_url') ? $request->input('button_url') : null;

        // Parse highlights array
        $validated['highlights'] = $this->parseHighlights($request->input('highlights'));

        // Handle Image Replacement
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/programs');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'program_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            // Clean up old uploaded file if local
            if ($program->image_path && str_starts_with($program->image_path, 'uploads/programs/')) {
                $oldPath = public_path($program->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $validated['image_path'] = 'uploads/programs/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        } elseif ($request->has('remove_image')) {
            if ($program->image_path && str_starts_with($program->image_path, 'uploads/programs/')) {
                $oldPath = public_path($program->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $validated['image_path'] = null;
        }

        $program->update($validated);

        flash()->success('Academic Program updated successfully.', 'Program Updated');

        return redirect()->route('admin.programs.index')
            ->with('success', 'Academic Program updated successfully.');
    }

    /**
     * [STATUS TOGGLE] Quick switch between active and inactive.
     */
    public function toggle($id)
    {
        $program = AcademicProgram::findOrFail($id);
        $program->is_active = !$program->is_active;
        $program->save();

        if ($program->is_active) {
            flash()->success('Academic Program status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Academic Program status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $program->is_active,
                'message' => 'Status changed to ' . ($program->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Academic Program status changed to ' . ($program->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * [DELETE] Remove academic program and its uploaded asset.
     */
    public function destroy($id)
    {
        $program = AcademicProgram::findOrFail($id);

        if ($program->image_path && str_starts_with($program->image_path, 'uploads/programs/')) {
            $oldPath = public_path($program->image_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $program->delete();

        flash()->info('Academic Program deleted successfully.', 'Program Removed');

        return redirect()->route('admin.programs.index')
            ->with('success', 'Academic Program deleted successfully.');
    }

    /**
     * Parse highlights input (can be array or newline-separated string).
     */
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
