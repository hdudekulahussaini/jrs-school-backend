@extends('admin.layout')

@section('title', 'Edit Breadcrumb Banner - ' . $banner->page_name)
@section('header', 'Edit Breadcrumb Banner')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Breadcrumb / Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.breadcrumb-banners.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Breadcrumb Banners</span>
        </a>
        <span class="text-xs text-slate-400">ID #{{ $banner->id }}</span>
    </div>

    <!-- Main Edit Form -->
    <form action="{{ route('admin.breadcrumb-banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="bannerForm">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-6">

            <!-- Section 1: Page Selection -->
            <div class="border-b border-slate-100 pb-5">
                <div class="text-sm font-bold text-jrs-navy font-heading">1. Website Page Selection</div>
                <p class="text-xs text-slate-500 mt-0.5">The current page is automatically selected in the dropdown below.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <!-- Page Dropdown -->
                    <div class="space-y-1">
                        <label for="page_selector" class="text-xs font-semibold text-slate-700">Selected Website Page <span class="text-jrs-red">*</span></label>
                        <select id="page_selector" class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 bg-white focus:outline-none focus:border-jrs-navy font-medium">
                            @foreach($supportedPages as $page)
                                @php $isSelected = ($banner->page_slug === $page['slug']); @endphp
                                <option value="{{ $page['slug'] }}" data-page="{{ json_encode($page) }}" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $page['name'] }} ({{ $page['nav_path'] ?? '/' . $page['slug'] }}) {{ $isSelected ? '★ Current' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Page Name -->
                    <div class="space-y-1">
                        <label for="page_name" class="text-xs font-semibold text-slate-700">Page Name <span class="text-jrs-red">*</span></label>
                        <input type="text" id="page_name" name="page_name" value="{{ old('page_name', $banner->page_name) }}" required readonly class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 bg-slate-50 text-slate-700 cursor-not-allowed focus:outline-none @error('page_name') border-red-500 @enderror">
                        <input type="hidden" id="page_slug" name="page_slug" value="{{ old('page_slug', $banner->page_slug) }}">
                        @error('page_name')
                            <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('page_slug')
                            <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Banner Headings & Breadcrumbs -->
            <div class="border-b border-slate-100 pb-5">
                <div class="text-sm font-bold text-jrs-navy font-heading">2. Banner Headings & Breadcrumbs</div>
                <p class="text-xs text-slate-500 mt-0.5">Control the breadcrumb text, white main title, and amber/orange highlighted word.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <!-- Breadcrumb Title -->
                    <div class="space-y-1">
                        <label for="breadcrumb_title" class="text-xs font-semibold text-slate-700">Breadcrumb Title <span class="text-jrs-red">*</span></label>
                        <input type="text" id="breadcrumb_title" name="breadcrumb_title" value="{{ old('breadcrumb_title', $banner->breadcrumb_title) }}" required placeholder="e.g. Principal's Message" class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-jrs-navy @error('breadcrumb_title') border-red-500 @enderror">
                        <span class="text-[10px] text-slate-400">Shown after "Home &gt; ..."</span>
                        @error('breadcrumb_title')
                            <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Main Title (White) -->
                    <div class="space-y-1">
                        <label for="title" class="text-xs font-semibold text-slate-700">Main Title (White) <span class="text-jrs-red">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $banner->title) }}" required placeholder="e.g. Principal’s" class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-jrs-navy @error('title') border-red-500 @enderror">
                        <span class="text-[10px] text-slate-400">First part of heading in white</span>
                        @error('title')
                            <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Highlighted Title (Amber/Orange) -->
                    <div class="space-y-1">
                        <label for="highlighted_title" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
                            <span>Highlighted Word <span class="text-amber-500 font-bold">(Orange)</span></span>
                        </label>
                        <input type="text" id="highlighted_title" name="highlighted_title" value="{{ old('highlighted_title', $banner->highlighted_title) }}" placeholder="e.g. Message" class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 text-amber-600 font-bold focus:outline-none focus:border-amber-500 @error('highlighted_title') border-red-500 @enderror">
                        <span class="text-[10px] text-slate-400">Rendered in amber/orange accent</span>
                        @error('highlighted_title')
                            <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Subtitle -->
                <div class="mt-4 space-y-1">
                    <label for="subtitle" class="text-xs font-semibold text-slate-700">Subtitle / Tagline</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" placeholder="e.g. Empowering Minds and Enriching Lives." class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-jrs-navy @error('subtitle') border-red-500 @enderror">
                    @error('subtitle')
                        <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mt-4 space-y-1">
                    <label for="description" class="text-xs font-semibold text-slate-700">Paragraph Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Enter descriptive paragraph for this banner..." class="w-full px-3 py-2 text-xs sm:text-sm rounded-lg border border-slate-200 focus:outline-none focus:border-jrs-navy @error('description') border-red-500 @enderror">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
                        <p class="text-[11px] text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 3: Call-To-Action Button -->
            <div class="border-b border-slate-100 pb-5">
                <div class="text-sm font-bold text-jrs-navy font-heading">3. Action Button (Optional)</div>
                <p class="text-xs text-slate-500 mt-0.5">Add an optional glassmorphic button (e.g. "About JRS" or "Watch Video"). Leave blank if not required.</p>

                <div class="mt-4 max-w-xl">
                    <!-- Action Button (Glassmorphic) -->
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 space-y-3">
                        <div class="text-xs font-bold text-slate-800 uppercase flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                            <span>Action Button (Glassmorphic)</span>
                        </div>
                        <div class="space-y-1">
                            <label for="secondary_button_text" class="text-[11px] font-semibold text-slate-700">Button Text</label>
                            <input type="text" id="secondary_button_text" name="secondary_button_text" value="{{ old('secondary_button_text', $banner->secondary_button_text) }}" placeholder="e.g. About JRS or Watch Video" class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white">
                        </div>
                        <div class="space-y-1">
                            <label for="secondary_button_url" class="text-[11px] font-semibold text-slate-700">Button Link / URL</label>
                            <input type="text" id="secondary_button_url" name="secondary_button_url" value="{{ old('secondary_button_url', $banner->secondary_button_url) }}" placeholder="e.g. /about or https://..." class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Background Image & Artwork -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'background_image',
                    'id' => 'background_image',
                    'label' => '4. Background Image & Artwork',
                    'current' => $banner->background_image_url ?? null,
                    'currentPath' => $banner->background_image ?? null,
                    'aspect' => 'banner',
                    'help' => 'Recommended: High-resolution horizontal landscape photograph (1920×600px). JPG, PNG, WEBP, SVG (Max 10MB).',
                ])
            </div>

            @php
                $isAbout = str_contains(strtolower($banner->page_slug ?? ''), 'about') 
                    || str_contains(strtolower($banner->page_name ?? ''), 'about');
            @endphp
            <!-- Section 5: Dynamic Stats Cards (Only for About JRS banner as seen in Screenshot 4) -->
            <div id="statsSection" class="border-b border-slate-100 pb-5 {{ $isAbout ? '' : 'hidden' }}" style="{{ $isAbout ? '' : 'display: none;' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-bold text-jrs-navy font-heading">5. Impact Stats Cards (About Page)</div>
                        <p class="text-xs text-slate-500 mt-0.5">As shown in Screenshot 4 ("About JRS"), add dynamic glass cards under the banner.</p>
                    </div>
                    <button type="button" id="addStatBtn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold transition-colors">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Add Stat Card</span>
                    </button>
                </div>

                <div id="statsList" class="space-y-3 mt-4">
                    @if($banner->stats && $banner->stats->count() > 0)
                        @foreach($banner->stats as $idx => $st)
                            <div class="stat-row p-3 rounded-xl border border-slate-200 bg-slate-50/80 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <input type="hidden" name="stats[{{ $idx }}][icon]" value="{{ $st->icon ?? 'sparkles' }}">
                                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" name="stats[{{ $idx }}][value]" value="{{ old('stats.' . $idx . '.value', $st->value) }}" placeholder="Value (e.g. 2021, 3630478, 1:25, 5)" class="stat-value-input px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white">
                                    <input type="text" name="stats[{{ $idx }}][label]" value="{{ old('stats.' . $idx . '.label', $st->label) }}" placeholder="Label (e.g. Year of Establishment)" class="stat-label-input px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white">
                                </div>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-600 rounded-md hover:bg-red-50 transition-colors" onclick="this.closest('.stat-row').remove();">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>



        </div>

        <!-- Form Submit & Cancel -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.breadcrumb-banners.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Update Breadcrumb Banner</span>
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
let statIndex = {{ $banner->stats ? $banner->stats->count() : 0 }};

