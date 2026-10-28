<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicJourneyRequest;
use App\Models\AcademicJourney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AcademicJourneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AcademicJourney::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('age_group', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $journeys = $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->paginate(10)->withQueryString();
        $totalCount = AcademicJourney::count();
        $activeCount = AcademicJourney::where('is_active', true)->count();
        $inactiveCount = AcademicJourney::where('is_active', false)->count();

        return view('admin.academic_journeys.index', compact('journeys', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextOrder = (AcademicJourney::max('sort_order') ?? 0) + 1;
        return view('admin.academic_journeys.create', compact('nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicJourneyRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('uploads/journey');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $filename = 'journey_' . time() . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            $data['image_path'] = 'uploads/journey/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        AcademicJourney::create($data);

        flash()->success('Academic Journey card created successfully.', 'Journey Created');

        return redirect()->route('admin.academic-journeys.index')->with('success', 'Academic Journey card created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $journey = AcademicJourney::findOrFail($id);
        return view('admin.academic_journeys.show', compact('journey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $journey = AcademicJourney::findOrFail($id);
        return view('admin.academic_journeys.edit', compact('journey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicJourneyRequest $request, int $id)
    {
        $journey = AcademicJourney::findOrFail($id);
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            // Delete old uploaded image if exists and located in uploads/
            if (!empty($journey->image_path) && Str::startsWith($journey->image_path, 'uploads/') && File::exists(public_path($journey->image_path))) {
                File::delete(public_path($journey->image_path));
            }

            $image = $request->file('image');
            $destinationPath = public_path('uploads/journey');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $filename = 'journey_' . time() . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            $data['image_path'] = 'uploads/journey/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $journey->update($data);

        flash()->success('Academic Journey card updated successfully.', 'Journey Updated');

        return redirect()->route('admin.academic-journeys.index')->with('success', 'Academic Journey card updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $journey = AcademicJourney::findOrFail($id);

        if (!empty($journey->image_path) && Str::startsWith($journey->image_path, 'uploads/') && File::exists(public_path($journey->image_path))) {
            File::delete(public_path($journey->image_path));
        }

        $journey->delete();

        flash()->info('Academic Journey card deleted successfully.', 'Journey Removed');

        return redirect()->route('admin.academic-journeys.index')->with('success', 'Academic Journey card deleted successfully.');
    }

    /**
     * Toggle the active status.
     */
    public function toggle(int $id)
    {
        $journey = AcademicJourney::findOrFail($id);
        $journey->is_active = !$journey->is_active;
        $journey->save();

        if ($journey->is_active) {
            flash()->success("Status for '{$journey->title}' changed to Active.", 'Status Updated');
        } else {
            flash()->warning("Status for '{$journey->title}' changed to Inactive.", 'Status Inactive');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $journey->is_active,
                'message' => "Status for '{$journey->title}' changed to " . ($journey->is_active ? 'Active' : 'Inactive')
            ]);
        }

        return redirect()->back()->with('success', "Status for '{$journey->title}' updated to " . ($journey->is_active ? 'Active' : 'Inactive') . '.');
    }
}
