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

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium leading-none text-slate-700">Short Description</label>
                    <textarea name="description" id="description" rows="2" class="flex min-h-[70px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('description', $facility->description) }}</textarea>
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

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Facility Photograph -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">3. Facility Photograph</h4>
                    <p class="text-xs text-slate-500">Change or remove the current photograph with instant preview before saving.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Facility Photograph',
                    'current' => $facility->image_full_url ?? null,
                    'currentPath' => $facility->image_path ?? null,
                    'removeName' => 'remove_image',
                    'aspect' => 'video',
                    'help' => 'Recommended: Crisp landscape photograph showing facility features (1200×800px).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 4: Facility Overview & Key Highlights -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">4. Facility Overview &amp; Key Highlights</h4>
                    <p class="text-xs text-slate-500">Detailed narrative and key feature checkmarks shown in the overview card.</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label for="overview_description" class="text-sm font-medium leading-none text-slate-700">Overview Detailed Narrative</label>
                        <textarea name="overview_description" id="overview_description" rows="3" placeholder="Cognospace is an innovative learning and discovery zone that nurtures creativity, critical thinking and problem-solving skills..." class="flex min-h-[90px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('overview_description', $facility->overview_description) }}</textarea>
                        <p class="text-xs text-slate-500">Comprehensive descriptive paragraph introducing the learning philosophy and space.</p>
                    </div>

                    <!-- Key Highlights (Bullet Points with Checkmarks) -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium leading-none text-slate-700">Key Feature Highlights</label>
                                <p class="text-xs text-slate-500 mt-0.5">Bullet points rendered with round checkmark badges.</p>
                            </div>
                            <button type="button" id="addHighlightBtn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Add Point</span>
                            </button>
                        </div>

                        <div id="highlightsList" class="space-y-2.5">
                            @php
                                $highlights = old('highlights', is_array($facility->highlights) && count($facility->highlights) > 0 ? $facility->highlights : [
                                    'Interactive and experiential learning',
                                    'Encourages creativity and innovation',
                                    'Collaborative spaces for team activities',
                                    'Equipped with modern learning tools'
                                ]);
                            @endphp
                            @foreach($highlights as $hl)
                                <div class="flex items-center gap-2 highlight-row">
                                    <div class="w-7 h-7 rounded-full bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <input type="text" name="highlights[]" value="{{ $hl }}" placeholder="e.g. Interactive and experiential learning" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                                    <button type="button" class="remove-highlight-btn inline-flex items-center justify-center h-9 w-9 rounded-md border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 shrink-0 transition-colors" title="Remove point">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 5: Photo Gallery -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-0.5 bg-rose-600 rounded-full"></span>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-700">5. Facility Photo Gallery</h4>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Upload gallery photos for this facility. Each photo can be added or removed individually.</p>
                    </div>
                    <button type="button" id="addGalleryImageBtn" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition-colors shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Add Photo</span>
                    </button>
                </div>

                @php
                    $galleryList = old('existing_gallery_images', is_array($facility->gallery_images) ? $facility->gallery_images : []);
                @endphp

                <!-- Gallery Empty State -->
                <div id="galleryEmptyState" class="{{ !empty($galleryList) ? 'hidden' : '' }} p-8 rounded-xl border border-dashed border-slate-300 bg-slate-50/60 text-center">
                    <div class="w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-400 mx-auto flex items-center justify-center mb-2 shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 block">No gallery photos added yet</span>
                    <span class="text-[11px] text-slate-400 block mt-0.5">Click "Add Photo" to select photos (JPEG, PNG, WEBP, max 6MB each)</span>
                </div>

                <!-- Dynamic Gallery Grid -->
                <div id="galleryImagesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($galleryList as $gIdx => $gPath)
                        <div class="gallery-item-card relative rounded-xl overflow-hidden border border-slate-200 bg-white aspect-video shadow-xs p-1.5 transition-all hover:shadow-md">
                            <div class="relative w-full h-full rounded-lg overflow-hidden bg-slate-900">
                                <img src="{{ asset($gPath) }}" alt="Gallery #{{ $gIdx + 1 }}" class="w-full h-full object-cover">
                                <input type="hidden" name="existing_gallery_images[]" value="{{ $gPath }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none"></div>
                                <button type="button" class="remove-gallery-btn absolute top-2 right-2 bg-red-600/95 hover:bg-red-700 text-white px-2 py-1 rounded-md shadow-md text-xs font-semibold flex items-center gap-1 transition-all cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Remove</span>
                                </button>
                                <span class="absolute bottom-1.5 left-2 right-2 text-white text-[10px] font-mono truncate">Existing Photo #{{ $gIdx + 1 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 6: Display Order & Status -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">6. Display Settings</h4>
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

    // Dynamic Highlights Repeater
    const highlightsList = document.getElementById('highlightsList');
    const addHighlightBtn = document.getElementById('addHighlightBtn');

    if (addHighlightBtn && highlightsList) {
        addHighlightBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 highlight-row';
            row.innerHTML = `
                <div class="w-7 h-7 rounded-full bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <input type="text" name="highlights[]" value="" placeholder="e.g. Collaborative spaces for team activities" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                <button type="button" class="remove-highlight-btn inline-flex items-center justify-center h-9 w-9 rounded-md border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 shrink-0 transition-colors" title="Remove point">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            highlightsList.appendChild(row);
            const input = row.querySelector('input');
            if (input) input.focus();
        });

        highlightsList.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-highlight-btn');
            if (btn) {
                const rows = highlightsList.querySelectorAll('.highlight-row');
                if (rows.length > 1) {
                    btn.closest('.highlight-row').remove();
                } else {
                    const inp = btn.closest('.highlight-row').querySelector('input');
                    if (inp) inp.value = '';
                }
            }
        });
    }

    // Gallery Dynamic Add & Individual Remove
    const galleryImagesGrid = document.getElementById('galleryImagesGrid');
    const galleryEmptyState = document.getElementById('galleryEmptyState');
    const addGalleryImageBtn = document.getElementById('addGalleryImageBtn');

    function updateGalleryState() {
        if (!galleryImagesGrid || !galleryEmptyState) return;
        const totalCards = galleryImagesGrid.querySelectorAll('.gallery-item-card').length;
        if (totalCards === 0) {
            galleryEmptyState.classList.remove('hidden');
        } else {
            galleryEmptyState.classList.add('hidden');
        }
    }

    // Attach click listener for any gallery item remove buttons (existing or new)
    if (galleryImagesGrid) {
        galleryImagesGrid.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-gallery-btn');
            if (btn) {
                const card = btn.closest('.gallery-item-card');
                if (card) {
                    card.remove();
                    updateGalleryState();
                }
            }
        });
    }

    if (addGalleryImageBtn && galleryImagesGrid) {
        addGalleryImageBtn.addEventListener('click', function () {
            const picker = document.createElement('input');
            picker.type = 'file';
            picker.accept = 'image/*';
            picker.multiple = true;
            picker.className = 'hidden';

            picker.addEventListener('change', function () {
                const files = Array.from(this.files || []);
                if (files.length === 0) return;

                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const dt = new DataTransfer();
                    dt.items.add(file);

                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'gallery_images[]';
                    fileInput.className = 'hidden';
                    fileInput.files = dt.files;

                    const card = document.createElement('div');
                    card.className = 'gallery-item-card relative rounded-xl overflow-hidden border border-slate-200 bg-white aspect-video shadow-xs p-1.5 transition-all hover:shadow-md';

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        card.innerHTML = `
                            <div class="relative w-full h-full rounded-lg overflow-hidden bg-slate-900">
                                <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none"></div>
                                <button type="button" class="remove-gallery-btn absolute top-2 right-2 bg-red-600/95 hover:bg-red-700 text-white px-2 py-1 rounded-md shadow-md text-xs font-semibold flex items-center gap-1 transition-all cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Remove</span>
                                </button>
                                <span class="absolute bottom-1.5 left-2 right-2 text-white text-[10px] font-mono truncate">${file.name}</span>
                            </div>
                        `;
                        card.appendChild(fileInput);
                        galleryImagesGrid.appendChild(card);
                        updateGalleryState();
                    };
                    reader.readAsDataURL(file);
                });
            });

            document.body.appendChild(picker);
            picker.click();
            picker.remove();
        });
    }
});
</script>
@endsection
