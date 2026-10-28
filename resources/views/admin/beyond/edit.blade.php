@extends('admin.layout')

@section('title', 'Edit Beyond Classroom Activity')
@section('header', 'Edit Beyond Classroom Activity')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Beyond Classroom Page</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit: {{ $activity->title }}</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update activity title, category, badge color, photo, and ordering.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.beyond-classrooms.show', $activity->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-3 py-1.5 gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>View Details</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.beyond-classrooms.update', $activity->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Activity Essentials</h3>
                    <p class="text-xs text-slate-500">Configure title, category badge, and activity overview.</p>
                </div>

                <!-- Title & Category -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Activity Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $activity->title) }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Category / Subtitle
                        </label>
                        <input type="text" name="category" id="category" value="{{ old('category', $activity->category) }}" class="flex h-9 w-full rounded-md border {{ $errors->has('category') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('category')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Theme Color & Icon -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge / Theme Color
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="colorPicker" value="{{ old('color', $activity->color ?? '#15803d') }}" oninput="document.getElementById('color').value = this.value" class="h-9 w-10 p-0.5 rounded border border-slate-200 cursor-pointer bg-white">
                            <input type="text" name="color" id="color" value="{{ old('color', $activity->color) }}" oninput="document.getElementById('colorPicker').value = this.value" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <button type="button" onclick="setColor('#15803d')" class="w-5 h-5 rounded-full bg-[#15803d] border border-black/10 hover:scale-110 transition-transform" title="Sports Green"></button>
                            <button type="button" onclick="setColor('#0284c7')" class="w-5 h-5 rounded-full bg-[#0284c7] border border-black/10 hover:scale-110 transition-transform" title="Music Blue"></button>
                            <button type="button" onclick="setColor('#db2777')" class="w-5 h-5 rounded-full bg-[#db2777] border border-black/10 hover:scale-110 transition-transform" title="Dance Pink"></button>
                            <button type="button" onclick="setColor('#d97706')" class="w-5 h-5 rounded-full bg-[#d97706] border border-black/10 hover:scale-110 transition-transform" title="Karate Amber"></button>
                            <button type="button" onclick="setColor('#2563eb')" class="w-5 h-5 rounded-full bg-[#2563eb] border border-black/10 hover:scale-110 transition-transform" title="Science Royal Blue"></button>
                            <button type="button" onclick="setColor('#0891b2')" class="w-5 h-5 rounded-full bg-[#0891b2] border border-black/10 hover:scale-110 transition-transform" title="Skating Teal"></button>
                        </div>
                        @error('color')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Icon Name / Category
                        </label>
                        <select name="icon" id="icon" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <option value="">Select Icon</option>
                            <option value="trophy" {{ old('icon', $activity->icon) == 'trophy' ? 'selected' : '' }}>trophy (Sports)</option>
                            <option value="music" {{ old('icon', $activity->icon) == 'music' ? 'selected' : '' }}>music (Music)</option>
                            <option value="dance" {{ old('icon', $activity->icon) == 'dance' ? 'selected' : '' }}>dance (Dance / Performing Arts)</option>
                            <option value="shield" {{ old('icon', $activity->icon) == 'shield' ? 'selected' : '' }}>shield (Karate / Martial Arts)</option>
                            <option value="flask" {{ old('icon', $activity->icon) == 'flask' ? 'selected' : '' }}>flask (Science & Activities)</option>
                            <option value="skating" {{ old('icon', $activity->icon) == 'skating' ? 'selected' : '' }}>skating (Roller Skating / Speed)</option>
                            <option value="palette" {{ old('icon', $activity->icon) == 'palette' ? 'selected' : '' }}>palette (Art & Painting)</option>
                            <option value="heart" {{ old('icon', $activity->icon) == 'heart' ? 'selected' : '' }}>heart (Yoga & Wellness)</option>
                            <option value="compass" {{ old('icon', $activity->icon) == 'compass' ? 'selected' : '' }}>compass (Excursions & Tours)</option>
                            <option value="users" {{ old('icon', $activity->icon) == 'users' ? 'selected' : '' }}>users (Clubs & Leadership)</option>
                        </select>
                        @error('icon')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Activity Description
                    </label>
                    <textarea name="description" id="description" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $activity->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media & Photo Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Activity Photo</h3>
                    <p class="text-xs text-slate-500">Update photo or upload a replacement.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Activity Photograph',
                    'current' => $activity->image_full_url ?? null,
                    'currentPath' => $activity->image_path ?? null,
                    'removeName' => 'remove_image',
                    'aspect' => 'video',
                    'help' => 'Supported: WEBP, JPG, PNG up to 5MB (recommended 16:9 landscape).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
            </div>

            <!-- Publishing Settings Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Display & Order Settings</h3>
                    <p class="text-xs text-slate-500">Control appearance order and immediate visibility.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Display Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $activity->sort_order) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Lower numbers appear first (1 to 6).</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $activity->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                                <span class="text-[11px] text-slate-500 block">Show this activity on the school homepage.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Updates</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setColor(hex) {
    document.getElementById('color').value = hex;
    document.getElementById('colorPicker').value = hex;
}
</script>
@endsection
