@extends('admin.layout')

@section('title', 'Edit Admission Banner')
@section('header', 'Edit Admission Banner (CTA)')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-jrs-navy font-heading">Edit Admission CTA Banner</h2>
            <p class="text-xs text-slate-500 mt-0.5">Customize the heading, buttons, and background photograph of the banner.</p>
        </div>
        <a href="{{ route('admin.admission-banner.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Overview</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <form action="{{ route('admin.admission-banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Typography Section -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-heading border-b border-slate-100 pb-2">Banner Typography</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label for="title" class="block text-xs font-bold text-slate-700">Main Heading <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy transition-all @error('title') border-red-500 @enderror"
                               placeholder="e.g. Give Your Child A Strong Foundation">
                        @error('title')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="title_highlight" class="block text-xs font-bold text-amber-600">Highlight Text (Amber)</label>
                        <input type="text" name="title_highlight" id="title_highlight" value="{{ old('title_highlight', $banner->title_highlight) }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-amber-300 text-sm text-amber-800 bg-amber-50/30 focus:outline-hidden focus:ring-2 focus:ring-amber-400/30 focus:border-amber-500 transition-all @error('title_highlight') border-red-500 @enderror"
                               placeholder="e.g. For Tomorrow">
                        @error('title_highlight')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="description" class="block text-xs font-bold text-slate-700">Subtitle / Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy transition-all @error('description') border-red-500 @enderror"
                              placeholder="e.g. Join JRS International School and be a part of a nurturing environment...">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Call to Action Buttons Section -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-heading border-b border-slate-100 pb-2">Call To Action (CTA) Buttons</h3>

                <!-- Primary Button (Red with Arrow) -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-jrs-red"></span>
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">Primary Button (Solid Red)</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="primary_button_text" class="block text-xs font-medium text-slate-600">Button Label</label>
                            <input type="text" name="primary_button_text" id="primary_button_text" value="{{ old('primary_button_text', $banner->primary_button_text) }}"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy"
                                   placeholder="Enquire for Admission">
                        </div>

                        <div class="space-y-1">
                            <label for="primary_button_link" class="block text-xs font-medium text-slate-600">Target URL / Route</label>
                            <input type="text" name="primary_button_link" id="primary_button_link" value="{{ old('primary_button_link', $banner->primary_button_link) }}"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy"
                                   placeholder="https://jrs-school.vercel.app/admissions or /admissions">
                        </div>
                    </div>
                </div>

                <!-- Secondary Button (Outline/Dark with Play Icon) -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">Secondary Button (Transparent / Tour)</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="secondary_button_text" class="block text-xs font-medium text-slate-600">Button Label</label>
                            <input type="text" name="secondary_button_text" id="secondary_button_text" value="{{ old('secondary_button_text', $banner->secondary_button_text) }}"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy"
                                   placeholder="Take a Campus Tour">
                        </div>

                        <div class="space-y-1">
                            <label for="secondary_button_link" class="block text-xs font-medium text-slate-600">Target URL / Route</label>
                            <input type="text" name="secondary_button_link" id="secondary_button_link" value="{{ old('secondary_button_link', $banner->secondary_button_link) }}"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy"
                                   placeholder="https://jrs-school.vercel.app/#tour or /campus-tour">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Photograph Upload Section -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-heading">Background Photograph</h3>
                    <span class="text-[11px] text-slate-400">JPG, PNG, WEBP (Max 10MB)</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                    <!-- Upload Input Card -->
                    <div class="space-y-3">
                        <label for="image" class="block text-xs font-bold text-slate-700">Upload Banner Image File</label>
                        
                        <!-- Drag & Drop / File Input Zone -->
                        <div class="relative border-2 border-dashed border-slate-300 hover:border-jrs-navy/50 rounded-2xl p-6 text-center bg-slate-50/50 hover:bg-slate-50 transition-all cursor-pointer group">
                            <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewBannerImage(event)">
                            <div class="flex flex-col items-center justify-center space-y-2 pointer-events-none">
                                <div class="w-12 h-12 rounded-full bg-jrs-navy/5 text-jrs-navy flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div class="text-xs font-semibold text-slate-700">
                                    <span class="text-jrs-red hover:underline">Click to browse</span> or drag and drop
                                </div>
                                <p class="text-[11px] text-slate-400" id="file-name-display">High-resolution horizontal photograph recommended</p>
                            </div>
                        </div>

                        @error('image')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Preview Card -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="block text-xs font-bold text-slate-700">Image Preview</span>
                            <span id="preview-status" class="text-[10px] text-slate-400 font-medium">{{ $banner->image_full_url ? 'Current Image' : 'No Image' }}</span>
                        </div>

                        <div class="relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-900 aspect-video flex items-center justify-center shadow-xs">
                            <img id="image-preview" src="{{ $banner->image_full_url ?? '' }}" alt="Banner Preview" class="w-full h-full object-cover {{ $banner->image_full_url ? '' : 'hidden' }}">
                            <div id="no-image-placeholder" class="text-center p-4 {{ $banner->image_full_url ? 'hidden' : '' }}">
                                <svg class="w-8 h-8 text-slate-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs text-slate-400">No image selected</span>
                            </div>
                            <!-- Subtle Gradient to Preview Banner Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/30 to-transparent pointer-events-none"></div>
                            @if($banner->image_path)
                                <span id="current-filename-badge" class="absolute bottom-2 left-2 text-[10px] text-white/90 bg-black/60 backdrop-blur-xs px-2.5 py-1 rounded-md font-mono truncate max-w-[90%]">
                                    {{ basename($banner->image_path) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.admission-banner.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-red-700 text-white shadow-xs transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewBannerImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const dataUrl = e.target.result;

            const previewImg = document.getElementById('image-preview');
            const placeholder = document.getElementById('no-image-placeholder');
            const statusLabel = document.getElementById('preview-status');
            const filenameBadge = document.getElementById('current-filename-badge');
            const filenameDisplay = document.getElementById('file-name-display');

            if (previewImg) {
                previewImg.src = dataUrl;
                previewImg.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');

            if (statusLabel) {
                statusLabel.textContent = 'Selected: ' + file.name;
                statusLabel.classList.add('text-emerald-600', 'font-semibold');
            }

            if (filenameBadge) {
                filenameBadge.textContent = file.name;
            }

            if (filenameDisplay) {
                filenameDisplay.innerHTML = '<span class="text-emerald-600 font-semibold">' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</span>';
            }
        };

        reader.readAsDataURL(file);
    }
}
</script>
@endsection
