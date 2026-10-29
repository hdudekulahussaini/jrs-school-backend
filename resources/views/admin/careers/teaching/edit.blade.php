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
                Update heading, paragraph, and campus photograph.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="w-full">
        <form action="{{ route('admin.careers-teaching.update', $section->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Content Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Section Content</h3>
                    <p class="text-xs text-slate-500">Enter the main heading and description paragraph.</p>
                </div>

                <!-- Heading -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Heading <span class="text-jrs-red">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    @error('title')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paragraph Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Paragraph <span class="text-jrs-red">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required class="flex w-full rounded-md border {{ $errors->has('description') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white p-3 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $section->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Campus Image</h3>
                    <p class="text-xs text-slate-500">Upload an image for the Teaching at JRS section.</p>
                </div>

                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'image_file',
                        'id' => 'image_file',
                        'label' => 'School Campus Photo',
                        'current' => $section->image_full_url ?? null,
                        'aspect' => 'landscape',
                        'help' => 'Upload a new photo to replace current photo. Leave blank to keep existing.',
                    ])
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