function addStatRow(icon = 'sparkles', value = '', label = '') {
    const list = document.getElementById('statsList');
    const row = document.createElement('div');
    row.className = 'stat-row p-3 rounded-xl border border-slate-200 bg-slate-50/80 flex items-center gap-3';
    row.innerHTML = `
        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <input type="hidden" name="stats[${statIndex}][icon]" value="${icon}">
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <input type="text" name="stats[${statIndex}][value]" value="${value}" placeholder="Value (e.g. 2021, 3630478, 1:25, 5)" class="stat-value-input px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white">
            <input type="text" name="stats[${statIndex}][label]" value="${label}" placeholder="Label (e.g. Year of Establishment)" class="stat-label-input px-3 py-1.5 text-xs rounded-md border border-slate-200 bg-white">
        </div>
        <button type="button" class="p-1.5 text-slate-400 hover:text-red-600 rounded-md hover:bg-red-50 transition-colors" onclick="this.closest('.stat-row').remove();">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    `;
    list.appendChild(row);
    statIndex++;
}

document.getElementById('addStatBtn').addEventListener('click', () => addStatRow());

// Helper to check if current selection/input is About page
function isAboutPage(val, name) {
    val = (val || '').toLowerCase();
    name = (name || '').toLowerCase();
    return val === 'about' || val.includes('about') || name.includes('about');
}

