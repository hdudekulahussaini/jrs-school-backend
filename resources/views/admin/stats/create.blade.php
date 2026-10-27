@extends('admin.layout')

@section('title', 'Add Stat Card')
@section('header', 'Add Stat Card')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.stats.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Stats Section</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Stat Card</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new homepage counter metric (e.g. 2021 Year of Establishment, 1000+ Happy Students).
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-3xl">
        <form action="{{ route('admin.stats.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Metric Details</h3>
                    <p class="text-xs text-slate-500">Specify the large number/value and descriptive label.</p>
                </div>

                <!-- Value & Title Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Value -->
                    <div>
                        <label for="value" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Stat Value / Number <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="value" id="value" value="{{ old('value') }}" required placeholder="e.g. 2021, 1000+, 50+, 100+" class="flex h-9 w-full rounded-md border {{ $errors->has('value') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy font-bold">
                        <span class="text-[11px] text-slate-400">Can include numbers, plus signs, suffixes (e.g. 1000+, 99.8%).</span>
                        @error('value')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title / Label -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Metric Label / Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Year of Establishment, Happy Students" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Appears below the number.</span>
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <!-- Icon & Color -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Icon Selector -->
                    <div>
                        <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Icon Symbol
                        </label>
                        <select name="icon" id="icon" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <option value="graduation-cap" {{ old('icon') == 'graduation-cap' ? 'selected' : '' }}>graduation-cap (Establishment / Education)</option>
                            <option value="users" {{ old('icon') == 'users' ? 'selected' : '' }}>users (Happy Students / Community)</option>
                            <option value="award" {{ old('icon') == 'award' ? 'selected' : '' }}>award (Faculty / Excellence)</option>
                            <option value="trophy" {{ old('icon') == 'trophy' ? 'selected' : '' }}>trophy (Co-curricular / Sports)</option>
                            <option value="book" {{ old('icon') == 'book' ? 'selected' : '' }}>book (Academics / Library)</option>
                            <option value="star" {{ old('icon') == 'star' ? 'selected' : '' }}>star (Success / Ratings)</option>
                            <option value="shield-check" {{ old('icon') == 'shield-check' ? 'selected' : '' }}>shield-check (Safety / Trust)</option>
                        </select>
                        @error('icon')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Accent Color -->
                    <div>
                        <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Accent / Icon Color
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="colorPicker" value="{{ old('color', '#eab308') }}" oninput="setColor(this.value)" class="h-9 w-10 p-0.5 rounded border border-slate-200 cursor-pointer bg-white">
                            <input type="text" name="color" id="color" value="{{ old('color', '#eab308') }}" oninput="setColor(this.value)" placeholder="#eab308" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <button type="button" onclick="setColor('#eab308')" class="w-5 h-5 rounded-full bg-[#eab308] border border-black/10 hover:scale-110 transition-transform" title="Gold/Amber (Default)"></button>
                            <button type="button" onclick="setColor('#e31e24')" class="w-5 h-5 rounded-full bg-[#e31e24] border border-black/10 hover:scale-110 transition-transform" title="JRS Red"></button>
                            <button type="button" onclick="setColor('#059669')" class="w-5 h-5 rounded-full bg-[#059669] border border-black/10 hover:scale-110 transition-transform" title="Emerald Green"></button>
                            <button type="button" onclick="setColor('#2563eb')" class="w-5 h-5 rounded-full bg-[#2563eb] border border-black/10 hover:scale-110 transition-transform" title="Royal Blue"></button>
                            <button type="button" onclick="setColor('#8b5cf6')" class="w-5 h-5 rounded-full bg-[#8b5cf6] border border-black/10 hover:scale-110 transition-transform" title="Purple"></button>
                        </div>
                        @error('color')
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
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Position 1 to 4 from left to right.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
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
                <a href="{{ route('admin.stats.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Create Stat Card</span>
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
