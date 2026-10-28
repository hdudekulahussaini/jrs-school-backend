@extends('admin.layout')

@section('title', 'Edit Beyond Classroom CTA Banner')
@section('header', 'Edit Beyond Classroom CTA Banner')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.beyond-classroom-cta.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to CTA Banners</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit CTA Banner</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update headline, highlight accent phrase, action buttons, and student montage artwork.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.beyond-classroom-cta.update', $cta->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Headline & Content Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Banner Headline & Messaging</h3>
                    <p class="text-xs text-slate-500">Primary headline, highlight accent text, and subheading description.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Headline Prefix / Main Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $cta->title) }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Highlight Text -->
                    <div>
                        <label for="highlight_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Highlight Accent Phrase (Rendered in Amber)
                        </label>
                        <input type="text" name="highlight_text" id="highlight_text" value="{{ old('highlight_text', $cta->highlight_text) }}" placeholder="e.g. For Tomorrow" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <p class="text-[11px] text-slate-400 mt-1">Highlighted in amber/gold color directly following the headline.</p>
                    </div>
                </div>

                <!-- Badge Tag & Background Color -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Tag (Optional)
                        </label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge', $cta->badge) }}" placeholder="e.g. Admissions Open 2026-27" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>

                    <div>
                        <label for="bg_color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Background Dark Navy Hex
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="color" id="bg_color_picker" value="{{ old('bg_color', $cta->bg_color ?? '#031c3f') }}" onchange="document.getElementById('bg_color').value = this.value" class="w-9 h-9 rounded border border-slate-200 cursor-pointer p-0.5">
                            <input type="text" name="bg_color" id="bg_color" value="{{ old('bg_color', $cta->bg_color ?? '#031c3f') }}" oninput="document.getElementById('bg_color_picker').value = this.value" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Subheading Description
                    </label>
                    <textarea name="description" id="description" rows="3" class="flex w-full rounded-md border border-slate-200 bg-white p-3 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $cta->description) }}</textarea>
                </div>
            </div>

            <!-- Call-to-Action Buttons Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Call to Action Buttons</h3>
                    <p class="text-xs text-slate-500">Configure primary (solid red) and secondary (dark outline) buttons.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Primary Button -->
                    <div class="p-4 rounded-lg bg-red-50/50 border border-red-100 space-y-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-jrs-red text-white">
                            Primary Button (Red Solid)
                        </span>
                        <div>
                            <label for="primary_button_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Button Label *</label>
                            <input type="text" name="primary_button_text" id="primary_button_text" value="{{ old('primary_button_text', $cta->primary_button_text) }}" required class="flex h-8 w-full rounded-md border border-slate-200 bg-white px-3 text-xs shadow-xs">
                        </div>
                        <div>
                            <label for="primary_button_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Target Link URL *</label>
                            <input type="text" name="primary_button_url" id="primary_button_url" value="{{ old('primary_button_url', $cta->primary_button_url) }}" required class="flex h-8 w-full rounded-md border border-slate-200 bg-white px-3 text-xs font-mono shadow-xs">
                        </div>
                    </div>

                    <!-- Secondary Button -->
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 space-y-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-slate-800 text-white">
                            Secondary Button (Navy Outline)
                        </span>
                        <div>
                            <label for="secondary_button_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Button Label</label>
                            <input type="text" name="secondary_button_text" id="secondary_button_text" value="{{ old('secondary_button_text', $cta->secondary_button_text) }}" class="flex h-8 w-full rounded-md border border-slate-200 bg-white px-3 text-xs shadow-xs">
                        </div>
                        <div>
                            <label for="secondary_button_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Target Link URL</label>
                            <input type="text" name="secondary_button_url" id="secondary_button_url" value="{{ old('secondary_button_url', $cta->secondary_button_url) }}" class="flex h-8 w-full rounded-md border border-slate-200 bg-white px-3 text-xs font-mono shadow-xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artwork & Status Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Artwork & Visibility</h3>
                    <p class="text-xs text-slate-500">Current artwork or upload a replacement banner photograph.</p>
                </div>

                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'image_file',
                        'id' => 'image_file',
                        'label' => 'Banner Artwork Photograph',
                        'current' => $cta->image_full_url ?? null,
                        'aspect' => 'banner',
                        'help' => 'Leave blank to keep current artwork. Upload a file to replace.',
                    ])
                </div>

                <!-- Active Toggle -->
                <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $cta->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-navy border-slate-300 focus:ring-jrs-navy cursor-pointer">
                    <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">
                        Set as Active Banner (Will be served on Beyond Classroom page)
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.beyond-classroom-cta.index') }}" class="px-4 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-5 py-2 gap-2 cursor-pointer">
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
