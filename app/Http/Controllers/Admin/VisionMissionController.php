<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use App\Http\Requests\VisionMissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class VisionMissionController extends Controller
{
    /**
     * [READ - Index] Listing of Vision & Mission cards.
     */
    public function index()
    {
        $items = VisionMission::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $creationUsed = $this->creationUsed();

        return view('admin.vision-mission.index', compact('items', 'creationUsed'));
    }

    /**
     * [CREATE - Form] Create a new card.
     */
    public function show($id)
    {
        return redirect()->route('admin.vision-mission.edit', $id);
    }

    public function create()
    {
        if ($this->creationUsed()) {
            flash()->warning('A Vision & Mission card has already been created. You can edit existing cards.', 'Limit Reached');

            return redirect()->route('admin.vision-mission.index')
                ->with('error', 'A Vision & Mission card has already been created. You can edit existing cards.');
        }

        return view('admin.vision-mission.create');
    }

    /**
     * [CREATE - Store] Save newly created card.
     */
    public function store(VisionMissionRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $item = DB::transaction(function () use ($request, $validated) {
            $creationUsed = DB::table('vision_mission_creation_limits')
                ->where('id', 1)
                ->lockForUpdate()
                ->value('creation_used');

            if ($creationUsed === null) {
                throw new RuntimeException('Vision & Mission creation limit record is missing.');
            }

            if ($creationUsed || VisionMission::query()->exists()) {
                DB::table('vision_mission_creation_limits')
                    ->where('id', 1)
                    ->update(['creation_used' => true, 'updated_at' => now()]);

                return null;
            }

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

            $item = VisionMission::create($validated);
            DB::table('vision_mission_creation_limits')
                ->where('id', 1)
                ->update(['creation_used' => true, 'updated_at' => now()]);

            return $item;
        });

        if (!$item) {
            flash()->error('Cannot add card. A Vision & Mission card has already been created.', 'Action Denied');

            return redirect()->route('admin.vision-mission.index')
                ->with('error', 'Cannot add card. A Vision & Mission card has already been created.');
        }

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
        DB::transaction(function () use ($item) {
            DB::table('vision_mission_creation_limits')
                ->where('id', 1)
                ->update(['creation_used' => true, 'updated_at' => now()]);

            $item->delete();
        });

        flash()->info('Vision & Mission card deleted successfully.', 'Card Removed');

        return redirect()->route('admin.vision-mission.index')
            ->with('success', 'Vision & Mission card deleted successfully.');
    }

    private function creationUsed(): bool
    {
        if (VisionMission::query()->exists()) {
            DB::table('vision_mission_creation_limits')
                ->where('id', 1)
                ->update(['creation_used' => true, 'updated_at' => now()]);
        }

        $creationUsed = DB::table('vision_mission_creation_limits')
            ->where('id', 1)
            ->value('creation_used');

        if ($creationUsed === null) {
            throw new RuntimeException('Vision & Mission creation limit record is missing.');
        }

        return (bool) $creationUsed;
    }
}
