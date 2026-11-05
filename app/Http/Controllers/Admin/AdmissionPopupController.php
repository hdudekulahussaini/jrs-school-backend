<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionPopupRequest;
use App\Models\AdmissionPopup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdmissionPopupController extends Controller
{
    /**
     * List admission popups.
     */
    public function index()
    {
        $popups = AdmissionPopup::orderByDesc('id')->paginate(15);

        return view('admin.admission-popup.index', compact('popups'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        if (AdmissionPopup::query()->exists()) {
            return redirect()->route('admin.admission-popup.index')
                ->withErrors(['popup' => 'Only one Admission Popup card is allowed. Edit or delete the existing card first.']);
        }

        return view('admin.admission-popup.form', [
            'popup' => new AdmissionPopup($this->defaultAttributes()),
        ]);
    }

    /**
     * Store a new admission popup.
     */
    public function store(AdmissionPopupRequest $request)
    {
        if (AdmissionPopup::query()->exists()) {
            return redirect()->route('admin.admission-popup.index')
                ->withErrors(['popup' => 'Only one Admission Popup card is allowed. Edit or delete the existing card first.']);
        }

        $popup = new AdmissionPopup;
        $this->savePopup($request, $popup);

        return redirect()->route('admin.admission-popup.edit', $popup->id)
            ->with('success', 'Admission Popup created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $popup = AdmissionPopup::findOrFail($id);

        return view('admin.admission-popup.form', compact('popup'));
    }

    /**
     * Update an admission popup.
     */
    public function update(AdmissionPopupRequest $request, $id = null)
    {
        $popup = $id
            ? AdmissionPopup::findOrFail($id)
            : AdmissionPopup::first() ?? new AdmissionPopup($this->defaultAttributes());

        $this->savePopup($request, $popup);

        return redirect($id
            ? route('admin.admission-popup.edit', $popup->id)
            : route('admin.admission-popup.index'))
            ->with('success', 'Admission Popup updated successfully.');
    }

    /**
     * Enable or disable an admission popup.
     */
    public function toggle($id = null)
    {
        $popup = $id
            ? AdmissionPopup::findOrFail($id)
            : AdmissionPopup::firstOrFail();

        $popup->is_active = !$popup->is_active;

        DB::transaction(function () use ($popup): void {
            if ($popup->is_active) {
                AdmissionPopup::where('id', '!=', $popup->id)->update(['is_active' => false]);
            }

            $popup->save();
        });

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $popup->is_active,
                'message' => 'Popup status changed successfully.',
            ]);
        }

        return redirect()->route('admin.admission-popup.index')
            ->with('success', 'Admission Popup status changed successfully.');
    }

    /**
     * Delete an admission popup.
     */
    public function destroy($id)
    {
        $popup = AdmissionPopup::findOrFail($id);
        $imagePath = $popup->image_path;

        DB::transaction(function () use ($popup): void {
            $popup->delete();
        });

        if ($imagePath && Str::startsWith($imagePath, 'uploads/admission-popup/')) {
            $file = public_path($imagePath);
            if (File::exists($file)) {
                File::delete($file);
            }
        }

        return redirect()->route('admin.admission-popup.index')
            ->with('success', 'Admission Popup deleted successfully.');
    }

    private function savePopup(AdmissionPopupRequest $request, AdmissionPopup $popup): void
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $features = $data['features'] ?? [];
        $data['features'] = array_values(array_filter(array_map('trim', $features)));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/admission-popup');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $filename = 'popup_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);

            if ($popup->image_path && Str::startsWith($popup->image_path, 'uploads/admission-popup/')) {
                $oldFile = public_path($popup->image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $data['image_path'] = 'uploads/admission-popup/' . $filename;
        } elseif ($request->filled('image_path')) {
            $data['image_path'] = $request->input('image_path');
        } else {
            unset($data['image_path']);
        }

        DB::transaction(function () use ($popup, $data): void {
            if ($data['is_active']) {
                AdmissionPopup::where('id', '!=', $popup->id ?? 0)->update(['is_active' => false]);
            }

            $popup->fill($data);
            $popup->save();
        });
    }

    private function defaultAttributes(): array
    {
        return [
            'is_active' => true,
            'image_path' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1200&auto=format&fit=crop',
            'badge_text' => 'ADMISSIONS OPEN',
            'cbse_affiliation_text' => 'CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725',
            'school_name' => 'JRS International School',
            'school_location' => 'Narapally, Near Uppal, Hyderabad',
            'academic_year_badge' => 'Academic Year 2027 – 2028',
            'title_prefix' => 'Admissions Open For',
            'academic_year_highlight' => '2027 – 2028',
            'description' => 'Enrolling students from Nursery to Grade XII (Admissions open for 11th & 12th Standard also). Give your child the foundation for academic excellence, character development, and global leadership.',
            'features' => [
                'CBSE Curriculum with experiential, inquiry-based learning',
                'STEM, Robotics & Cognospace innovation labs',
                'World-Class Sports & Co-curricular clubs',
                'Safe GPS-Enabled Fleet & 100% CCTV secured campus',
            ],
            'phone_number' => '+91 92814 09674',
        ];
    }
}
