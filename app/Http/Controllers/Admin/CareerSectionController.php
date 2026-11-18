<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CareerSectionController extends Controller
{
    /**
     * Ensure table and columns exist.
     */
    protected function ensureTableExists(): void
    {
        if (!Schema::hasTable('career_sections')) {
            Schema::create('career_sections', function (Blueprint $table) {
                $table->id();
                $table->string('badge')->default('TEACHING AT JRS');
                $table->string('title')->default('Grow. Teach. Inspire. Make A Difference.');
                $table->string('highlight_1')->nullable()->default('Inspire.');
                $table->string('highlight_2')->nullable()->default('Difference.');
                $table->text('description');
                $table->string('image_path')->nullable();
                $table->string('apply_email')->nullable()->default('careers@jrsschool.com');
                $table->string('apply_phone')->nullable()->default('+91 98765 43210');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            Schema::table('career_sections', function (Blueprint $table) {
                if (!Schema::hasColumn('career_sections', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('apply_phone');
                }
            });
        }
    }

    /**
     * Display a listing of Career section overviews.
     */
    public function index()
    {
        $this->ensureTableExists();

        $sections = CareerSection::orderBy('id', 'desc')->paginate(10);
        $activeSection = CareerSection::where('is_active', true)->first();
        $totalCount = CareerSection::count();

        return view('admin.careers.teaching.index', compact('sections', 'activeSection', 'totalCount'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create()
    {
        $this->ensureTableExists();

        return view('admin.careers.teaching.create');
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request)
    {
        $this->ensureTableExists();

        $validated = $request->validate(CareerSection::validationRules());
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'career_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/careers'), $filename);
            $validated['image_path'] = '/uploads/careers/' . $filename;
        } else {
            $validated['image_path'] = '/images/careers/teaching-at-jrs.png';
        }

        unset($validated['image_file']);

        if ($validated['is_active']) {
            CareerSection::where('is_active', true)->update(['is_active' => false]);
        }

        CareerSection::create($validated);

        flash()->success('Successfully created.');

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Successfully created.');
    }

    /**
     * Display the specified section.
     */
    public function show($id)
    {
        $this->ensureTableExists();

        $section = CareerSection::findOrFail($id);
        return view('admin.careers.teaching.show', compact('section'));
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit($id)
    {
        $this->ensureTableExists();

        $section = CareerSection::findOrFail($id);
        return view('admin.careers.teaching.edit', compact('section'));
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, $id)
    {
        $this->ensureTableExists();

        $section = CareerSection::findOrFail($id);
        $validated = $request->validate(CareerSection::validationRules());

        if ($request->has('is_active')) {
            $isActive = (bool)$request->is_active;
            $validated['is_active'] = $isActive;
            if ($isActive) {
                CareerSection::where('id', '!=', $id)->update(['is_active' => false]);
            }
        }

        if ($request->hasFile('image_file')) {
            if ($section->image_path && str_starts_with($section->image_path, '/uploads/')) {
                $oldPath = public_path(ltrim($section->image_path, '/'));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('image_file');
            $filename = 'career_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/careers'), $filename);
            $validated['image_path'] = '/uploads/careers/' . $filename;
        }

        unset($validated['image_file']);

        $section->update($validated);

        flash()->success('Successfully updated.');

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified section.
     */
    public function destroy($id)
    {
        $this->ensureTableExists();

        $section = CareerSection::findOrFail($id);

        if ($section->image_path && str_starts_with($section->image_path, '/uploads/')) {
            $oldPath = public_path(ltrim($section->image_path, '/'));
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $section->delete();

        flash()->success('Successfully deleted.');

        return redirect()->route('admin.careers-teaching.index')
            ->with('success', 'Successfully deleted.');
    }

    /**
     * Toggle active status.
     */
    public function toggle($id)
    {
        $this->ensureTableExists();

        $section = CareerSection::findOrFail($id);
        $newStatus = !$section->is_active;

        if ($newStatus) {
            CareerSection::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $section->is_active = $newStatus;
        $section->save();

        if ($section->is_active) {
            flash()->success('Successfully activated.');
        } else {
            flash()->success('Successfully deactivated.');
        }

        return response()->json([
            'success' => true,
            'is_active' => $section->is_active,
            'message' => 'Status updated successfully'
        ]);
    }
}
