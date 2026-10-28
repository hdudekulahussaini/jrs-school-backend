@extends('admin.layout')

@section('title', 'Add New Facility')
@section('header', 'Create Facility')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.facilities.index') }}" class="hover:text-slate-900 transition-colors">Facilities</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">New Facility</span>
        </div>
        <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card Container (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">New Facility Card</h3>
            <p class="text-sm text-slate-500 mt-1.5">
                Add an infrastructure card for the World-Class Facilities section with photo, wave theme, and icon.
            </p>
        </div>

        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Section 1: Title & Description -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">1. Basic Information</h4>
                </div>

                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium leading-none text-slate-700">Facility Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Smart Classrooms, Science & Computer Labs" class="flex h-9 w-full rounded-md border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    @error('title')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium leading-none text-slate-700">Short Description</label>
                    <textarea name="description" id="description" rows="2" placeholder="e.g. Modern and interactive learning spaces" class="flex min-h-[70px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('description') }}</textarea>
                    <p class="text-xs text-slate-500">Brief one-line summary displayed beneath the facility card title.</p>
                </div>

                <div class="space-y-2">
                    <label for="destination_url" class="text-sm font-medium leading-none text-slate-700">Destination URL</label>
                    <input type="text" name="destination_url" id="destination_url" value="{{ old('destination_url') }}" placeholder="e.g. /facilities/smart-classrooms or https://..." class="flex h-9 w-full rounded-md border @error('destination_url') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 font-mono">
                    <p class="text-xs text-slate-500">Optional internal path or external link when users click this facility card.</p>
                    @error('destination_url')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Visual Styling & Icon -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">2. Card Design & Floating Icon</h4>
                    <p class="text-xs text-slate-500">Matches the curved bottom wave and floating circular icon in the website design.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Wave Accent Color -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none text-slate-700">Bottom Wave Accent Color</label>
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <label class="relative flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-slate-900 has-[:checked]:ring-1 has-[:checked]:ring-slate-900">
                                <input type="radio" name="theme_color" value="navy" {{ old('theme_color', 'navy') === 'navy' ? 'checked' : '' }} class="text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-jrs-navy shrink-0"></span>
                                    <span class="text-xs font-semibold text-slate-800">Navy Wave</span>
                                </div>
                            </label>

                            <label class="relative flex items-center gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-slate-900 has-[:checked]:ring-1 has-[:checked]:ring-slate-900">
                                <input type="radio" name="theme_color" value="red" {{ old('theme_color') === 'red' ? 'checked' : '' }} class="text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-red-600 shrink-0"></span>
                                    <span class="text-xs font-semibold text-slate-800">Red Wave</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Badge Icon Input with Live Preview Box -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="icon" class="text-sm font-medium leading-none text-slate-700">
                                Badge Icon (Bootstrap Icon) <span class="text-red-500">*</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Overlapping badge icon on card</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div id="icon-preview-box" class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-lg shrink-0 shadow-xs transition-colors duration-200 {{ old('theme_color', 'navy') === 'red' ? 'bg-red-600' : 'bg-jrs-navy' }}">
                                <i id="icon-preview" class="{{ old('icon', 'bi bi-laptop') }}"></i>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-laptop') }}" placeholder="e.g. bi bi-laptop" class="flex h-10 w-full rounded-md border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 font-mono">
                            </div>
                        </div>
                        @error('icon')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
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
                        <button type="button" data-icon="bi bi-laptop" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-laptop text-slate-600"></i>
                            <span>Smart Classrooms</span>
                        </button>
                        <button type="button" data-icon="bi bi-flask" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-flask text-slate-600"></i>
                            <span>Science Labs</span>
                        </button>
                        <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-book-half text-slate-600"></i>
                            <span>Library & Books</span>
                        </button>
                        <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-trophy-fill text-slate-600"></i>
                            <span>Sports & Athletics</span>
                        </button>
                        <button type="button" data-icon="bi bi-bus-front-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-bus-front-fill text-slate-600"></i>
                            <span>School Transport</span>
                        </button>
                        <button type="button" data-icon="bi bi-buildings-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-buildings-fill text-slate-600"></i>
                            <span>Campus & Infrastructure</span>
                        </button>
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
                        <button type="button" data-icon="bi bi-shield-check" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-shield-check text-slate-600"></i>
                            <span>Safe & Secure</span>
                        </button>
                        <button type="button" data-icon="bi bi-person-badge-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-person-badge-fill text-slate-600"></i>
                            <span>1:25 Ratio</span>
                        </button>
                        <button type="button" data-icon="bi bi-lightbulb-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-lightbulb-fill text-slate-600"></i>
                            <span>STEM & Innovation</span>
                        </button>
                        <button type="button" data-icon="bi bi-tree-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                            <i class="bi bi-tree-fill text-slate-600"></i>
                            <span>Eco Campus</span>
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
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Facility Photograph -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">3. Facility Photograph</h4>
                    <p class="text-xs text-slate-500">Upload a crisp photo showing students or the facility in action.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Facility Photograph',
                    'aspect' => 'video',
                    'help' => 'Recommended: Crisp landscape photograph showing facility features (1200×800px).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 4: Display Order & Status -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">4. Display Settings</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div class="space-y-2">
                        <label for="sort_order" class="text-sm font-medium leading-none text-slate-700">Display Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        <p class="text-xs text-slate-500">Cards sequence in the carousel (1, 2, 3...).</p>
                    </div>

                    <!-- Switch -->
                    <div class="sm:pt-3">
                        <div class="flex items-center space-x-3 rounded-lg border border-slate-200 p-3 shadow-2xs bg-white">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900"></div>
                            </label>
                            <div class="space-y-0.5">
                                <span class="text-xs font-semibold text-slate-900">Publish Immediately</span>
                                <p class="text-[11px] text-slate-500">Visible in facilities showcase</p>
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
                    <span>Create Facility</span>
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
        const themeRadios = document.querySelectorAll('input[name="theme_color"]');

        function updateIconPreview(val) {
            if (!iconPreviewBox) return;
            if (!val || !val.trim()) {
                iconPreviewBox.innerHTML = '<i class="bi bi-laptop"></i>';
                return;
            }
            val = val.trim();
            if (val.startsWith('<')) {
                iconPreviewBox.innerHTML = val;
            } else {
                let cls = val;
                const legacyMap = {
                    'monitor': 'bi bi-laptop',
                    'flask': 'bi bi-flask',
                    'book': 'bi bi-book-half',
                    'trophy': 'bi bi-trophy-fill',
                    'bus': 'bi bi-bus-front-fill',
                    'school': 'bi bi-buildings-fill'
                };
                if (legacyMap[cls]) {
                    cls = legacyMap[cls];
                } else if (!cls.startsWith('bi ') && !cls.startsWith('fa-')) {
                    cls = 'bi bi-' + cls;
                }
                iconPreviewBox.innerHTML = '<i class="' + cls + '"></i>';
            }
        }

        function highlightActivePreset(currentVal) {
            if (!currentVal) return;
            const clean = currentVal.trim();
            presetButtons.forEach(btn => {
                const btnIcon = btn.getAttribute('data-icon');
                if (btnIcon === clean) {
                    btn.classList.add('border-rose-400', 'bg-rose-50', 'text-rose-700');
                    btn.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
                } else {
                    btn.classList.remove('border-rose-400', 'bg-rose-50', 'text-rose-700');
                    btn.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
                }
            });
        }

        function updateBoxThemeColor() {
            if (!iconPreviewBox) return;
            const selected = document.querySelector('input[name="theme_color"]:checked');
            if (selected && selected.value === 'red') {
                iconPreviewBox.classList.remove('bg-jrs-navy');
                iconPreviewBox.classList.add('bg-red-600');
            } else {
                iconPreviewBox.classList.remove('bg-red-600');
                iconPreviewBox.classList.add('bg-jrs-navy');
            }
        }

        if (iconInput) {
            iconInput.addEventListener('input', function() {
                updateIconPreview(this.value);
                highlightActivePreset(this.value);
            });
            updateIconPreview(iconInput.value);
            highlightActivePreset(iconInput.value);
        }

        themeRadios.forEach(radio => {
            radio.addEventListener('change', updateBoxThemeColor);
        });
        updateBoxThemeColor();

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
