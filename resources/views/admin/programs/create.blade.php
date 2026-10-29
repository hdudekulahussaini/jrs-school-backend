@extends('admin.layout')

@section('title', 'Add Academic Programme')
@section('header', 'Add Academic Programme')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.programs.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Programmes</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Academic Programme</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Create a new curriculum stage with photo, badge, description, and feature points for the homepage.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
            <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Information Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-jrs-navy font-heading">Programme Essentials</h3>
                        <p class="text-xs text-slate-500">Configure title, curriculum stage badge, and grades.</p>
                    </div>

                    <!-- Stage Badge & Title -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="stage_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Stage Badge Label <span class="text-jrs-red">*</span>
                            </label>
                            <input type="text" name="stage_badge" id="stage_badge" value="{{ old('stage_badge') }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('stage_badge') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            @error('stage_badge')
                                <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Programme Title <span class="text-jrs-red">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            @error('title')
                                <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Subtitle / Grades -->
                    <div>
                        <label for="subtitle" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Sub-heading / Grades Covered
                        </label>
                        <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" class="flex h-9 w-full rounded-md border {{ $errors->has('subtitle') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Highlighted in bold red on the card.</span>
                        @error('subtitle')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Programme Overview Description
                        </label>
                        <textarea name="description" id="description" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Curriculum Highlights Points Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="text-base font-bold text-jrs-navy font-heading">Curriculum Key Highlights</h3>
                            <p class="text-xs text-slate-500">Add the key bullet points displayed with checkmark circles.</p>
                        </div>
                        <button type="button" onclick="addHighlightRow()" class="px-3 py-1 rounded-md text-xs font-semibold bg-jrs-navy/5 text-jrs-navy hover:bg-jrs-navy hover:text-white border border-jrs-navy/20 transition-colors inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Add Point</span>
                        </button>
                    </div>

                    <div id="highlightsContainer" class="space-y-2.5">
                        <div class="flex items-center gap-2 highlight-row">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <input type="text" name="highlights[]" value="" class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" title="Remove point">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Media & Actions Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-jrs-navy font-heading">Student Photo & Call To Action</h3>
                        <p class="text-xs text-slate-500">Upload the student photo and button link.</p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        @include('admin.partials.image-upload', [
                            'name' => 'image',
                            'id' => 'imageInput',
                            'label' => 'Student / Program Image',
                            'aspect' => 'landscape',
                            'help' => 'Recommended aspect ratio: 4:3 or 1:1, up to 5MB (JPG, PNG, WebP).',
                            'urlField' => true,
                            'urlName' => 'image_url',
                            'urlValue' => old('image_url'),
                        ])
                    </div>

                    <!-- Sort Order & Active -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Display Sort Order
                            </label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-32 rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <span class="text-[11px] text-slate-400">Lower numbers appear first.</span>
                        </div>

                        <div class="flex items-center sm:pt-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                                <span class="text-xs font-bold text-slate-800">Publish immediately (Active)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 rounded-md text-xs font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-md text-xs font-semibold bg-jrs-red hover:opacity-95 text-white shadow-xs transition-opacity inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Save Academic Programme</span>
                    </button>
                </div>
            </form>
    </div>

</div>

<!-- Highlight Point Management Script -->
<script>
    function addHighlightRow() {
        const container = document.getElementById('highlightsContainer');
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 highlight-row';
        row.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <input type="text" name="highlights[]" class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" title="Remove point">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        container.appendChild(row);
    }

    function removeHighlightRow(btn) {
        btn.closest('.highlight-row').remove();
    }
</script>
@endsection