function updateStatsVisibility() {
    const selVal = document.getElementById('page_selector').value;
    const nameVal = document.getElementById('page_name').value;
    const slugVal = document.getElementById('page_slug').value;
    const statsSec = document.getElementById('statsSection');
    if (!statsSec) return;

    if (isAboutPage(selVal, nameVal) || isAboutPage(slugVal, nameVal)) {
        statsSec.classList.remove('hidden');
        statsSec.style.display = 'block';
    } else {
        statsSec.classList.add('hidden');
        statsSec.style.display = 'none';
    }
}

// Page selection dropdown change listener
document.getElementById('page_selector').addEventListener('change', function() {
    updateStatsVisibility();

    const val = this.value;
    if (!val) return;

    const selectedOption = this.options[this.selectedIndex];
    const pageDataStr = selectedOption.getAttribute('data-page');
    if (!pageDataStr) return;

    const page = JSON.parse(pageDataStr);
    document.getElementById('page_name').value = page.name || '';
    document.getElementById('page_slug').value = page.slug || '';

    if (confirm(`Do you want to autofill recommended defaults for "${page.name}"? This will update empty or non-customized fields.`)) {
        if (!document.getElementById('breadcrumb_title').value) {
            document.getElementById('breadcrumb_title').value = page.breadcrumb_title || page.name;
        }
        if (!document.getElementById('title').value) {
            document.getElementById('title').value = page.title;
        }
        if (!document.getElementById('highlighted_title').value && page.highlighted_title) {
            document.getElementById('highlighted_title').value = page.highlighted_title;
        }
        if (!document.getElementById('subtitle').value && page.subtitle) {
            document.getElementById('subtitle').value = page.subtitle;
        }
        if (!document.getElementById('description').value && page.description) {
            document.getElementById('description').value = page.description;
        }
    }
});

document.getElementById('page_name').addEventListener('input', function() {
    updateStatsVisibility();
});

// Initial check
updateStatsVisibility();

// Live Background Image Single-Frame Preview Handler
function previewBannerImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImg = document.getElementById('bannerImagePreview');
            const statusBadge = document.getElementById('bannerImageStatus');
            const filenameSpan = document.getElementById('bannerImageFilename');
            const resetBtn = document.getElementById('resetImageBtn');
            const notice = document.getElementById('uploadFileNotice');

            if (previewImg) {
                previewImg.src = e.target.result;
            }

            if (statusBadge) {
                statusBadge.textContent = 'New Selected';
                statusBadge.className = 'font-semibold text-[10px] uppercase px-1.5 py-0.5 rounded bg-blue-500/90 text-white';
            }

            if (filenameSpan) {
                filenameSpan.textContent = file.name;
                filenameSpan.title = file.name;
            }

            if (resetBtn) {
                resetBtn.classList.remove('hidden');
            }

            if (notice) {
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                const sizeText = sizeMb > 0.1 ? sizeMb + ' MB' : (file.size / 1024).toFixed(1) + ' KB';
                notice.innerHTML = '<span class="text-emerald-600 font-semibold">Selected: ' + file.name + ' (' + sizeText + ')</span> &bull; Click "Choose New Image" to change or "Revert" to cancel.';
            }
        };

        reader.readAsDataURL(file);
    }
}

function clearBannerImageSelection() {
    const input = document.getElementById('background_image');
    if (input) input.value = '';

    const previewImg = document.getElementById('bannerImagePreview');
    const statusBadge = document.getElementById('bannerImageStatus');
    const filenameSpan = document.getElementById('bannerImageFilename');
    const resetBtn = document.getElementById('resetImageBtn');
    const notice = document.getElementById('uploadFileNotice');

    if (previewImg) {
        previewImg.src = previewImg.getAttribute('data-original');
    }

    if (statusBadge) {
        const hasCustom = @json(!empty($banner->background_image));
        statusBadge.textContent = hasCustom ? 'Current Image' : 'Default Artwork';
        statusBadge.className = 'font-semibold text-[10px] uppercase px-1.5 py-0.5 rounded ' + (hasCustom ? 'bg-emerald-500/80' : 'bg-slate-700/80');
    }

    if (filenameSpan) {
        filenameSpan.textContent = @json(basename($banner->background_image ?? 'cta-banner.png'));
    }

    if (resetBtn) {
        resetBtn.classList.add('hidden');
    }

    if (notice) {
        notice.textContent = 'Recommended: High-resolution horizontal landscape photograph (1920\u00D7600px).';
    }
}
</script>
@endpush
@endsection
