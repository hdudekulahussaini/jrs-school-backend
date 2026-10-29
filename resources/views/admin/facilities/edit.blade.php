@extends('admin.layout')

@section('title', 'Edit Facility #' . $facility->id)
@section('header', 'Edit Facility')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-500">Amenities Page</span>
            <span>/</span>
            <a href="{{ route('admin.facilities.index') }}" class="hover:text-slate-900 transition-colors">Facilities</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit #{{ $facility->id }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
                &larr; Back to list
            </a>
        </div>
    </div>

    <!-- Main Card Container (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">Edit Facility: {{ $facility->title }}</h3>
                <p class="text-sm text-slate-500 mt-1.5">
                    Update the icon, title, or order for this campus facility item.
                </p>
            </div>
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $facility->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                {{ $facility->is_active ? 'Active' : 'Disabled' }}
            </div>
        </div>

        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Facility Title -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">1. Basic Information</h4>
                </div>

                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium leading-none text-slate-700">Facility Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $facility->title) }}" placeholder="e.g. Smart Classrooms" class="flex h-9 w-full rounded-md border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    @error('title')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Badge Icon (Bootstrap Icon) -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">2. Facility Icon</h4>
                    <p class="text-xs text-slate-500">Select or enter a Bootstrap icon for this facility.</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <label for="icon" class="text-sm font-semibold text-slate-800">
                                Icon Class / Preset <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-xs text-slate-400">Bootstrap Icon (e.g. bi bi-display, bi bi-trophy-fill)</span>
                        </div>

                        <!-- Input row with Icon Preview Badge -->
                        <div class="flex items-center gap-3">
                            <div id="icon-preview-box" class="w-11 h-11 rounded-xl bg-rose-50/80 border border-rose-200/80 flex items-center justify-center text-rose-600 text-xl shrink-0 shadow-2xs transition-all">
                                <i id="icon-preview" class="bi bi-display"></i>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $facility->icon ?? 'bi bi-display') }}" placeholder="bi bi-display or bi bi-laptop" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                            </div>
                        </div>
                        @error('icon')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Quick Presets -->
                        <div class="space-y-2 pt-1">
                            <div class="text-xs font-semibold text-slate-600">Quick Presets for Amenities</div>
                            <div class="flex flex-wrap gap-2" id="icon-presets">
                                <button type="button" data-icon="bi bi-display" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-display text-slate-600"></i>
                                    <span>Smart Classrooms</span>
                                </button>
                                <button type="button" data-icon="bi bi-flask" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-flask text-slate-600"></i>
                                    <span>Science Labs</span>
                                </button>
                                <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-book-half text-slate-600"></i>
                                    <span>Library & Media</span>
                                </button>
                                <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-trophy-fill text-slate-600"></i>
                                    <span>Playgrounds & Sports</span>
                                </button>
                                <button type="button" data-icon="bi bi-water" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-water text-slate-600"></i>
                                    <span>Swimming Pool & Track</span>
                                </button>
                                <button type="button" data-icon="bi bi-cup-hot-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-cup-hot-fill text-slate-600"></i>
                                    <span>Canteen & Dining</span>
                                </button>
                                <button type="button" data-icon="bi bi-bus-front-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-bus-front-fill text-slate-600"></i>
                                    <span>Transport Fleet</span>
                                </button>
                                <button type="button" data-icon="bi bi-shield-check" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-shield-check text-slate-600"></i>
                                    <span>CCTV & Security</span>
                                </button>
                                <button type="button" data-icon="bi bi-heart-pulse-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-heart-pulse-fill text-slate-600"></i>
                                    <span>Medical & First Aid</span>
                                </button>
                                <button type="button" data-icon="bi bi-buildings-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-buildings-fill text-slate-600"></i>
                                    <span>World-Class Infrastructure</span>
                                </button>
                                <button type="button" data-icon="bi bi-wifi" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-wifi text-slate-600"></i>
                                    <span>Computing & Wi-Fi</span>
                                </button>
                                <button type="button" data-icon="bi bi-flower1" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-flower1 text-slate-600"></i>
                                    <span>Meditation Hall</span>
                                </button>
                                <button type="button" data-icon="bi bi-robot" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-robot text-slate-600"></i>
                                    <span>Robotics & STEM</span>
                                </button>
                                <button type="button" data-icon="bi bi-palette-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-palette-fill text-slate-600"></i>
                                    <span>Arts & Creativity</span>
                                </button>
                                <button type="button" data-icon="bi bi-tree-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-tree-fill text-slate-600"></i>
                                    <span>Eco Green Campus</span>
                                </button>
                                <button type="button" data-icon="bi bi-mortarboard-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                    <i class="bi bi-mortarboard-fill text-slate-600"></i>
                                    <span>Academic Excellence</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Footer Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-2">
                <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Update Facility</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconInput = document.getElementById('icon');
    const previewBox = document.getElementById('icon-preview-box');
    const presetBtns = document.querySelectorAll('.icon-preset-btn');

    function updatePreview(val) {
        val = (val || '').trim();
        if (!val) {
            previewBox.innerHTML = '<i class="bi bi-display"></i>';
            return;
        }

        if (val.startsWith('<')) {
            previewBox.innerHTML = val;
            return;
        }

        let iconClass = val;
        const aliasMap = {
            'monitor': 'bi bi-display',
            'smart-classroom': 'bi bi-display',
            'laptop': 'bi bi-laptop',
            'flask': 'bi bi-flask',
            'science': 'bi bi-flask',
            'book': 'bi bi-book-half',
            'library': 'bi bi-book-half',
            'trophy': 'bi bi-trophy-fill',
            'sports': 'bi bi-trophy-fill',
            'bus': 'bi bi-bus-front-fill',
            'transport': 'bi bi-bus-front-fill',
            'school': 'bi bi-buildings-fill',
            'building': 'bi bi-buildings-fill',
            'infrastructure': 'bi bi-buildings-fill',
            'tree': 'bi bi-tree-fill',
            'eco': 'bi bi-tree-fill',
            'waves': 'bi bi-water',
            'utensils': 'bi bi-cup-hot-fill',
            'shield': 'bi bi-shield-check',
            'heart-pulse': 'bi bi-heart-pulse-fill',
            'wifi': 'bi bi-wifi',
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

    iconInput.addEventListener('input', function () {
        updatePreview(this.value);
    });

    updatePreview(iconInput.value);
});
</script>
@endsection
