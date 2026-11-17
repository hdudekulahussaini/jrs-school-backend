<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionPopupRequest;
use App\Models\AdmissionPopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdmissionPopupController extends Controller
{
    /**
     * Ensure table exists and default data is seeded.
     */
    protected function ensureTableExists(): void
    {
        if (!Schema::hasTable('admission_popups')) {
            Schema::create('admission_popups', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->boolean('is_active')->default(true);
                $table->string('image_path')->nullable();
                $table->string('badge_text')->default('ADMISSIONS OPEN');
                $table->string('cbse_affiliation_text')->default('CBSE AFFILIATION: 3630478 • SCHOOL CODE: 56725');
                $table->string('school_name')->default('JRS International School');
                $table->string('school_location')->default('Narapally, Near Uppal, Hyderabad');
                $table->string('academic_year_badge')->default('Academic Year 2027 – 2028');
                $table->string('title_prefix')->default('Admissions Open For');
                $table->string('academic_year_highlight')->default('2027 – 2028');
                $table->text('description')->nullable();
                $table->json('features')->nullable();
                $table->string('phone_number')->default('+91 92814 09674');
                $table->timestamps();
            });
        } else {
            $columnsToDrop = [];
            foreach (['primary_button_url', 'primary_button_text', 'secondary_button_text'] as $col) {
                if (Schema::hasColumn('admission_popups', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                Schema::table('admission_popups', function (\Illuminate\Database\Schema\Blueprint $table) use ($columnsToDrop) {
                    $table->dropColumn($columnsToDrop);
                });
            }
        }

        if (AdmissionPopup::count() === 0) {
            AdmissionPopup::create([
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
            ]);
        }
    }

    /**
     * Display Admission Popup settings and live preview.
     */
    public function index()
    {
        $this->ensureTableExists();

        $popup = AdmissionPopup::first();

        return view('admin.admission-popup.index', compact('popup'));
    }

    /**
     * Update Admission Popup settings.
     */
    public function update(AdmissionPopupRequest $request)
    {
        $this->ensureTableExists();

        $popup = AdmissionPopup::first();
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        // Clean features array (remove empty rows)
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = array_values(array_filter(array_map('trim', $data['features'])));
        } else {
            $data['features'] = [];
        }

        // Handle Image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/admission-popup');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Delete old file if stored locally
            if ($popup && $popup->image_path && Str::startsWith($popup->image_path, 'uploads/admission-popup/')) {
                $oldFile = public_path($popup->image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $filename = 'popup_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['image_path'] = 'uploads/admission-popup/' . $filename;
        } elseif ($request->filled('image_path')) {
            $data['image_path'] = $request->input('image_path');
        } else {
            unset($data['image_path']);
        }

        if ($popup) {
            $popup->update($data);
        } else {
            AdmissionPopup::create($data);
        }

        flash()->success('Admission Popup updated successfully.', 'Popup Updated');

        return redirect()->route('admin.admission-popup.index')
            ->with('success', 'Admission Popup updated successfully.');
    }

    /**
     * Quick status toggle (Active <-> Inactive).
     */
    public function toggle()
    {
        $this->ensureTableExists();

        $popup = AdmissionPopup::first();
        if ($popup) {
            $popup->is_active = !$popup->is_active;
            $popup->save();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $popup ? $popup->is_active : false,
                'message' => 'Popup status changed successfully.',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Admission Popup status changed successfully.');
    }
}
