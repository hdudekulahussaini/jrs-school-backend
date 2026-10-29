@extends('admin.layout')

@section('title', 'Add Beyond Classroom Activity')
@section('header', 'Add Beyond Classroom Activity')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Beyond Classroom Page</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Add Beyond Classroom Activity</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure a new co-curricular activity card with badge text, normal text, icon, and image.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="w-full">
        <form action="{{ route('admin.beyond-classrooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Text Information Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Activity Information</h3>
                    <p class="text-xs text-slate-500">Provide the badge text and main text for this activity card.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Normal Text (Title) -->
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Normal Text / Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g. Athletics & Sports, Dance, Music" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Badge Text (Category) -->
                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Badge Text
                        </label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="e.g. Sports, Rhythm & Grace, Performing Arts" class="flex h-9 w-full rounded-md border {{ $errors->has('category') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        @error('category')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 2. Icon Selection Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Activity Icon</h3>
                    <p class="text-xs text-slate-500">Choose a preset icon or enter a custom Bootstrap icon class.</p>
                </div>

                <div class="space-y-4">
                    <!-- Input row with Icon Preview Badge -->
                    <div class="flex items-center gap-3">
                        <div id="icon-preview-box" class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-800 text-2xl shrink-0 shadow-2xs transition-all">
                            <i id="icon-preview" class="bi bi-trophy-fill"></i>
                        </div>
                        <div class="flex-1">
                            <input type="text" name="icon" id="icon" value="{{ old('icon', 'bi bi-trophy-fill') }}" placeholder="bi bi-trophy-fill, bi bi-music-note-beamed, etc." class="flex h-11 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:border-transparent font-mono">
                        </div>
                    </div>
                    @error('icon')
                        <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Quick Presets -->
                    <div class="space-y-2 pt-1">
                        <div class="text-xs font-semibold text-slate-600">Quick Presets for Beyond Classroom</div>
                        <div class="flex flex-wrap gap-2" id="icon-presets">
                            <button type="button" data-icon="bi bi-trophy-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-trophy-fill text-slate-600"></i>
                                <span>Sports & Athletics</span>
                            </button>
                            <button type="button" data-icon="bi bi-palette-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-palette-fill text-slate-600"></i>
                                <span>Art & Painting</span>
                            </button>
                            <button type="button" data-icon="bi bi-music-note-beamed" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-music-note-beamed text-slate-600"></i>
                                <span>Music</span>
                            </button>
                            <button type="button" data-icon="bi bi-person-arms-up" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-person-arms-up text-slate-600"></i>
                                <span>Dance</span>
                            </button>
                            <button type="button" data-icon="bi bi-shield-shaded" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-shield-shaded text-slate-600"></i>
                                <span>Karate & Martial Arts</span>
                            </button>
                            <button type="button" data-icon="bi bi-heart-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-heart-fill text-slate-600"></i>
                                <span>Yoga & Wellness</span>
                            </button>
                            <button type="button" data-icon="bi bi-lightning-charge-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-lightning-charge-fill text-slate-600"></i>
                                <span>Roller Skating</span>
                            </button>
                            <button type="button" data-icon="bi bi-flask" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-flask text-slate-600"></i>
                                <span>Science Activities</span>
                            </button>
                            <button type="button" data-icon="bi bi-robot" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-robot text-slate-600"></i>
                                <span>Robotics & STEM</span>
                            </button>
                            <button type="button" data-icon="bi bi-compass" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-compass text-slate-600"></i>
                                <span>Excursions & Tours</span>
                            </button>
                            <button type="button" data-icon="bi bi-people-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-people-fill text-slate-600"></i>
                                <span>Clubs & Leadership</span>
                            </button>
                            <button type="button" data-icon="bi bi-camera-reels-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-camera-reels-fill text-slate-600"></i>
                                <span>Media & Photography</span>
                            </button>
                            <button type="button" data-icon="bi bi-book-half" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-book-half text-slate-600"></i>
                                <span>Creative Writing</span>
                            </button>
                            <button type="button" data-icon="bi bi-mic-fill" class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                <i class="bi bi-mic-fill text-slate-600"></i>
                                <span>Debating & Drama</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Image Upload Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Activity Image</h3>
                    <p class="text-xs text-slate-500">Upload a photograph representing this activity.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Activity Photograph',
                    'aspect' => 'video',
                    'help' => 'Supported: WEBP, JPG, PNG up to 5MB (recommended 16:9 landscape).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.beyond-classrooms.index') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-10 px-5 py-2 gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Create Activity</span>
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

    const aliasMap = {
        'trophy': 'bi bi-trophy-fill',
        'sports': 'bi bi-trophy-fill',
        'palette': 'bi bi-palette-fill',
        'art': 'bi bi-palette-fill',
        'music': 'bi bi-music-note-beamed',
        'dance': 'bi bi-person-arms-up',
        'shield': 'bi bi-shield-shaded',
        'karate': 'bi bi-shield-shaded',
        'heart': 'bi bi-heart-fill',
        'yoga': 'bi bi-heart-fill',
        'skating': 'bi bi-lightning-charge-fill',
        'flask': 'bi bi-flask',
        'science': 'bi bi-flask',
        'robot': 'bi bi-robot',
        'compass': 'bi bi-compass',
        'tours': 'bi bi-compass',
        'users': 'bi bi-people-fill',
        'people': 'bi bi-people-fill',
        'leadership': 'bi bi-people-fill',
        'camera': 'bi bi-camera-reels-fill',
        'book': 'bi bi-book-half',
        'mic': 'bi bi-mic-fill',
    };

    function updatePreview(val) {
        val = (val || '').trim();
        if (!val) {
            previewBox.innerHTML = '<i class="bi bi-question-circle text-slate-400"></i>';
            return;
        }

        let iconClass = val;
        if (aliasMap[val]) {
            iconClass = aliasMap[val];
        } else if (!val.includes(' ') && !val.includes('-')) {
            iconClass = 'bi bi-' + val;
        }

        previewBox.innerHTML = '<i class="' + iconClass + '"></i>';

        presetBtns.forEach(btn => {
            const dataIcon = btn.getAttribute('data-icon');
            if (dataIcon === val || dataIcon === iconClass) {
                btn.classList.add('bg-slate-900', 'border-slate-900', 'text-white', 'font-semibold');
                btn.classList.remove('bg-white', 'text-slate-700');
            } else {
                btn.classList.remove('bg-slate-900', 'border-slate-900', 'text-white', 'font-semibold');
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
