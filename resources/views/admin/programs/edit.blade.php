@extends('admin.layout')

@section('title', 'Edit ' . $program->title)
@section('header', 'Edit Academic Programme')

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
            <div class="flex items-center gap-3">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit: {{ $program->title }}</h2>
                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $program->is_active ? 'border-jrs-navy/20 bg-jrs-navy/5 text-jrs-navy' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                    {{ $program->is_active ? 'Active' : 'Disabled' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Update stage details, student imagery, and homepage curriculum checklist.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

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
                            <input type="text" name="stage_badge" id="stage_badge" value="{{ old('stage_badge', $program->stage_badge) }}" required placeholder="e.g. STAGE 01 • EARLY YEARS" class="flex h-9 w-full rounded-md border {{ $errors->has('stage_badge') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            @error('stage_badge')
                                <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Programme Title <span class="text-jrs-red">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $program->title) }}" required placeholder="e.g. Pre-Primary" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
                        <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $program->subtitle) }}" placeholder="e.g. NURSERY, LKG & UKG" class="flex h-9 w-full rounded-md border {{ $errors->has('subtitle') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
                        <textarea name="description" id="description" rows="3" placeholder="Explain the learning philosophy, classroom approach, and student development..." class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', $program->description) }}</textarea>
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
                            <p class="text-xs text-slate-500">Edit or add bullet points displayed with checkmark icons.</p>
                        </div>
                        <button type="button" onclick="addHighlightRow()" class="px-3 py-1 rounded-md text-xs font-semibold bg-jrs-navy/5 text-jrs-navy hover:bg-jrs-navy hover:text-white border border-jrs-navy/20 transition-colors inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Add Point</span>
                        </button>
                    </div>

                    <div id="highlightsContainer" class="space-y-2.5">
                        @php
                            $existingHighlights = old('highlights', $program->highlights ?? []);
                            if (!is_array($existingHighlights)) {
                                $existingHighlights = [];
                            }
                        @endphp
                        @forelse($existingHighlights as $pt)
                            <div class="flex items-center gap-2 highlight-row">
                                <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <input type="text" name="highlights[]" value="{{ $pt }}" placeholder="Enter key feature or milestone..." class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                                <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" title="Remove point">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @empty
                            <div class="flex items-center gap-2 highlight-row">
                                <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <input type="text" name="highlights[]" value="" placeholder="Enter key feature or milestone..." class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                                <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors" title="Remove point">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Media & Actions Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-jrs-navy font-heading">Student Photo & Call To Action</h3>
                        <p class="text-xs text-slate-500">Update photo, button labels, and status.</p>
                    </div>

                    <!-- Current Photo & Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Student / Program Image
                        </label>

                        @if($program->image_full_url)
                            <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                <div class="w-20 h-16 rounded-lg overflow-hidden border border-slate-200 bg-white shrink-0">
                                    <img src="{{ $program->image_full_url }}" alt="Current Photo" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-semibold text-slate-800 block truncate">Current Image Asset</span>
                                    <span class="text-[11px] text-slate-500 block truncate">{{ $program->image_path }}</span>
                                    <label class="inline-flex items-center gap-1.5 text-xs text-jrs-red hover:underline mt-1 cursor-pointer">
                                        <input type="checkbox" name="remove_image" value="1" class="w-3.5 h-3.5 rounded text-jrs-red border-slate-300">
                                        <span>Remove this photo</span>
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-jrs-navy/40 transition-colors">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewSelectedImage(event)">
                            <label for="imageInput" class="cursor-pointer flex flex-col items-center justify-center space-y-2">
                                <div class="w-10 h-10 rounded-full bg-jrs-navy/5 text-jrs-navy flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-xs font-semibold text-jrs-navy hover:underline">Click to upload replacement photo</span>
                                <span class="text-[11px] text-slate-400">JPG, PNG, WebP up to 5MB</span>
                            </label>
                        </div>
                        @error('image')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Image URL -->
                        <div class="mt-3">
                            <label for="image_url" class="block text-[11px] text-slate-500 mb-1">Or edit external image URL / path:</label>
                            <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $program->image_path) }}" placeholder="e.g. /images/programs/pre-primary.jpg or https://..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>
                    </div>

                    <!-- Button Text & URL -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="button_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Button Text
                            </label>
                            <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $program->button_text) }}" placeholder="Explore More" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>

                        <div>
                            <label for="button_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Target Link URL
                            </label>
                            <input type="text" name="button_url" id="button_url" value="{{ old('button_url', $program->button_url) }}" placeholder="https://..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        </div>
                    </div>

                    <!-- Sort Order & Active -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Display Sort Order
                            </label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $program->sort_order) }}" min="0" class="flex h-9 w-32 rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            <span class="text-[11px] text-slate-400">Lower numbers appear first.</span>
                        </div>

                        <div class="flex items-center sm:pt-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $program->is_active) ? 'checked' : '' }} class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                                <span class="text-xs font-bold text-slate-800">Publish on Homepage (Active)</span>
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
                        <span>Update Academic Programme</span>
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
            <input type="text" name="highlights[]" placeholder="Enter key feature or milestone..." class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
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
