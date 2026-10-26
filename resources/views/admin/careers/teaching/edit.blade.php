@extends('admin.layout')

@section('title', 'Edit Teaching at JRS Section')
@section('header', 'Edit Teaching Section')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-teaching.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Teaching at JRS</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit Teaching Section Copy</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update headline, red highlighted phrases, description, and school campus photograph.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.careers-teaching.update', $section->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Typography & Headlines Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Headline & Highlights</h3>
                    <p class="text-xs text-slate-500">Configure top red badge, headline, and red emphasized words.</p>
                </div>

                <!-- Badge & Full Title -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Top Red Pill Badge
                        </label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge', $section->badge) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Full Headline <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                <!-- Red Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="highlight_1" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Highlight 1 (Rendered in Red)
                        </label>
                        <input type="text" name="highlight_1" id="highlight_1" value="{{ old('highlight_1', $section->highlight_1) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>

                    <div>
                        <label for="highlight_2" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Highlight 2 (Rendered in Red)
                        </label>
                        <input type="text" name="highlight_2" id="highlight_2" value="{{ old('highlight_2', $section->highlight_2) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Description Paragraph <span class="text-jrs-red">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required class="flex w-full rounded-md border border-slate-200 bg-white p-3 text-xs sm:text-sm shadow-xs">{{ old('description', $section->description) }}</textarea>
                </div>
            </div>

            <!-- Contact & Image Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Artwork & Resume Contact</h3>
                    <p class="text-xs text-slate-500">Campus photograph and contact details for applicants.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="apply_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Resume Submission Email
                        </label>
                        <input type="email" name="apply_email" id="apply_email" value="{{ old('apply_email', $section->apply_email) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs font-mono">
                    </div>

                    <div>
                        <label for="apply_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            HR / Contact Phone
                        </label>
                        <input type="text" name="apply_phone" id="apply_phone" value="{{ old('apply_phone', $section->apply_phone) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                @if($section->image_full_url)
                    <div>
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Campus Photo</span>
                        <div class="relative w-full max-w-md h-40 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs">
                            <img src="{{ $section->image_full_url }}" alt="Campus" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Replace School Campus Photo
                    </label>
                    <input type="file" name="image_file" id="image_file" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:opacity-90 cursor-pointer">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $section->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-navy border-slate-300 focus:ring-jrs-navy cursor-pointer">
                    <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">
                        Set as Active Section on Careers Page
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.careers-teaching.index') }}" class="px-4 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
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
