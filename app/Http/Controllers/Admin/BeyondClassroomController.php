<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeyondClassroom;
use App\Http\Requests\BeyondClassroomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BeyondClassroomController extends Controller
{
    /**
     * [READ - Index] Listing of all beyond classroom activities.
     */
    public function index(Request $request)
    {
        $query = BeyondClassroom::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('category', 'like', "%{$term}%")
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

        $activities = $query->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $totalCount = BeyondClassroom::count();
        $activeCount = BeyondClassroom::where('is_active', true)->count();
        $inactiveCount = BeyondClassroom::where('is_active', false)->count();

        return view('admin.beyond.index', compact('activities', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * [CREATE - Form] Display form to create a new beyond classroom activity.
     */
    public function create()
    {
        $nextOrder = (BeyondClassroom::max('sort_order') ?? 0) + 1;
        return view('admin.beyond.create', compact('nextOrder'));
    }

    /**
     * [CREATE - Store] Persist a new beyond classroom activity.
     */
    public function store(BeyondClassroomRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['sort_order'] = $request->input('sort_order', (BeyondClassroom::max('sort_order') ?? 0) + 1);
        $validated['color'] = $request->filled('color') ? $request->input('color') : '#15803d';
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : 'bi bi-trophy-fill';

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/beyond');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'beyond_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['image_path'] = 'uploads/beyond/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        BeyondClassroom::create($validated);

        flash()->success('Beyond Classroom activity created successfully.', 'Activity Created');

        return redirect()->route('admin.beyond-classrooms.index')
            ->with('success', 'Beyond Classroom activity created successfully.');
    }

    /**
     * [READ - Show] Display activity details.
     */
    public function show($id)
    {
        $activity = BeyondClassroom::findOrFail($id);
        return view('admin.beyond.show', compact('activity'));
    }

    /**
     * [UPDATE - Form] Display edit form.
     */
    public function edit($id)
    {
        $activity = BeyondClassroom::findOrFail($id);
        return view('admin.beyond.edit', compact('activity'));
    }

    /**
     * [UPDATE - Action] Save updates to an existing activity.
     */
    public function update(BeyondClassroomRequest $request, $id)
    {
        $activity = BeyondClassroom::findOrFail($id);
        $validated = $request->validated();

        if ($request->has('is_active')) {
            $validated['is_active'] = $request->boolean('is_active');
        }
        if ($request->has('sort_order')) {
            $validated['sort_order'] = $request->input('sort_order');
        }
        $validated['color'] = $request->filled('color') ? $request->input('color') : $activity->color;
        $validated['icon'] = $request->filled('icon') ? $request->input('icon') : $activity->icon;

        // Handle Image Replacement
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/beyond');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'beyond_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            // Clean up old uploaded file if local
            if ($activity->image_path && str_starts_with($activity->image_path, 'uploads/beyond/')) {
                $oldPath = public_path($activity->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $validated['image_path'] = 'uploads/beyond/' . $filename;
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        } elseif ($request->has('remove_image')) {
            if ($activity->image_path && str_starts_with($activity->image_path, 'uploads/beyond/')) {
                $oldPath = public_path($activity->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $validated['image_path'] = null;
        }

        $activity->update($validated);

        flash()->success('Beyond Classroom activity updated successfully.', 'Activity Updated');

        return redirect()->route('admin.beyond-classrooms.index')
            ->with('success', 'Beyond Classroom activity updated successfully.');
    }

    /**
     * [STATUS TOGGLE] Quick switch between active and inactive.
     */
    public function toggle($id)
    {
        $activity = BeyondClassroom::findOrFail($id);
        $activity->is_active = !$activity->is_active;
        $activity->save();

        if ($activity->is_active) {
            flash()->success('Beyond Classroom status changed to Active.', 'Status Updated');
        } else {
            flash()->warning('Beyond Classroom status changed to Inactive.', 'Status Inactive');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $activity->is_active,
                'message' => 'Status changed to ' . ($activity->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Beyond Classroom activity status changed to ' . ($activity->is_active ? 'Active' : 'Inactive') . '.');
    }

    /**
     * [DELETE] Remove activity and its uploaded asset.
     */
    public function destroy($id)
    {
        $activity = BeyondClassroom::findOrFail($id);

        if ($activity->image_path && str_starts_with($activity->image_path, 'uploads/beyond/')) {
            $oldPath = public_path($activity->image_path);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $activity->delete();

        flash()->info('Beyond Classroom activity deleted successfully.', 'Activity Removed');

        return redirect()->route('admin.beyond-classrooms.index')
            ->with('success', 'Beyond Classroom activity deleted successfully.');
    }
}
