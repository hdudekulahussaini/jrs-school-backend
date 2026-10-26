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
        $validated['is_active'] = $request->has('is_active');

        // Automatic phone_href and email_href if not filled
        if (empty($validated['phone_href'])) {
            $digits = preg_replace('/[^0-9+]/', '', $validated['phone']);
            $validated['phone_href'] = 'tel:' . $digits;
        }

        if (empty($validated['email_href'])) {
            $validated['email_href'] = 'mailto:' . $validated['email'];
        }

        $uploadDir = public_path('uploads/documents');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // Handle Mandatory Disclosure PDF upload
        if ($request->hasFile('mandatory_disclosure_file_upload')) {
            if ($topBar->mandatory_disclosure_file && File::exists(public_path(ltrim($topBar->mandatory_disclosure_file, '/')))) {
                File::delete(public_path(ltrim($topBar->mandatory_disclosure_file, '/')));
            }

            $file = $request->file('mandatory_disclosure_file_upload');
            $filename = 'mandatory_disclosure_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['mandatory_disclosure_file'] = '/uploads/documents/' . $filename;
        }

        // Handle School Prospectus PDF upload
        if ($request->hasFile('prospectus_file_upload')) {
            if ($topBar->prospectus_file && File::exists(public_path(ltrim($topBar->prospectus_file, '/')))) {
                File::delete(public_path(ltrim($topBar->prospectus_file, '/')));
            }

            $file = $request->file('prospectus_file_upload');
            $filename = 'prospectus_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $validated['prospectus_file'] = '/uploads/documents/' . $filename;
        }

        unset($validated['mandatory_disclosure_file_upload']);
        unset($validated['prospectus_file_upload']);

        $topBar->fill($validated);
        $topBar->save();

        return redirect()->route('admin.top-bar.index')
            ->with('success', 'Header Top Bar settings updated successfully.');
    }
}
