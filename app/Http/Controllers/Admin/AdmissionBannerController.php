<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBanner;
use App\Http\Requests\AdmissionBannerRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class AdmissionBannerController extends Controller
{
    /**
     * Ensure table exists and has clean schema without unused button fields.
     */
    protected function ensureTableExists(): void
    {
        if (!Schema::hasTable('admission_banners')) {
            Schema::create('admission_banners', function (Blueprint $table) {
                $table->id();
                $table->string('title')->default('Give Your Child A Strong Foundation');
                $table->string('title_highlight')->nullable()->default('For Tomorrow');
                $table->text('description')->nullable();
                $table->string('image_path')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('admission_banners', function (Blueprint $table) {
                $toDrop = [];
                foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $col) {
                    if (Schema::hasColumn('admission_banners', $col)) {
                        $toDrop[] = $col;
                    }
                }
                if (!empty($toDrop)) {
                    $table->dropColumn($toDrop);
                }
            });
        }
    }

    /**
     * Display the Admission Banner section management and live preview.
     */
    public function index()
    {
        $this->ensureTableExists();

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
        $this->ensureTableExists();

        $banner = new AdmissionBanner();

        return view('admin.admission-banner.create', compact('banner'));
    }

    /**
     * Store a new admission banner.
     */
    public function store(AdmissionBannerRequest $request)
    {
        $this->ensureTableExists();

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
        $this->ensureTableExists();

        $banner = AdmissionBanner::findOrFail($id);

        return view('admin.admission-banner.edit', compact('banner'));
    }

    /**
     * Update the Admission Banner.
     */
    public function update(AdmissionBannerRequest $request, $id)
    {
        $this->ensureTableExists();

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
            ? 'Successfully created.'
            : 'Successfully updated.';
        flash()->success($message);

        return redirect()->route('admin.admission-banner.index')
            ->with('success', $message);
    }

    /**
     * Delete an admission banner.
     */
    public function destroy($id)
    {
        $this->ensureTableExists();

        $banner = AdmissionBanner::findOrFail($id);

        if ($banner->image_path && Str::startsWith($banner->image_path, 'uploads/admission-banner/') && File::exists(public_path($banner->image_path))) {
            File::delete(public_path($banner->image_path));
        }

        $banner->delete();

        flash()->success('Successfully deleted.');

        return redirect()->route('admin.admission-banner.index')
            ->with('success', 'Successfully deleted.');
    }
}
