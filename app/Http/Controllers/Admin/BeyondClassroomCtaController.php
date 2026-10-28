<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeyondClassroomCta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BeyondClassroomCtaController extends Controller
{
    /**
     * Display a listing of CTA banners.
     */
    public function index()
    {
        $ctas = BeyondClassroomCta::orderBy('id', 'desc')->paginate(10);
        $activeCta = BeyondClassroomCta::where('is_active', true)->first();
        $totalCount = BeyondClassroomCta::count();

        return view('admin.beyond.cta.index', compact('ctas', 'activeCta', 'totalCount'));
    }

    /**
     * Show the form for creating a new CTA banner.
     */
    public function create()
    {
        return view('admin.beyond.cta.create');
    }

    /**
     * Store a newly created CTA banner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(BeyondClassroomCta::validationRules());

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'beyond_cta_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/beyond'), $filename);
            $validated['image_path'] = '/uploads/beyond/' . $filename;
        } else {
            $validated['image_path'] = '/images/beyond/cta-banner.png';
        }

        unset($validated['image_file']);

        // If newly created is active, deactivate others
        if ($validated['is_active']) {
            BeyondClassroomCta::where('is_active', true)->update(['is_active' => false]);
        }

        BeyondClassroomCta::create($validated);
        flash()->success('Beyond Classroom CTA banner created successfully.');

        return redirect()->route('admin.beyond-classroom-cta.index')
            ->with('success', 'Beyond Classroom CTA banner created successfully.');
    }

    /**
     * Display the specified CTA banner.
     */
    public function show($id)
    {
        $cta = BeyondClassroomCta::findOrFail($id);
        return view('admin.beyond.cta.show', compact('cta'));
    }

    /**
     * Show the form for editing the specified CTA banner.
     */
    public function edit($id)
    {
        $cta = BeyondClassroomCta::findOrFail($id);
        return view('admin.beyond.cta.edit', compact('cta'));
    }

    /**
     * Update the specified CTA banner in storage.
     */
    public function update(Request $request, $id)
    {
        $cta = BeyondClassroomCta::findOrFail($id);
        $validated = $request->validate(BeyondClassroomCta::validationRules());

        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : false;

        if ($request->hasFile('image_file')) {
            // Delete old uploaded image if exists
            if ($cta->image_path && str_starts_with($cta->image_path, '/uploads/')) {
                $oldPath = public_path(ltrim($cta->image_path, '/'));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('image_file');
            $filename = 'beyond_cta_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/beyond'), $filename);
            $validated['image_path'] = '/uploads/beyond/' . $filename;
        }

        unset($validated['image_file']);

        if ($validated['is_active']) {
            BeyondClassroomCta::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $cta->update($validated);
        flash()->success('Beyond Classroom CTA banner updated successfully.');

        return redirect()->route('admin.beyond-classroom-cta.index')
            ->with('success', 'Beyond Classroom CTA banner updated successfully.');
    }

    /**
     * Remove the specified CTA banner from storage.
     */
    public function destroy($id)
    {
        $cta = BeyondClassroomCta::findOrFail($id);

        if ($cta->image_path && str_starts_with($cta->image_path, '/uploads/')) {
            $oldPath = public_path(ltrim($cta->image_path, '/'));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $cta->delete();
        flash()->info('Beyond Classroom CTA banner deleted successfully.');

        return redirect()->route('admin.beyond-classroom-cta.index')
            ->with('success', 'Beyond Classroom CTA banner deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle($id)
    {
        $cta = BeyondClassroomCta::findOrFail($id);
        $newStatus = !$cta->is_active;

        if ($newStatus) {
            BeyondClassroomCta::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $cta->is_active = $newStatus;
        $cta->save();

        return response()->json([
            'success' => true,
            'is_active' => $cta->is_active,
            'message' => 'Status updated successfully'
        ]);
    }
}
