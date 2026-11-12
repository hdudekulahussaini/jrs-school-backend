<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionPopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdmissionPopupController extends Controller
{
    public function index()
    {
        return view('admin.admission-popup.index', [
            'popup' => AdmissionPopup::first(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $uploadDir = public_path('uploads/admission-popup');
        if (!File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $file = $request->file('image');
        $filename = 'popup_' . Str::uuid() . '.' . $file->extension();
        $file->move($uploadDir, $filename);

        $popup = AdmissionPopup::first() ?? new AdmissionPopup;
        $oldImagePath = $popup->image_path;
        $popup->image_path = 'uploads/admission-popup/' . $filename;
        $popup->save();

        $this->deleteStoredImage($oldImagePath);

        return redirect()->route('admin.admission-popup.index')
            ->with('success', 'Admission Popup image uploaded successfully.');
    }

    public function destroyImage()
    {
        $popup = AdmissionPopup::first();
        if ($popup) {
            $imagePath = $popup->image_path;
            $popup->delete();
            $this->deleteStoredImage($imagePath);
        }

        return redirect()->route('admin.admission-popup.index')
            ->with('success', 'Admission Popup image deleted successfully.');
    }

    private function deleteStoredImage(?string $path): void
    {
        $directory = 'uploads/admission-popup/';
        if (!Str::startsWith($path ?? '', $directory)) {
            return;
        }

        $filename = Str::after($path, $directory);
        if ($filename === '' || basename($filename) !== $filename || in_array($filename, ['.', '..'], true)) {
            return;
        }

        $fullPath = public_path($directory . $filename);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
