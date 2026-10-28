<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AmenityCta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AmenityCtaController extends Controller
{
    /**
     * Display a listing of Amenities CTA banners.
     */
    public function index()
    {
        $ctas = AmenityCta::orderBy('id', 'desc')->get();
        $activeCta = AmenityCta::where('is_active', true)->first();
        $totalCount = $ctas->count();

        return view('admin.amenities.cta.index', compact('ctas', 'activeCta', 'totalCount'));
    }

    /**
     * Show the form for creating a new Amenities CTA banner.
     */
    public function create()
    {
        return view('admin.amenities.cta.create');
    }

    /**
     * Store a newly created CTA banner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(AmenityCta::validationRules());
        $isActive = $request->has('is_active');
        $validated['is_active'] = $isActive;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'amenity_cta_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/amenities'), $filename);
            $validated['image_path'] = '/uploads/amenities/' . $filename;
        } else {
            $validated['image_path'] = '/images/amenities/cta-banner.png';
        }

        unset($validated['image_file']);

        if ($isActive) {
            AmenityCta::where('is_active', true)->update(['is_active' => false]);
        }

        AmenityCta::create($validated);
        flash()->success('Amenities CTA banner created successfully.');

        return redirect()->route('admin.amenities-cta.index')
            ->with('success', 'Amenities CTA banner created successfully.');
    }

    /**
     * Show the form for editing the specified CTA banner.
     */
    public function edit($id)
    {
        $cta = AmenityCta::findOrFail($id);
        return view('admin.amenities.cta.edit', compact('cta'));
    }

    /**
     * Update the specified CTA banner in storage.
     */
    public function update(Request $request, $id)
    {
        $cta = AmenityCta::findOrFail($id);
        $validated = $request->validate(AmenityCta::validationRules());
        $isActive = $request->has('is_active');
        $validated['is_active'] = $isActive;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'amenity_cta_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/amenities'), $filename);
            $validated['image_path'] = '/uploads/amenities/' . $filename;
        }

        unset($validated['image_file']);

        if ($isActive) {
            AmenityCta::where('id', '!=', $cta->id)->update(['is_active' => false]);
        }

        $cta->update($validated);
        flash()->success('Amenities CTA banner updated successfully.');

        return redirect()->route('admin.amenities-cta.index')
            ->with('success', 'Amenities CTA banner updated successfully.');
    }

    /**
     * Remove the specified CTA banner from storage.
     */
    public function destroy($id)
    {
        $cta = AmenityCta::findOrFail($id);
        $cta->delete();
        flash()->info('Amenities CTA banner deleted successfully.');

        return redirect()->route('admin.amenities-cta.index')
            ->with('success', 'Amenities CTA banner deleted successfully.');
    }

    /**
     * Toggle the active status of a CTA banner.
     */
    public function toggle($id)
    {
        $cta = AmenityCta::findOrFail($id);

        if (!$cta->is_active) {
            AmenityCta::where('is_active', true)->update(['is_active' => false]);
            $cta->is_active = true;
            flash()->success('Banner activated successfully.');
        } else {
            $cta->is_active = false;
            flash()->warning('Banner deactivated.');
        }

        $cta->save();

        return redirect()->back()->with('success', 'Status toggled successfully.');
    }
}
