@extends('admin.layout')

@section('title', 'Create Amenities CTA Banner')
@section('header', 'New Amenities CTA Banner')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.amenities-cta.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-medium flex items-center gap-1">
                    &larr; Back to CTA Banners
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Create Amenities CTA Banner</h2>
            <p class="text-xs text-slate-500">
                Configure the call-to-action banner displayed at the bottom of the Amenities page.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.amenities-cta.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
            <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">
                Banner Content
            </h3>

            <!-- Eyebrow Badge -->
            <div class="space-y-1.5">
                <label for="badge" class="text-xs font-semibold text-slate-700">Eyebrow Badge</label>
                <input type="text" 
                       id="badge" 
                       name="badge" 
                       value="{{ old('badge', 'JOIN THE JRS JOURNEY') }}" 
                       placeholder="e.g. JOIN THE JRS JOURNEY"
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                @error('badge')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="text-xs font-semibold text-slate-700">Headline <span class="text-jrs-red">*</span></label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', 'We Invite Everyone To Join Us On Our Journey Towards Excellence.') }}" 
                       required
                       placeholder="e.g. We Invite Everyone To Join Us On Our Journey Towards Excellence."
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                @error('title')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Highlight Accent -->
            <div class="space-y-1.5">
                <label for="highlight_text" class="text-xs font-semibold text-slate-700">
                    Highlighted Word (Rendered in Amber/Gold)
                </label>
                <input type="text" 
                       id="highlight_text" 
                       name="highlight_text" 
                       value="{{ old('highlight_text', 'Excellence.') }}" 
                       placeholder="e.g. Excellence."
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                <p class="text-[11px] text-slate-500">The exact text in the headline that will be colored in bright yellow/gold.</p>
                @error('highlight_text')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-semibold text-slate-700">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="e.g. Experience our vibrant learning atmosphere, state-of-the-art facilities, and nurturing environment firsthand."
                          class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('description', 'Experience our vibrant learning atmosphere, state-of-the-art facilities, and nurturing environment firsthand.') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <!-- Primary Button Text & URL -->
                <div class="space-y-3 p-4 rounded-lg bg-red-50/50 border border-red-100">
                    <div class="text-xs font-bold text-jrs-red uppercase tracking-wider">Primary Button (Red Pill)</div>
                    <div class="space-y-1">
                        <label for="primary_button_text" class="text-xs font-semibold text-slate-700">Button Label <span class="text-jrs-red">*</span></label>
                        <input type="text" 
                               id="primary_button_text" 
                               name="primary_button_text" 
                               value="{{ old('primary_button_text', 'Book a Campus Tour &rarr;') }}" 
                               required
                               class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 focus:outline-none focus:border-jrs-red">
                    </div>
                    <div class="space-y-1">
                        <label for="primary_button_url" class="text-xs font-semibold text-slate-700">Button Link URL <span class="text-jrs-red">*</span></label>
                        <input type="text" 
                               id="primary_button_url" 
                               name="primary_button_url" 
                               value="{{ old('primary_button_url', '/campus-tour') }}" 
                               required
                               class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 focus:outline-none focus:border-jrs-red font-mono">
                    </div>
                </div>

                <!-- Secondary Button Text & URL -->
                <div class="space-y-3 p-4 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="text-xs font-bold text-slate-700 uppercase tracking-wider">Secondary Button (Glassmorphic)</div>
                    <div class="space-y-1">
                        <label for="secondary_button_text" class="text-xs font-semibold text-slate-700">Button Label</label>
                        <input type="text" 
                               id="secondary_button_text" 
                               name="secondary_button_text" 
                               value="{{ old('secondary_button_text', 'Contact School') }}" 
                               class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 focus:outline-none focus:border-jrs-navy">
                    </div>
                    <div class="space-y-1">
                        <label for="secondary_button_url" class="text-xs font-semibold text-slate-700">Button Link URL</label>
                        <input type="text" 
                               id="secondary_button_url" 
                               name="secondary_button_url" 
                               value="{{ old('secondary_button_url', '/contact') }}" 
                               class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 focus:outline-none focus:border-jrs-navy font-mono">
                    </div>
                </div>
            </div>

            <!-- Artwork Image Upload -->
            <div class="space-y-1.5 pt-2">
                <label for="image_file" class="text-xs font-semibold text-slate-700">Background Artwork / Montage</label>
                <input type="file" 
                       id="image_file" 
                       name="image_file" 
                       accept="image/*"
                       class="w-full px-3 py-2 text-xs rounded-md border border-slate-200 file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:opacity-90">
                <p class="text-[11px] text-slate-500">Leave empty to use the default high-resolution campus journey montage.</p>
                @error('image')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                <div>
                    <div class="text-xs font-semibold text-slate-700">Set as Live Banner</div>
                    <p class="text-[11px] text-slate-500">Activating this will automatically set any other Amenities CTA banner to disabled.</p>
                </div>
                <label class="relative inline-flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.amenities-cta.index') }}" class="px-4 py-2 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 text-xs font-semibold rounded-md bg-jrs-red text-white hover:opacity-90 shadow-xs">
                Save CTA Banner
            </button>
        </div>
    </form>

</div>
@endsection
