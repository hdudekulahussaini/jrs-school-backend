<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBanner;
use App\Http\Requests\AdmissionBannerRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdmissionBannerController extends Controller
{
    /**
     * Display the Admission Banner section management and live preview.
     */
    public function index()
    {
        $banners = AdmissionBanner::orderBy('id', 'desc')->get();
        $banner = AdmissionBanner::where('is_active', true)->first() ?? $banners->first();
        $totalCount = $banners->count();

        return view('admin.admission-banner.index', compact('banner', 'banners', 'totalCount'));
    }

    /**
     * Show the form for creating an admission banner.
     */
    public function create()
    {
        $banner = new AdmissionBanner();

        return view('admin.admission-banner.create', compact('banner'));
    }

    /**
     * Store a new admission banner.
     */
    public function store(AdmissionBannerRequest $request)
    {
        $banner = new AdmissionBanner();

        return $this->saveBanner($request, $banner);
    }

    /**
     * Redirect the resource show action to the editable banner details.
     */
    public function show($id)
    {
        return redirect()->route('admin.admission-banner.edit', $id);
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

        return $this->saveBanner($request, $banner);
    }

    /**
     * Persist validated banner fields and an optional uploaded image.
     */
    private function saveBanner(AdmissionBannerRequest $request, AdmissionBanner $banner)
    {
        $isNew = !$banner->exists;
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

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
        } elseif (empty($validated['image_path']) && $isNew) {
            unset($validated['image_path']);
        }

        // If newly created or updated is active, deactivate other banners
        if ($validated['is_active']) {
            AdmissionBanner::where('id', '!=', $banner->id ?? 0)->where('is_active', true)->update(['is_active' => false]);
        }

        $banner->fill($validated)->save();

        $message = $isNew
            ? 'Admission Banner section created successfully!'
            : 'Admission Banner section updated successfully!';
        flash()->success($message, $isNew ? 'Banner Created' : 'Banner Updated');

        return redirect()->route('admin.admission-banner.index')
            ->with('success', $message);
    }
}
