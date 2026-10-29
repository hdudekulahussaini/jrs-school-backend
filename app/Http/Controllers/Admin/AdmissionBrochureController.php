<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionBrochure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdmissionBrochureController extends Controller
{
    /**
     * Display the Admission Brochure upload and management page.
     */
    public function index()
    {
        $brochure = AdmissionBrochure::first();
        if (!$brochure) {
            $brochure = AdmissionBrochure::create([
                'title' => 'JRS International School Brochure',
                'brochure_link' => 'https://jrsinternationalschooluppal.com/wp-content/uploads/2022/01/Brochure-2020-JRS.pdf',
                'is_active' => true,
            ]);
        }

        return view('admin.admissions.brochure.index', compact('brochure'));
    }

    /**
     * Update the Admission Brochure (PDF file or Link).
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:190',
            'brochure_file' => 'nullable|file|mimes:pdf|max:30720', // max 30MB
            'brochure_link' => 'nullable|url|max:500',
            'remove_pdf' => 'nullable|boolean',
        ]);

        $brochure = AdmissionBrochure::first();
        if (!$brochure) {
            $brochure = new AdmissionBrochure();
            $brochure->title = 'JRS International School Brochure';
        }

        if ($request->filled('title')) {
            $brochure->title = $request->input('title');
        }

        $brochure->brochure_link = $request->input('brochure_link');

        // Handle removing existing PDF
        if ($request->boolean('remove_pdf')) {
            if ($brochure->pdf_path && Str::startsWith($brochure->pdf_path, '/uploads/')) {
                $filePath = public_path(ltrim($brochure->pdf_path, '/'));
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            $brochure->pdf_path = null;
            $brochure->file_size = null;
        }

        // Handle new PDF upload
        if ($request->hasFile('brochure_file')) {
            $file = $request->file('brochure_file');
            if ($file->isValid()) {
                // Remove previous file if exists
                if ($brochure->pdf_path && Str::startsWith($brochure->pdf_path, '/uploads/')) {
                    $oldPath = public_path(ltrim($brochure->pdf_path, '/'));
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $uploadDir = public_path('uploads/admissions/brochure');
                if (!File::exists($uploadDir)) {
                    File::makeDirectory($uploadDir, 0755, true);
                }

                $originalName = $file->getClientOriginalName();
                $filename = 'jrs_brochure_' . time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.pdf';
                $fileBytes = $file->getSize();

                // Format file size
                $formattedSize = $fileBytes >= 1048576 
                    ? number_format($fileBytes / 1048576, 2) . ' MB' 
                    : number_format($fileBytes / 1024, 1) . ' KB';

                $file->move($uploadDir, $filename);

                $brochure->pdf_path = '/uploads/admissions/brochure/' . $filename;
                $brochure->file_size = $formattedSize;
            }
        }

        $brochure->save();

        if (function_exists('flash')) {
            flash()->success('Admission brochure updated successfully.', 'Brochure Updated');
        }

        return redirect()->route('admin.admission-brochure.index')
            ->with('success', 'Admission brochure updated successfully.');
    }
}
