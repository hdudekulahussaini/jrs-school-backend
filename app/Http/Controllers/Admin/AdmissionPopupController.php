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
                $table->timestamps();
            });
        }

        if (AdmissionPopup::count() === 0) {
            AdmissionPopup::create([
                'is_active' => true,
                'image_path' => null,
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
        $data = [
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle Image removal
        if ($request->boolean('remove_image')) {
            if ($popup && $popup->image_path && Str::startsWith($popup->image_path, 'uploads/admission-popup/')) {
                $oldFile = public_path($popup->image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
            $data['image_path'] = null;
        }
        // Handle Image upload
        elseif ($request->hasFile('image')) {
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
        }

        if ($popup) {
            $popup->update($data);
        } else {
            AdmissionPopup::create($data);
        }

        flash()->success('Admission Popup updated successfully.');

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

        flash()->success('Admission Popup status changed successfully.');

        return redirect()->back()
            ->with('success', 'Admission Popup status changed successfully.');
    }
}
