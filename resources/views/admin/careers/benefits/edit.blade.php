@extends('admin.layout')

@section('title', 'Edit Benefit Card - Careers Page')
@section('header', 'Edit Benefit Card')

@section('content')
<div class="space-y-6 w-full">

    <!-- Header / Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-benefits.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-medium flex items-center gap-1">
                    &larr; Back to Benefits
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Edit Benefit Card</h2>
            <p class="text-xs text-slate-500">
                Update icon, heading, or description for: <span class="font-semibold text-jrs-navy">{{ $benefit->title }}</span>
            </p>
        </div>
        <a href="{{ route('admin.careers-benefits.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">Edit Benefit Card</h3>
            <p class="text-sm text-slate-500 mt-1.5">
                Modify the card's heading, icon, and description.
            </p>
        </div>

        <form action="{{ route('admin.careers-benefits.update', $benefit->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Heading -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-slate-800">
                    Heading <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $benefit->title) }}"
                       placeholder="e.g. Collaborative Community or Continuous Growth"
                       required
                       class="flex h-11 w-full rounded-lg border @error('title') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent">
                @error('title')
                    <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- 2. Icon (Remaining Pages Design) -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                        <label for="icon" class="text-sm font-semibold text-slate-800">
                            Icon <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs text-slate-400">Bootstrap Icon (e.g. bi bi-people-fill, bi bi-mortarboard-fill)</span>
                    </div>
                    <p class="text-xs text-slate-500">Pick from quick presets or enter any Bootstrap icon class.</p>
                </div>

                <!-- Input row with Icon Preview Badge -->
                <div class="flex items-center gap-3">
                    <div id="icon-preview-box" class="w-11 h-11 rounded-xl bg-rose-50/80 border border-rose-200/80 flex items-center justify-center text-rose-600 text-xl shrink-0 shadow-2xs transition-all">
                        <i id="icon-preview" class="bi bi-people-fill"></i>
                    </div>
                    <div class="flex-1">
                        <input type="text" 
                               name="icon" 
                               id="icon" 
                               value="{{ old('icon', $benefit->icon) }}" 
                               placeholder="bi bi-people-fill or bi bi-mortarboard-fill" 
                               required
                               class="flex h-11 w-full rounded-lg border @error('icon') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                    </div>
                </div>
                @error('icon')
                    <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror

                <!-- Quick Presets for Culture & Benefits -->
                <div class="space-y-2 pt-1">
                    <div class="text-xs font-semibold text-slate-600">Quick Presets for Work Culture & Benefits</div>
                    <div class="flex flex-wrap gap-2" id="icon-presets">
                        <button type="button" data-icon="bi bi-people-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-people-fill text-slate-600"></i>
                            <span>Collaborative Community</span>
                        </button>
                        <button type="button" data-icon="bi bi-mortarboard-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-mortarboard-fill text-slate-600"></i>
                            <span>Continuous Growth</span>
                        </button>
                        <button type="button" data-icon="bi bi-lightbulb-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-lightbulb-fill text-slate-600"></i>
                            <span>Innovative Teaching</span>
                        </button>
                        <button type="button" data-icon="bi bi-star-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-star-fill text-slate-600"></i>
                            <span>Make A Difference</span>
                        </button>
                        <button type="button" data-icon="bi bi-heart-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-heart-fill text-slate-600"></i>
                            <span>Wellness & Care</span>
                        </button>
                        <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-trophy-fill text-slate-600"></i>
                            <span>Merit & Recognition</span>
                        </button>
                        <button type="button" data-icon="bi bi-stars" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-stars text-slate-600"></i>
                            <span>Inspiration</span>
                        </button>
                        <button type="button" data-icon="bi bi-shield-check" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-shield-check text-slate-600"></i>
                            <span>Security & Stability</span>
                        </button>
                        <button type="button" data-icon="bi bi-briefcase-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-briefcase-fill text-slate-600"></i>
                            <span>Career Growth</span>
                        </button>
                        <button type="button" data-icon="bi bi-laptop" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-laptop text-slate-600"></i>
                            <span>Digital Infrastructure</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- 3. Description -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-slate-800">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          required
                          placeholder="e.g. Work alongside passionate educators and supportive leadership in an environment that fosters teamwork and lifelong learning."
                          class="flex w-full rounded-lg border @error('description') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent">{{ old('description', $benefit->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.careers-benefits.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-jrs-red hover:bg-red-700 px-5 py-2 text-xs font-medium text-white shadow-xs transition-colors">
                    Update Benefit Card
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
            previewBox.innerHTML = '<i class="bi bi-people-fill"></i>';
            return;
        }

        let iconClass = val;
        const aliasMap = {
            'users': 'bi bi-people-fill',
            'graduation-cap': 'bi bi-mortarboard-fill',
            'lightbulb': 'bi bi-lightbulb-fill',
            'star': 'bi bi-star-fill',
            'heart': 'bi bi-heart-fill',
            'trophy': 'bi bi-trophy-fill',
            'sparkles': 'bi bi-stars',
            'shield-check': 'bi bi-shield-check',
            'briefcase': 'bi bi-briefcase-fill',
            'laptop': 'bi bi-laptop',
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
