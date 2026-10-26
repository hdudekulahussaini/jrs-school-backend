@extends('admin.layout')

@section('title', 'Edit Campus Tour Card')
@section('header', 'Edit Campus Card')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.campus-life.index') }}" class="hover:text-slate-900 transition-colors">Campus Tour & Life</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit Card</span>
        </div>
        <a href="{{ route('admin.campus-life.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">Edit Card: {{ $item->title }}</h3>
                <p class="text-sm text-slate-500 mt-1.5">Modify title, subtitle, icon, or image for this campus tour card.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                {{ $item->is_active ? 'Active' : 'Disabled' }}
            </span>
        </div>

        <form action="{{ route('admin.campus-life.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Title & Subtitle -->
            <div class="space-y-4">
                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium leading-none text-slate-700">Card Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $item->title) }}" class="flex h-9 w-full rounded-md border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    @error('title')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="subtitle" class="text-sm font-medium leading-none text-slate-700">Subtitle / Tagline (Optional)</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $item->subtitle) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>

                <!-- Badge Icon (Bootstrap Icon) Section matching user screenshot -->
                <div class="space-y-3 pt-2">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                        <label for="icon" class="text-sm font-semibold text-slate-800">
                            Badge Icon (Bootstrap Icon) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs text-slate-400">Overlapping badge icon displayed on the approach card</span>
                    </div>

                    <!-- Input row with Icon Preview Badge -->
                    <div class="flex items-center gap-3">
                        <div id="icon-preview-box" class="w-11 h-11 rounded-xl bg-rose-50/80 border border-rose-200/80 flex items-center justify-center text-rose-600 text-xl shrink-0 shadow-2xs transition-all">
                            <i id="icon-preview" class="bi bi-book-half"></i>
                        </div>
                        <div class="flex-1">
                            <input type="text" name="icon" id="icon" value="{{ old('icon', $item->icon ?? 'bi bi-book-half') }}" placeholder="bi bi-book-half" class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                        </div>
                    </div>

                    <!-- Quick Presets -->
                    <div class="space-y-2 pt-1">
                        <div class="text-xs font-semibold text-slate-600">Quick Presets</div>
                        <div class="flex flex-wrap gap-2" id="icon-presets">
                            <!-- Core 13 School Features -->
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
                            <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-trophy-fill text-slate-600"></i>
                                <span>Sports Education</span>
                            </button>

                            <!-- More Suitable School & Campus Presets -->
                            <button type="button" data-icon="bi bi-tree-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-tree-fill text-slate-600"></i>
                                <span>Eco Campus</span>
                            </button>
                            <button type="button" data-icon="bi bi-lightbulb-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-lightbulb-fill text-slate-600"></i>
                                <span>STEM & Innovation</span>
                            </button>
                            <button type="button" data-icon="bi bi-moisture" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-moisture text-slate-600"></i>
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
                            <button type="button" data-icon="bi bi-robot" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-robot text-slate-600"></i>
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
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Photo Upload & Current Preview -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Photo / Image</h4>
                </div>

                @if($item->image_full_url)
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <img src="{{ $item->image_full_url }}" alt="{{ $item->title }}" class="w-24 h-16 rounded-md object-cover border border-slate-200">
                        <div class="text-xs text-slate-500">
                            <span class="font-medium text-slate-700 block">Current Photo</span>
                            <span class="truncate block max-w-sm">{{ $item->image_path }}</span>
                        </div>
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="image" class="text-sm font-medium leading-none text-slate-700">Replace Image File</label>
                    <input type="file" name="image" id="image" accept="image/*" class="flex w-full rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs sm:text-sm text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 shadow-xs cursor-pointer">
                    <p class="text-[11px] text-slate-400">Supported: JPG, PNG, WEBP (Max 6MB)</p>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Ordering -->
            <div>
                <div class="space-y-2 max-w-xs">
                    <label for="sort_order" class="text-sm font-medium leading-none text-slate-700">Display Order</label>
                    <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $item->sort_order) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                <a href="{{ route('admin.campus-life.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 py-2 gap-2">
                    <span>Update Campus Card</span>
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
            previewBox.innerHTML = '<i class="bi bi-stars"></i>';
            return;
        }

        // If user entered raw HTML tag like <i class="..." style="..."></i> or <svg>
        if (val.startsWith('<')) {
            previewBox.innerHTML = val;
            return;
        }

        let iconClass = val;
        const aliasMap = {
            'leaf': 'bi bi-tree-fill',
            'atom': 'bi bi-lightbulb-fill',
            'book': 'bi bi-book-half',
            'trophy': 'bi bi-trophy-fill',
            'graduation-cap': 'bi bi-mortarboard-fill',
            'flask': 'bi bi-moisture',
            'monitor': 'bi bi-laptop',
            'palette': 'bi bi-palette-fill',
            'music': 'bi bi-music-note-beamed',
            'school': 'bi bi-buildings-fill',
            'bus': 'bi bi-bus-front-fill',
            'users': 'bi bi-people-fill',
            'shield': 'bi bi-shield-check',
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
