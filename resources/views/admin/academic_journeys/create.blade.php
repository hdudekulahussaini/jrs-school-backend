@extends('admin.layout')

@section('title', 'Add Academic Journey')
@section('header', 'Add Academic Journey')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.academic-journeys.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Academic Journeys</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Academic Journey</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new early learning stage card (e.g. Pre-Primary Programme, Young Buddies, Butterflies, Honey Bees).
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="w-full">
        <form action="{{ route('admin.academic-journeys.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Details Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Programme Details</h3>
                    <p class="text-xs text-slate-500">Title, age group badge, and icon identifier.</p>
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
                            Age Group Badge / Subtitle
                        </label>
                        <input type="text" name="age_group" id="age_group" value="{{ old('age_group') }}" placeholder="e.g. EARLY YEARS or AGE 3.5 TO 4.5 YEARS" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Shown in gold badge under title.</span>
                        @error('age_group')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            URL Slug
                        </label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="e.g. butterflies-programme (auto-generated if empty)" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('slug')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link URL -->
                    <div>
                        <label for="link_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Explore Details Link
                        </label>
                        <input type="text" name="link_url" id="link_url" value="{{ old('link_url') }}" placeholder="e.g. /academics/butterflies-programme" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Target path when visitors click "Explore details".</span>
                        @error('link_url')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Badge Icon Picker (with Live Preview and Quick Presets, No Color Field) -->
                <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5 space-y-4">
                    <!-- Badge Icon Input with Live Preview Box -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Badge Icon (Bootstrap Icon) <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Overlapping badge icon on card</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div id="icon-preview-box" class="w-11 h-11 rounded-xl bg-jrs-navy text-white text-xl flex items-center justify-center shrink-0 shadow-xs transition-all duration-200">
                                <i id="icon-preview" class="{{ old('icon', 'bi bi-mortarboard-fill') }}"></i>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-mortarboard-fill') }}" placeholder="e.g. bi bi-mortarboard-fill" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-jrs-navy font-mono">
                            </div>
                        </div>
                        @error('icon')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quick Presets -->
                    <div class="space-y-2 pt-1">
                        <div class="text-xs font-semibold text-slate-600 flex items-center justify-between">
                            <span>Quick Presets</span>
                            <span class="text-[11px] text-slate-400 font-normal">Click any preset to apply icon</span>
                        </div>
                        <div class="flex flex-wrap gap-2" id="icon-presets">
                            <button type="button" data-icon="bi bi-mortarboard-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-mortarboard-fill text-slate-600"></i>
                                <span>Academic Excellence</span>
                            </button>
                            <button type="button" data-icon="bi bi-calendar-check-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-calendar-check-fill text-slate-600"></i>
                                <span>Year of Establishment</span>
                            </button>
                            <button type="button" data-icon="bi bi-people-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-people-fill text-slate-600"></i>
                                <span>Happy Students</span>
                            </button>
                            <button type="button" data-icon="bi bi-award-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-award-fill text-slate-600"></i>
                                <span>Expert Teachers</span>
                            </button>
                            <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-trophy-fill text-slate-600"></i>
                                <span>Board Pass Rate</span>
                            </button>
                            <button type="button" data-icon="bi bi-shield-check" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-shield-check text-slate-600"></i>
                                <span>Safe & Secure</span>
                            </button>
                            <button type="button" data-icon="bi bi-buildings-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-buildings-fill text-slate-600"></i>
                                <span>Campus & Infrastructure</span>
                            </button>
                            <button type="button" data-icon="bi bi-person-badge-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-person-badge-fill text-slate-600"></i>
                                <span>1:25 Ratio</span>
                            </button>
                            <button type="button" data-icon="bi bi-laptop" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-laptop text-slate-600"></i>
                                <span>Smart Classrooms</span>
                            </button>
                            <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-book-half text-slate-600"></i>
                                <span>Library & Books</span>
                            </button>
                            <button type="button" data-icon="bi bi-lightbulb-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-lightbulb-fill text-slate-600"></i>
                                <span>STEM & Innovation</span>
                            </button>
                            <button type="button" data-icon="bi bi-tree-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-tree-fill text-slate-600"></i>
                                <span>Eco Campus</span>
                            </button>
                            <button type="button" data-icon="bi bi-flask" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-flask text-slate-600"></i>
                                <span>Science Labs</span>
                            </button>
                            <button type="button" data-icon="bi bi-palette-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-palette-fill text-slate-600"></i>
                                <span>Performing Arts</span>
                            </button>
                            <button type="button" data-icon="bi bi-globe2" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-globe2 text-slate-600"></i>
                                <span>Global Vision</span>
                            </button>
                            <button type="button" data-icon="bi bi-heart-pulse-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-heart-pulse-fill text-slate-600"></i>
                                <span>Health & Wellness</span>
                            </button>
                            <button type="button" data-icon="bi bi-stars" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-stars text-slate-600"></i>
                                <span>Values & Ethos</span>
                            </button>
                            <button type="button" data-icon="bi bi-emoji-smile-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-emoji-smile-fill text-slate-600"></i>
                                <span>Early Years &amp; Play</span>
                            </button>
                            <button type="button" data-icon="bi bi-backpack-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-backpack-fill text-slate-600"></i>
                                <span>Primary School</span>
                            </button>
                            <button type="button" data-icon="bi bi-compass-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-compass-fill text-slate-600"></i>
                                <span>Curiosity &amp; Explorer</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Description <span class="text-jrs-red">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" required placeholder="Describe this academic stage and developmental goals..." class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('description') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Media / Image Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Stage Photograph</h3>
                    <p class="text-xs text-slate-500">Upload a high-quality photograph showcasing classroom or campus learning.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Stage Photograph',
                    'aspect' => 'landscape',
                    'help' => 'Accepted formats: JPEG, PNG, WEBP. Max size: 4MB.',
                    'urlField' => true,
                    'urlName' => 'image_path',
                    'urlValue' => old('image_path'),
                ])
            </div>

            <!-- Publishing & Order Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Display & Order Settings</h3>
                    <p class="text-xs text-slate-500">Position order and immediate visibility on the Academics page.</p>
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
                    <span>Create Journey Card</span>
                </button>
            </div>
        </form>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('icon');
        const iconPreviewBox = document.getElementById('icon-preview-box');
        const presetButtons = document.querySelectorAll('.icon-preset-btn');

        function updateIconPreview(val) {
            if (!val || !val.trim()) {
                iconPreviewBox.innerHTML = '<i class="bi bi-mortarboard-fill"></i>';
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
@endsection
