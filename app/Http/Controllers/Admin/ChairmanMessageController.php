<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChairmanMessage;
use App\Http\Requests\ChairmanMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ChairmanMessageController extends Controller
{
    /**
     * Display Chairman's Address & Leadership sections management with live visual preview.
     */
    public function index()
    {
        $chairman = ChairmanMessage::first();
        $chairmen = ChairmanMessage::orderBy('id', 'asc')->get();

        return view('admin.chairman.index', compact('chairman', 'chairmen'));
    }

    /**
     * Show edit form for Chairman's Address and Strategic Commitment.
     */
    public function edit($id)
    {
        $chairman = ChairmanMessage::findOrFail($id);
        return view('admin.chairman.edit', compact('chairman'));
    }

    /**
     * Update Chairman section contents and photo.
     */
    public function update(ChairmanMessageRequest $request, $id)
    {
        $chairman = ChairmanMessage::findOrFail($id);
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');

        // Handle portrait photo upload or removal
        if ($request->boolean('remove_image')) {
            if ($chairman->image_path && Str::startsWith($chairman->image_path, 'uploads/chairman/') && File::exists(public_path($chairman->image_path))) {
                File::delete(public_path($chairman->image_path));
            }
            $validated['image_path'] = null;
        } elseif ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadDir = public_path('uploads/chairman');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Remove old uploaded portrait if stored in uploads
            if ($chairman->image_path && Str::startsWith($chairman->image_path, 'uploads/chairman/') && File::exists(public_path($chairman->image_path))) {
                File::delete(public_path($chairman->image_path));
            }

            $fileName = 'chairman_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $validated['image_path'] = 'uploads/chairman/' . $fileName;
        } elseif ($request->filled('image_path')) {
            $validated['image_path'] = $request->input('image_path');
        } else {
            // Keep existing image_path if unchanged
            unset($validated['image_path']);
        }

        $chairman->update($validated);

        return redirect()->route('admin.chairman.index')
            ->with('success', 'Chairman Leadership page sections updated successfully!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggle($id)
    {
        $chairman = ChairmanMessage::findOrFail($id);
        $chairman->is_active = !$chairman->is_active;
        $chairman->save();

        $status = $chairman->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Chairman sections successfully {$status}.");
    }
}
