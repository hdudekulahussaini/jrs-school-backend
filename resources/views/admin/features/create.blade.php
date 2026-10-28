@extends('admin.layout')

@section('title', 'Add Key Feature')
@section('header', 'Add Key Feature')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.features.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Key Features</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Key Feature</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new highlight card (e.g. CBSE Curriculum, Holistic Development) shown under the homepage hero slider.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.features.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Feature Card Details</h3>
                    <p class="text-xs text-slate-500">Configure title, subtitle, icon, and theme badge color.</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Feature Title <span class="text-jrs-red">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. CBSE Curriculum, Holistic Development" class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    @error('title')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Subtitle / Short Description
                    </label>
                    <textarea name="description" id="description" rows="2" placeholder="e.g. Strong academic foundation, Dedicated & qualified teachers..." class="flex min-h-[60px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Theme Color & Badge Icon (Bootstrap Icon) -->
                <div class="space-y-4 pt-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Icon Badge Color -->
                        <div>
                            <label for="color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Icon Badge Color <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="colorPicker" value="{{ old('color', '#e31e24') }}" oninput="setColor(this.value)" class="h-10 w-11 p-1 rounded-lg border border-slate-200 cursor-pointer bg-white shrink-0">
                                <input type="text" name="color" id="color" value="{{ old('color', '#e31e24') }}" oninput="setColor(this.value)" placeholder="#e31e24" class="flex h-10 w-full rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5 mt-2.5">
                                <span class="text-[10px] text-slate-400 font-semibold uppercase mr-1">Palette:</span>
                                <button type="button" onclick="setColor('#e31e24')" class="w-5 h-5 rounded-full bg-[#e31e24] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="CBSE Red"></button>
                                <button type="button" onclick="setColor('#059669')" class="w-5 h-5 rounded-full bg-[#059669] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Holistic Emerald"></button>
                                <button type="button" onclick="setColor('#f59e0b')" class="w-5 h-5 rounded-full bg-[#f59e0b] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Faculty Amber"></button>
                                <button type="button" onclick="setColor('#2563eb')" class="w-5 h-5 rounded-full bg-[#2563eb] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Safe Blue"></button>
                                <button type="button" onclick="setColor('#4f46e5')" class="w-5 h-5 rounded-full bg-[#4f46e5] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Modern Indigo"></button>
                                <button type="button" onclick="setColor('#9333ea')" class="w-5 h-5 rounded-full bg-[#9333ea] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Creative Purple"></button>
                                <button type="button" onclick="setColor('#0284c7')" class="w-5 h-5 rounded-full bg-[#0284c7] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Sky Blue"></button>
                                <button type="button" onclick="setColor('#0f172a')" class="w-5 h-5 rounded-full bg-[#0f172a] border border-black/10 hover:scale-110 transition-transform shadow-2xs" title="Deep Slate"></button>
                            </div>
                            @error('color')
                                <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Badge Icon Input with Live Preview Box -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Badge Icon (Bootstrap Icon) <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] text-slate-400">Overlapping badge icon displayed on card</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div id="icon-preview-box" class="w-11 h-11 rounded-xl flex items-center justify-center text-white text-xl shrink-0 shadow-xs transition-all duration-200" style="background-color: {{ old('color', '#e31e24') }}">
                                    <i id="icon-preview" class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-mortarboard-fill') }}" placeholder="bi bi-mortarboard-fill" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                                </div>
                            </div>
                            @error('icon')
                                <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>
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
                            <button type="button" data-icon="bi bi-share-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-share-fill text-slate-600"></i>
                                <span>Holistic Development</span>
                            </button>
                            <button type="button" data-icon="bi bi-buildings-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-buildings-fill text-slate-600"></i>
                                <span>Best Infrastructure</span>
                            </button>
                            <button type="button" data-icon="bi bi-person-heart" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-person-heart text-slate-600"></i>
                                <span>Personal Attention</span>
                            </button>
                            <button type="button" data-icon="bi bi-shield-check" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-shield-check text-slate-600"></i>
                                <span>Safe & Secure</span>
                            </button>
                            <button type="button" data-icon="bi bi-people-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-people-fill text-slate-600"></i>
                                <span>1:25 Ratio</span>
                            </button>
                            <button type="button" data-icon="bi bi-laptop" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-laptop text-slate-600"></i>
                                <span>Professional Dev</span>
                            </button>
                            <button type="button" data-icon="bi bi-patch-check-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-patch-check-fill text-slate-600"></i>
                                <span>Qualitative Assessment</span>
                            </button>
                            <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-book-half text-slate-600"></i>
                                <span>Resource Media</span>
                            </button>
                            <button type="button" data-icon="bi bi-bus-front-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-bus-front-fill text-slate-600"></i>
                                <span>Field Trips</span>
                            </button>
                            <button type="button" data-icon="bi bi-compass-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-compass-fill text-slate-600"></i>
                                <span>Career Guidance</span>
                            </button>
                            <button type="button" data-icon="bi bi-palette-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-palette-fill text-slate-600"></i>
                                <span>Performing Arts</span>
                            </button>
                            <button type="button" data-icon="bi bi-award-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-award-fill text-slate-600"></i>
                                <span>Sports Education</span>
                            </button>
                            <button type="button" data-icon="bi bi-tree-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-tree-fill text-slate-600"></i>
                                <span>Eco Campus</span>
                            </button>
                            <button type="button" data-icon="bi bi-lightbulb-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-lightbulb-fill text-slate-600"></i>
                                <span>STEM & Innovation</span>
                            </button>
                            <button type="button" data-icon="bi bi-flask" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-flask text-slate-600"></i>
                                <span>Science Labs</span>
                            </button>
                            <button type="button" data-icon="bi bi-music-note-beamed" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-music-note-beamed text-slate-600"></i>
                                <span>Music & Band</span>
                            </button>
                            <button type="button" data-icon="bi bi-globe-americas" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-globe-americas text-slate-600"></i>
                                <span>Global Vision</span>
                            </button>
                            <button type="button" data-icon="bi bi-heart-pulse-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-heart-pulse-fill text-slate-600"></i>
                                <span>Health & Wellness</span>
                            </button>
                            <button type="button" data-icon="bi bi-cup-hot-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-cup-hot-fill text-slate-600"></i>
                                <span>Dining & Nutrition</span>
                            </button>
                            <button type="button" data-icon="bi bi-activity" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-activity text-slate-600"></i>
                                <span>Martial Arts & Skating</span>
                            </button>
                            <button type="button" data-icon="bi bi-cpu-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-cpu-fill text-slate-600"></i>
                                <span>Robotics & AI</span>
                            </button>
                            <button type="button" data-icon="bi bi-chat-quote-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-chat-quote-fill text-slate-600"></i>
                                <span>Public Speaking</span>
                            </button>
                            <button type="button" data-icon="bi bi-stars" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-stars text-slate-600"></i>
                                <span>Values & Ethos</span>
                            </button>
                        </div>
                    </div>
                </div>

            <!-- Publishing Settings Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Display & Order Settings</h3>
                    <p class="text-xs text-slate-500">Control appearance order and immediate visibility.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Display Sort Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm font-mono shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <span class="text-[11px] text-slate-400">Position 1 to 5 from left to right.</span>
                    </div>

                    <div class="pt-4 sm:pt-0">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-jrs-red focus:ring-jrs-red">
                            <div class="space-y-0.5">
                                <span class="text-xs font-bold text-slate-700 block">Published / Visible</span>
                                <span class="text-[11px] text-slate-500 block">Show this card on the homepage.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.features.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Create Feature</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setColor(hex) {
    const colorInput = document.getElementById('color');
    const colorPicker = document.getElementById('colorPicker');
    const previewBox = document.getElementById('icon-preview-box');
    if (colorInput) colorInput.value = hex;
    if (colorPicker) colorPicker.value = hex;
    if (previewBox) previewBox.style.backgroundColor = hex;
}

