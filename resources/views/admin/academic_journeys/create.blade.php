@extends('admin.layout')

@section('title', 'Add Academic Journey Stage')
@section('header', 'Add Academic Journey')

@section('content')
<div class="space-y-6 w-full max-w-5xl">

    <!-- Header Navigation & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.academic-journeys.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy inline-flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Academic Journeys</span>
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-jrs-navy font-heading mt-1">Create Academic Journey Card</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new early learning stage card (e.g. Butterflies Programme, Young Buddies, Honey Bees) with curriculum highlights.
            </p>
        </div>
    </div>

    <!-- Create Form Card -->
    <form action="{{ route('admin.academic-journeys.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- SECTION 1: Basic Programme Details -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-jrs-navy font-heading">1. Programme Headings &amp; Age Group</h3>
                <p class="text-xs text-slate-500">Title, curriculum accent heading, and age group badge.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Programme Title <span class="text-jrs-red">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Butterflies Programme" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    @error('title')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age Group Badge -->
                <div>
                    <label for="age_group" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Age Group Badge
                    </label>
                    <input type="text" name="age_group" id="age_group" value="{{ old('age_group') }}" placeholder="e.g. AGE 3.5 TO 4.5 YEARS" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <span class="text-[11px] text-slate-400">Shown in gold pill badge overlay.</span>
                    @error('age_group')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Badge Icon Picker -->
            <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5 space-y-4">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Badge Icon (Bootstrap Icon) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] text-slate-400">Overlapping badge icon on student card</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div id="iconPreviewBox" class="w-11 h-11 rounded-lg bg-jrs-navy text-white text-xl flex items-center justify-center shrink-0 shadow-xs border border-white/20">
                            <i class="bi bi-stars"></i>
                        </div>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-stars') }}" placeholder="e.g. bi bi-stars or bi-award-fill" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>
                </div>

                <!-- Quick Presets -->
                <div class="space-y-2">
                    <span class="text-xs font-semibold text-slate-600 block">Quick Icon Presets:</span>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-icon="bi bi-stars" class="icon-preset-btn border border-rose-400 bg-rose-50 text-rose-700 px-3 py-1.5 rounded-full text-xs font-medium transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-stars text-amber-500"></i>
                            <span>Sparkles &amp; Creative</span>
                        </button>
                        <button type="button" data-icon="bi bi-emoji-smile-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-emoji-smile-fill text-amber-500"></i>
                            <span>Early Years / Smile</span>
                        </button>
                        <button type="button" data-icon="bi bi-people-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-people-fill text-blue-500"></i>
                            <span>Young Buddies</span>
                        </button>
                        <button type="button" data-icon="bi bi-heart-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-heart-fill text-rose-500"></i>
                            <span>Honey Bees / Care</span>
                        </button>
                        <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-book-half text-emerald-500"></i>
                            <span>Foundational Literacy</span>
                        </button>
                        <button type="button" data-icon="bi bi-award-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-award-fill text-purple-500"></i>
                            <span>Excellence &amp; Skills</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Overview & Lead Callout (matching screenshot) -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-jrs-navy font-heading">2. Curriculum Overview &amp; Lead Quote</h3>
                <p class="text-xs text-slate-500">Featured lead paragraph with red accent border, followed by overview narrative.</p>
            </div>

            <!-- Lead Text (Callout with red bar) -->
            <div>
                <label for="lead_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                    <span class="w-1.5 h-3.5 bg-jrs-red rounded-xs"></span>
                    <span>Lead Callout Text (Red Accent Bar Quote)</span>
                </label>
                <textarea name="lead_text" id="lead_text" rows="3" placeholder="At this age, children are more willing to learn, share and explore. Our staff is trained to teach children different languages, and writing skills and engage them in memory-building activities." class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy leading-relaxed">{{ old('lead_text') }}</textarea>
                <span class="text-[11px] text-slate-400">Displays with a prominent vertical red line on the left side of the text.</span>
                @error('lead_text')
                    <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Overview Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Secondary Overview Paragraph <span class="text-jrs-red">*</span>
                </label>
                <textarea name="description" id="description" rows="3" required placeholder="Through singing, sports, dancing, and story studios children are encouraged to build their extra-curricular activities. Montessori methods are adopted in teaching." class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('description') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy leading-relaxed">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- SECTION 3: Curriculum & Learning Highlights (matching screenshot) -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <div class="flex items-center gap-1.5 text-jrs-red text-xs font-bold uppercase tracking-wider mb-0.5">
                        <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                        <span>Curriculum &amp; Learning Highlights</span>
                    </div>
                    <p class="text-xs text-slate-500">Checklist items displayed in 2-column rounded cards with red checkmarks.</p>
                </div>
                <button type="button" onclick="addHighlightRow()" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-jrs-navy/5 text-jrs-navy hover:bg-jrs-navy hover:text-white border border-jrs-navy/20 transition-colors inline-flex items-center gap-1 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Highlight Point</span>
                </button>
            </div>

            <div id="highlightsContainer" class="space-y-2.5">
                @php
                    $defaultHighlights = old('highlights', [
                        'Montessori methods adopted in teaching',
                        'Different languages, writing skills & memory-building',
                        'Story studios, singing, sports, and dancing',
                        'Co-curricular and extra-curricular talent building',
                        'Encouraging sharing, active learning, and exploration'
                    ]);
                @endphp
                @foreach($defaultHighlights as $pt)
                    <div class="flex items-center gap-2 highlight-row">
                        <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <input type="text" name="highlights[]" value="{{ $pt }}" placeholder="e.g. Montessori methods adopted in teaching" class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors cursor-pointer" title="Remove point">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION 4: Media / Image Card -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-jrs-navy font-heading">4. Stage Photograph</h3>
                <p class="text-xs text-slate-500">Student / classroom photograph displayed on the right column.</p>
            </div>

            @include('admin.partials.image-upload', [
                'name' => 'image',
                'id' => 'image',
                'label' => 'Journey Stage Photograph',
                'current' => null,
                'aspect' => 'portrait',
                'help' => 'Accepted formats: JPEG, PNG, WEBP. Recommended: Portrait/student photo.',
                'urlField' => true,
                'urlName' => 'image_path',
                'urlValue' => old('image_path'),
            ])
        </div>

        <!-- SECTION 5: Publishing & Order Card -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-jrs-navy font-heading">5. Display &amp; Order Settings</h3>
                <p class="text-xs text-slate-500">Position order and visibility on the Academics page.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Display Sort Order
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder ?? 1) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    <span class="text-[11px] text-slate-400">Position 1 to 4 from left to right.</span>
                </div>

                <div class="pt-4 sm:pt-0">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                        <div class="space-y-0.5">
                            <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                            <span class="text-[11px] text-slate-500 block">Show this card on the Academics page.</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.academic-journeys.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>Save Stage</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function addHighlightRow(val = '') {
        const container = document.getElementById('highlightsContainer');
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 highlight-row';
        row.innerHTML = `
            <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <input type="text" name="highlights[]" value="${val.replace(/"/g, '&quot;')}" placeholder="e.g. Montessori methods adopted in teaching" class="highlight-input flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            <button type="button" onclick="removeHighlightRow(this)" class="p-1.5 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-md transition-colors cursor-pointer" title="Remove point">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        container.appendChild(row);
        const input = row.querySelector('input');
        if (input && !val) input.focus();
    }

    function removeHighlightRow(btn) {
        const container = document.getElementById('highlightsContainer');
        if (container.querySelectorAll('.highlight-row').length > 1) {
            btn.closest('.highlight-row').remove();
        } else {
            const input = btn.closest('.highlight-row').querySelector('input');
            if (input) input.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('icon');
        const iconPreviewBox = document.getElementById('iconPreviewBox');
        const presetButtons = document.querySelectorAll('.icon-preset-btn');

        function updateIconPreview(val) {
            if (!iconPreviewBox || !val) {
                if (iconPreviewBox) iconPreviewBox.innerHTML = '<i class="bi bi-mortarboard-fill"></i>';
                return;
            }
            val = val.trim();
            if (val.startsWith('<')) {
                iconPreviewBox.innerHTML = val;
            } else {
                let cls = val;
                const legacyMap = {
                    'baby': 'bi bi-emoji-smile-fill',
                    'users': 'bi bi-people-fill',
                    'sparkles': 'bi bi-stars',
                    'heart': 'bi bi-heart-fill',
                    'book': 'bi bi-book-half',
                    'award': 'bi bi-award-fill'
                };
                if (legacyMap[cls]) {
                    cls = legacyMap[cls];
                } else if (!cls.startsWith('bi ') && !cls.startsWith('fa-') && !cls.startsWith('fas ') && !cls.startsWith('far ')) {
                    cls = 'bi bi-' + cls;
                }
                iconPreviewBox.innerHTML = '<i class="' + cls + '"></i>';
            }
        }

        function highlightActivePreset(currentVal) {
            const val = (currentVal || '').trim();
            presetButtons.forEach(btn => {
                const btnIcon = btn.getAttribute('data-icon');
                if (btnIcon === val) {
                    btn.classList.add('border-rose-400', 'bg-rose-50', 'text-rose-700');
                    btn.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
                } else {
                    btn.classList.remove('border-rose-400', 'bg-rose-50', 'text-rose-700');
                    btn.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
                }
            });
        }

        if (iconInput) {
            iconInput.addEventListener('input', function() {
                updateIconPreview(this.value);
                highlightActivePreset(this.value);
            });
            updateIconPreview(iconInput.value);
            highlightActivePreset(iconInput.value);
        }

        presetButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const iconVal = this.getAttribute('data-icon');
                if (iconInput) {
                    iconInput.value = iconVal;
                    updateIconPreview(iconVal);
                    highlightActivePreset(iconVal);
                }
            });
        });
    });
</script>
@endpush
@endsection
