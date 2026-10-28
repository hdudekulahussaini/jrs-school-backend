<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
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
            $defaultAttributes = [
                'phone' => '+91 915740 43210',
                'email' => 'info@jrsinternationalschool.com',
                'cbse_affiliation_text' => 'CBSE Affiliated School',
                'prospectus_title' => 'School Prospectus',
                'prospectus_url' => 'https://jrsinternationalschool.com/school-prospectus.pdf',
                'is_active' => true,
            ];

            if (Schema::hasColumn('top_bars', 'phone_2')) {
                $defaultAttributes['phone_2'] = '+91 915740 43211';
            }

            $topBar = TopBar::create($defaultAttributes);
        }

        $topBars = TopBar::all();

        return view('admin.top-bar.index', compact('topBar', 'topBars'));
    }

    /**
     * Show the form for editing the Top Bar settings.
     */
    public function edit()
    {
        $topBar = TopBar::first();

        if (!$topBar) {
            return redirect()->route('admin.top-bar.index');
        }

        return view('admin.top-bar.edit', compact('topBar'));
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

        if (empty($validated['phone_2'])) {
            $validated['phone_2'] = null;
        }

        // Retain or set standard titles
        $validated['prospectus_title'] = $topBar->prospectus_title ?: 'School Prospectus';

        $uploadDir = public_path('uploads/documents');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
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

        unset($validated['prospectus_type']);
        unset($validated['prospectus_file_upload']);

        if (!Schema::hasColumn('top_bars', 'phone_2')) {
            unset($validated['phone_2']);
        }

        $topBar->fill($validated);
        $topBar->save();

        flash()->success('Header Top Bar settings updated successfully.', 'Settings Saved');

        return redirect()->route('admin.top-bar.index')
            ->with('success', 'Header Top Bar settings updated successfully.');
    }
}
