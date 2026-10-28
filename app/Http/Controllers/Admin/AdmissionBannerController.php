<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBanner;
use App\Http\Requests\AdmissionBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdmissionBannerController extends Controller
{
    /**
     * Display the Admission Banner section management and live preview.
     */
    public function index()
    {
        $banner = AdmissionBanner::first();

        return view('admin.admission-banner.index', compact('banner'));
    }

    /**
     * Show the edit form for the Admission Banner.
     */
    public function edit($id)
    {
        $banner = AdmissionBanner::findOrFail($id);
        return view('admin.admission-banner.edit', compact('banner'));
    }

    /**
     * Update the Admission Banner.
     */
    public function update(AdmissionBannerRequest $request, $id)
    {
        $banner = AdmissionBanner::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/admission-banner');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Remove old uploaded image if stored in uploads
            if ($banner->image_path && Str::startsWith($banner->image_path, 'uploads/admission-banner/') && File::exists(public_path($banner->image_path))) {
                File::delete(public_path($banner->image_path));
            }

            $fileName = 'banner_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $validated['image_path'] = 'uploads/admission-banner/' . $fileName;
        } else {
            unset($validated['image_path']);
        }

        $banner->update($validated);

        flash()->success('Admission Banner section updated successfully!', 'Banner Updated');

        return redirect()->route('admin.admission-banner.index')
            ->with('success', 'Admission Banner section updated successfully!');
    }
}
