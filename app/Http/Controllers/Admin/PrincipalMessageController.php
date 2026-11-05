<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrincipalMessage;
use App\Http\Requests\PrincipalMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrincipalMessageController extends Controller
{
    /**
     * Display Principal's Message & Academic Leadership management records table.
     */
    public function index()
    {
        $principal = PrincipalMessage::first();
        $principals = PrincipalMessage::orderBy('id', 'asc')->get();

        return view('admin.principal.index', compact('principal', 'principals'));
    }

    /**
     * Show the create form for Principal's Message.
     */
    public function create()
    {
        return view('admin.principal.edit', [
            'principal' => new PrincipalMessage,
            'isCreate' => true,
        ]);
    }

    /**
     * Store a new Principal section record.
     */
    public function store(PrincipalMessageRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/principal');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $filename = 'principal_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['image_path'] = 'uploads/principal/' . $filename;
        }

        unset($data['image'], $data['remove_image']);
        $data['is_active'] = $request->boolean('is_active');
        $data = array_filter($data, static fn ($value) => $value !== null);

        $principal = PrincipalMessage::create($data);

        flash()->success('Principal leadership message created successfully!', 'Leadership Created');

        return redirect()->route('admin.principal.index')
            ->with('success', 'Principal leadership message created successfully!');
    }

    /**
     * Show edit form for Principal's Message and Academic Leadership card.
     */
    public function edit($id)
    {
        $principal = PrincipalMessage::findOrFail($id);
        return view('admin.principal.edit', ['principal' => $principal, 'isCreate' => false]);
    }

    /**
     * Update Principal section contents and photo.
     */
    public function update(PrincipalMessageRequest $request, $id)
    {
        $principal = PrincipalMessage::findOrFail($id);
        $data = $request->validated();

        // Handle Image Removal if checkbox was selected
        if ($request->boolean('remove_image')) {
            if ($principal->image_path && File::exists(public_path($principal->image_path))) {
                File::delete(public_path($principal->image_path));
            }
            $data['image_path'] = null;
        }

        // Handle Direct File Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/principal');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Clean up old local image file
            if ($principal->image_path && File::exists(public_path($principal->image_path))) {
                File::delete(public_path($principal->image_path));
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'principal_' . time() . '_' . Str::random(6) . '.' . $extension;
            $file->move($uploadDir, $filename);

            $data['image_path'] = 'uploads/principal/' . $filename;
        }

        // Boolean status
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        $principal->update($data);

        flash()->success('Principal leadership message updated successfully!', 'Leadership Updated');

        return redirect()->route('admin.principal.index')
            ->with('success', 'Principal leadership message updated successfully!');
    }

    /**
     * Quick toggle active status on/off.
     */
    public function toggle($id)
    {
        $principal = PrincipalMessage::findOrFail($id);
        $principal->is_active = !$principal->is_active;
        $principal->save();

        $status = $principal->is_active ? 'activated' : 'deactivated';

        if ($principal->is_active) {
            flash()->success("Principal leadership section has been activated successfully.", 'Section Activated');
        } else {
            flash()->warning("Principal leadership section has been deactivated.", 'Section Deactivated');
        }

        return redirect()->back()->with('success', "Principal leadership section has been {$status} successfully.");
    }

    /**
     * Delete a Principal section record and its locally uploaded portrait.
     */
    public function destroy($id)
    {
        $principal = PrincipalMessage::findOrFail($id);
        if ($principal->image_path && Str::startsWith($principal->image_path, 'uploads/principal/') && File::exists(public_path($principal->image_path))) {
            File::delete(public_path($principal->image_path));
        }
        $principal->delete();

        flash()->info('Principal leadership record deleted successfully.', 'Leadership Removed');

        return redirect()->route('admin.principal.index')
            ->with('success', 'Principal leadership record deleted successfully.');
    }
}
