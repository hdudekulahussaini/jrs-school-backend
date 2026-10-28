<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use App\Http\Requests\VisionMissionRequest;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    /**
     * [READ - Index] Listing of Vision & Mission cards.
     */
    public function index()
    {
        $items = VisionMission::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.vision-mission.index', compact('items'));
    }

    /**
     * [CREATE - Form] Create a new card.
     */
    public function create()
    {
        if (VisionMission::count() >= 2) {
            flash()->warning('Only 2 cards (Vision & Mission) are allowed. You can edit existing cards.', 'Limit Reached');

            return redirect()->route('admin.vision-mission.index')
                ->with('error', 'Only 2 cards (Vision & Mission) are allowed. You can edit existing cards.');
        }

        return view('admin.vision-mission.create');
    }

    /**
     * [CREATE - Store] Save newly created card.
     */
    public function store(VisionMissionRequest $request)
    {
        if (VisionMission::count() >= 2) {
            flash()->error('Cannot add card. The maximum limit of 2 cards (Vision & Mission) has already been reached.', 'Action Denied');

            return redirect()->route('admin.vision-mission.index')
                ->with('error', 'Cannot add card. The maximum limit of 2 cards (Vision & Mission) has already been reached.');
        }

        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image_file')) {
            $uploadPath = public_path('uploads/vision-mission');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image_file');
            $filename = 'vm_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image_path'] = 'uploads/vision-mission/' . $filename;
        }

        unset($validated['image_file']);

        VisionMission::create($validated);

        flash()->success('Vision & Mission card created successfully.', 'Card Created');

        return redirect()->route('admin.vision-mission.index')
            ->with('success', 'Vision & Mission card created successfully.');
    }

    /**
     * [UPDATE - Form] Edit existing card.
     */
    public function edit($id)
    {
        $item = VisionMission::findOrFail($id);
        return view('admin.vision-mission.edit', compact('item'));
    }

    /**
     * [UPDATE - Save] Update card.
     */
    public function update(VisionMissionRequest $request, $id)
    {
        $item = VisionMission::findOrFail($id);
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;

        if ($request->hasFile('image_file')) {
            $uploadPath = public_path('uploads/vision-mission');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image_file');
            $filename = 'vm_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image_path'] = 'uploads/vision-mission/' . $filename;
        }

        unset($validated['image_file']);

        $item->update($validated);

        flash()->success('Vision & Mission card updated successfully.', 'Card Updated');

        return redirect()->route('admin.vision-mission.index')
            ->with('success', 'Vision & Mission card updated successfully.');
    }

    /**
     * [DELETE - Destroy] Delete card.
     */
    public function destroy($id)
    {
        $item = VisionMission::findOrFail($id);
        $item->delete();

        flash()->info('Vision & Mission card deleted successfully.', 'Card Removed');

        return redirect()->route('admin.vision-mission.index')
            ->with('success', 'Vision & Mission card deleted successfully.');
    }
}
