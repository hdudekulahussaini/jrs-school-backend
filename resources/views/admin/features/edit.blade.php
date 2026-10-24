@extends('admin.layout')

@section('title', 'Edit Key Feature - ' . $feature->title)
@section('header', 'Edit Key Feature')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.features.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Key Features</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit: {{ $feature->title }}</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update feature card title, description, badge color, and display ordering.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.features.show', $feature->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-3 py-1.5 gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>View Details</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-3xl">
        <form action="{{ route('admin.features.update', $feature->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Feature Card Details</h3>
                    <p class="text-xs text-slate-500">Configure title, subtitle, icon, and theme badge color.</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Feature Title <span class="text-jrs-red">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $feature->title) }}" required placeholder="e.g. CBSE Curriculum, Holistic Development" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    @error('title')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Subtitle / Short Description
                    </label>
                    <textarea name="description" id="description" rows="2" placeholder="e.g. Strong academic foundation, Dedicated & qualified teachers..." class="flex min-h-[60px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $feature->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Theme Color & Icon -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Icon Badge Color
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="colorPicker" value="{{ old('color', $feature->color ?? '#e31e24') }}" oninput="document.getElementById('color').value = this.value" class="h-9 w-10 p-0.5 rounded border border-slate-200 cursor-pointer bg-white">
                            <input type="text" name="color" id="color" value="{{ old('color', $feature->color ?? '#e31e24') }}" oninput="document.getElementById('colorPicker').value = this.value" placeholder="#e31e24" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <button type="button" onclick="setColor('#e31e24')" class="w-5 h-5 rounded-full bg-[#e31e24] border border-black/10 hover:scale-110 transition-transform" title="CBSE Red"></button>
                            <button type="button" onclick="setColor('#059669')" class="w-5 h-5 rounded-full bg-[#059669] border border-black/10 hover:scale-110 transition-transform" title="Holistic Emerald"></button>
                            <button type="button" onclick="setColor('#f59e0b')" class="w-5 h-5 rounded-full bg-[#f59e0b] border border-black/10 hover:scale-110 transition-transform" title="Faculty Amber"></button>
                            <button type="button" onclick="setColor('#2563eb')" class="w-5 h-5 rounded-full bg-[#2563eb] border border-black/10 hover:scale-110 transition-transform" title="Safe Blue"></button>
                            <button type="button" onclick="setColor('#4f46e5')" class="w-5 h-5 rounded-full bg-[#4f46e5] border border-black/10 hover:scale-110 transition-transform" title="Modern Indigo"></button>
                        </div>
                        @error('color')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Icon Identifier
                        </label>
                        <select name="icon" id="icon" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <option value="graduation-cap" {{ old('icon', $feature->icon) == 'graduation-cap' ? 'selected' : '' }}>graduation-cap (CBSE Curriculum)</option>
                            <option value="sparkles" {{ old('icon', $feature->icon) == 'sparkles' ? 'selected' : '' }}>sparkles (Holistic Development)</option>
                            <option value="award" {{ old('icon', $feature->icon) == 'award' ? 'selected' : '' }}>award (Experienced Faculty)</option>
                            <option value="shield-check" {{ old('icon', $feature->icon) == 'shield-check' ? 'selected' : '' }}>shield-check (Safe & Inclusive)</option>
                            <option value="building-2" {{ old('icon', $feature->icon) == 'building-2' || old('icon', $feature->icon) == 'building' ? 'selected' : '' }}>building-2 (Modern Infrastructure)</option>
                            <option value="book" {{ old('icon', $feature->icon) == 'book' ? 'selected' : '' }}>book (Library / Learning)</option>
                            <option value="users" {{ old('icon', $feature->icon) == 'users' ? 'selected' : '' }}>users (Community / Team)</option>
                            <option value="trophy" {{ old('icon', $feature->icon) == 'trophy' ? 'selected' : '' }}>trophy (Athletics / Sports)</option>
                            <option value="heart" {{ old('icon', $feature->icon) == 'heart' ? 'selected' : '' }}>heart (Care / Wellness)</option>
                        </select>
                        @error('icon')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
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
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $feature->sort_order) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Position 1 to 5 from left to right.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $feature->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                                <span class="text-[11px] text-slate-500 block">Show this card on the homepage.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.features.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
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