document.addEventListener('DOMContentLoaded', function () {
    const iconInput = document.getElementById('icon');
    const previewBox = document.getElementById('icon-preview-box');
    const presetBtns = document.querySelectorAll('.icon-preset-btn');
    const colorInput = document.getElementById('color');

    function updatePreview(val) {
        val = (val || '').trim();
        if (!val) {
            previewBox.innerHTML = '<i class="bi bi-stars"></i>';
            return;
        }

        if (val.startsWith('<')) {
            previewBox.innerHTML = val;
            return;
        }

        let iconClass = val;
        const aliasMap = {
            'graduation-cap': 'bi bi-mortarboard-fill',
            'sparkles': 'bi bi-stars',
            'award': 'bi bi-award-fill',
            'shield-check': 'bi bi-shield-check',
            'building-2': 'bi bi-buildings-fill',
            'building': 'bi bi-buildings-fill',
            'book': 'bi bi-book-half',
            'users': 'bi bi-people-fill',
            'trophy': 'bi bi-trophy-fill',
            'heart': 'bi bi-heart-pulse-fill',
        };

        if (aliasMap[val]) {
            iconClass = aliasMap[val];
        } else if (!val.includes(' ') && !val.includes('-')) {
            iconClass = 'bi bi-' + val;
        }

        previewBox.innerHTML = '<i class="' + iconClass + '"></i>';

        presetBtns.forEach(btn => {
            const dataIcon = btn.getAttribute('data-icon');
            if (dataIcon === val || dataIcon === iconClass) {
                btn.classList.add('bg-rose-50', 'border-rose-300', 'text-rose-700', 'font-semibold');
                btn.classList.remove('bg-white', 'text-slate-700');
            } else {
                btn.classList.remove('bg-rose-50', 'border-rose-300', 'text-rose-700', 'font-semibold');
                btn.classList.add('bg-white', 'text-slate-700');
            }
        });
    }

    presetBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const iconVal = this.getAttribute('data-icon');
            iconInput.value = iconVal;
            updatePreview(iconVal);
        });
    });

    if (iconInput) {
        iconInput.addEventListener('input', function () {
            updatePreview(this.value);
        });
        updatePreview(iconInput.value);
    }

    if (colorInput && colorInput.value) {
        setColor(colorInput.value);
    }
});
</script>
@endsection
