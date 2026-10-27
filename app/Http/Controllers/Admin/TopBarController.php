<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TopBarController extends Controller
{
    /**
     * Display the Top Bar management dashboard view.
     */
    public function index()
    {
        $topBar = TopBar::first();

        if (!$topBar) {
            $topBar = TopBar::create([
                'phone' => '+91 915740 43210',
                'phone_href' => 'tel:+9191574043210',
                'email' => 'info@jrsinternationalschool.com',
                'email_href' => 'mailto:info@jrsinternationalschool.com',
                'cbse_affiliation_text' => 'CBSE Affiliated School',
                'cbse_affiliation_code' => 'Affiliation No. 3630372',
                'mandatory_disclosure_title' => 'Mandatory Disclosure',
                'mandatory_disclosure_url' => 'https://jrsinternationalschool.com/mandatory-disclosure.pdf',
                'prospectus_title' => 'School Prospectus',
                'prospectus_url' => 'https://jrsinternationalschool.com/school-prospectus.pdf',
                'is_active' => true,
            ]);
        }

        return view('admin.top-bar.index', compact('topBar'));
    }

    /**
     * Update the Top Bar settings and uploaded documents.
     */
    public function update(Request $request)
    {
        $topBar = TopBar::first();
        if (!$topBar) {
            $topBar = new TopBar();
        }

        $validated = $request->validate(TopBar::validationRules());
        $validated['is_active'] = true;

        // Automatic phone_href and email_href if not filled
        if (empty($validated['phone_href'])) {
            $digits = preg_replace('/[^0-9+]/', '', $validated['phone']);
            $validated['phone_href'] = 'tel:' . $digits;
        }

        if (empty($validated['email_href'])) {
            $validated['email_href'] = 'mailto:' . $validated['email'];
        }

        // Retain or set standard titles
        $validated['mandatory_disclosure_title'] = $topBar->mandatory_disclosure_title ?: 'Mandatory Disclosure';
        $validated['prospectus_title'] = $topBar->prospectus_title ?: 'School Prospectus';

        // Keep affiliation code if already stored
        if (!isset($validated['cbse_affiliation_code'])) {
            $validated['cbse_affiliation_code'] = $topBar->cbse_affiliation_code;
        }

        $uploadDir = public_path('uploads/documents');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // Handle Mandatory Disclosure (URL or Upload Option)
        $mandatoryType = $request->input('mandatory_disclosure_type', 'file');
        if ($mandatoryType === 'url') {
            // Delete previous file if switching to external URL
            if ($topBar->mandatory_disclosure_file && File::exists(public_path(ltrim($topBar->mandatory_disclosure_file, '/')))) {
                File::delete(public_path(ltrim($topBar->mandatory_disclosure_file, '/')));
            }
            $validated['mandatory_disclosure_file'] = null;
            $validated['mandatory_disclosure_url'] = $request->input('mandatory_disclosure_url');
        } else {
            // File upload option
            if ($request->hasFile('mandatory_disclosure_file_upload')) {
                if ($topBar->mandatory_disclosure_file && File::exists(public_path(ltrim($topBar->mandatory_disclosure_file, '/')))) {
                    File::delete(public_path(ltrim($topBar->mandatory_disclosure_file, '/')));
                }

                $file = $request->file('mandatory_disclosure_file_upload');
                $filename = 'mandatory_disclosure_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);
                $validated['mandatory_disclosure_file'] = '/uploads/documents/' . $filename;
            }
            // Clear URL when active file exists
            if (!empty($validated['mandatory_disclosure_file']) || !empty($topBar->mandatory_disclosure_file)) {
                $validated['mandatory_disclosure_url'] = null;
            }
        }

        // Handle School Prospectus (URL or Upload Option)
        $prospectusType = $request->input('prospectus_type', 'file');
        if ($prospectusType === 'url') {
            // Delete previous file if switching to external URL
            if ($topBar->prospectus_file && File::exists(public_path(ltrim($topBar->prospectus_file, '/')))) {
                File::delete(public_path(ltrim($topBar->prospectus_file, '/')));
            }
            $validated['prospectus_file'] = null;
            $validated['prospectus_url'] = $request->input('prospectus_url');
        } else {
            // File upload option
            if ($request->hasFile('prospectus_file_upload')) {
                if ($topBar->prospectus_file && File::exists(public_path(ltrim($topBar->prospectus_file, '/')))) {
                    File::delete(public_path(ltrim($topBar->prospectus_file, '/')));
                }

                $file = $request->file('prospectus_file_upload');
                $filename = 'prospectus_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);
                $validated['prospectus_file'] = '/uploads/documents/' . $filename;
            }
            // Clear URL when active file exists
            if (!empty($validated['prospectus_file']) || !empty($topBar->prospectus_file)) {
                $validated['prospectus_url'] = null;
            }
        }

        unset($validated['mandatory_disclosure_type']);
        unset($validated['mandatory_disclosure_file_upload']);
        unset($validated['prospectus_type']);
        unset($validated['prospectus_file_upload']);

        $topBar->fill($validated);
        $topBar->save();

        return redirect()->route('admin.top-bar.index')
            ->with('success', 'Header Top Bar settings updated successfully.');
    }
}
