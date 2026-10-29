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
                Update headline, highlight accent phrase, badge tag, description, and banner artwork.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="w-full">
        <form action="{{ route('admin.beyond-classroom-cta.update', $cta->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Headline & Content Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Banner Headline & Messaging</h3>
                    <p class="text-xs text-slate-500">Primary headline, highlight accent text, badge tag, and subheading description.</p>
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

                <!-- Badge Tag -->
                <div>
                    <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Badge Tag (Optional)
                    </label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $cta->badge) }}" placeholder="e.g. Admissions Open 2026-27" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Subheading Description
                    </label>
                    <textarea name="description" id="description" rows="3" class="flex w-full rounded-md border border-slate-200 bg-white p-3 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $cta->description) }}</textarea>
                </div>
            </div>

            <!-- Artwork & Visibility Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
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
@endsection
