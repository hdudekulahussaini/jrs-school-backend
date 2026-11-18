@extends('admin.layout')

@section('title', 'Add Why Choose Feature')
@section('header', 'New Feature / Badge')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.why-choose.index') }}" class="hover:text-slate-900">Why Choose JRS</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">New Feature</span>
        </div>

        <a href="{{ route('admin.why-choose.index') }}"
           class="rounded-md text-xs border border-slate-200 bg-white px-3 py-2 text-slate-700 hover:bg-slate-50">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">

        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-semibold text-slate-900 font-heading">
                New Feature Card
            </h3>
            <p class="text-sm text-slate-500 mt-1.5">
                Add a card to the "What Makes JRS Different?" section with title, description, and icon badge.
            </p>
        </div>

        <form action="{{ route('admin.why-choose.store') }}"
              method="POST"
              class="p-6 space-y-6">

            @csrf

            <!-- Title -->
            <div class="space-y-4">

                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium text-slate-700">
                        Card Title <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        required
                        value="{{ old('title') }}"
                        placeholder="e.g. Academic Excellence"
                        class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-slate-950">

                    @error('title')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        placeholder="Enter feature description"
                        class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-950">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="border-t border-slate-100"></div>

            <!-- Icon Selection -->
            <div class="space-y-3">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <label for="icon" class="text-sm font-semibold text-slate-800">
                        Badge Icon (Bootstrap Icon)
                        <span class="text-rose-500">*</span>
                    </label>

                    <span class="text-xs text-slate-400">
                        Select an icon or enter its class
                    </span>
                </div>

                <!-- Icon Preview -->
                <div class="flex items-center gap-3">

                    <div id="icon-preview-box"
                         class="w-11 h-11 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 text-xl shrink-0">
                        <i id="icon-preview" class="bi bi-trophy-fill"></i>
                    </div>

                    <div class="flex-1">
                        <input
                            type="text"
                            name="icon"
                            id="icon"
                            required
                            value="{{ old('icon', 'bi bi-trophy-fill') }}"
                            placeholder="bi bi-trophy-fill"
                            class="h-11 w-full rounded-lg border border-slate-200 px-3.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-slate-900">
                    </div>

                </div>

                @error('icon')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <!-- Quick Presets -->
                <div class="space-y-2 pt-1">
                    <div class="text-xs font-semibold text-slate-600">
                        Quick Presets
                    </div>

                    @php
                        $icons = [
                            ['bi bi-trophy-fill', 'Academic Excellence'],
                            ['bi bi-share-fill', 'Holistic Development'],
                            ['bi bi-buildings-fill', 'Best Infrastructure'],
                            ['bi bi-person-heart', 'Personal Attention'],
                            ['bi bi-shield-check', 'Safe & Secure'],
                            ['bi bi-people-fill', 'Student Support'],
                            ['bi bi-laptop', 'Professional Development'],
                            ['bi bi-patch-check-fill', 'Quality Assessment'],
                            ['bi bi-book-half', 'Library Resources'],
                            ['bi bi-bus-front-fill', 'Field Trips'],
                            ['bi bi-compass-fill', 'Career Guidance'],
                            ['bi bi-palette-fill', 'Performing Arts'],
                            ['bi bi-award-fill', 'Sports Education'],
                            ['bi bi-tree-fill', 'Eco Campus'],
                            ['bi bi-lightbulb-fill', 'STEM & Innovation'],
                            ['bi bi-moisture', 'Science Labs'],
                            ['bi bi-music-note-beamed', 'Music & Band'],
                            ['bi bi-globe-americas', 'Global Vision'],
                            ['bi bi-heart-pulse-fill', 'Health & Wellness'],
                            ['bi bi-cup-hot-fill', 'Dining & Nutrition'],
                            ['bi bi-activity', 'Martial Arts & Skating'],
                            ['bi bi-robot', 'Robotics & AI'],
                            ['bi bi-chat-quote-fill', 'Public Speaking'],
                            ['bi bi-stars', 'Values & Ethos'],
                        ];
                    @endphp

                    <div class="flex flex-wrap gap-2" id="icon-presets">

                        @foreach($icons as $icon)
                            <button
                                type="button"
                                data-icon="{{ $icon[0] }}"
                                class="icon-preset-btn border border-slate-200 bg-white px-3 py-1.5 rounded-full text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5">

                                <i class="{{ $icon[0] }}"></i>
                                <span>{{ $icon[1] }}</span>

                            </button>
                        @endforeach

                    </div>
                </div>

            </div>

            <div class="border-t border-slate-100"></div>

            <!-- Display Order -->
            <div>
                <div class="space-y-2 max-w-xs">

                    <label for="sort_order" class="text-sm font-medium text-slate-700">
                        Display Order
                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        min="0"
                        value="{{ old('sort_order', $nextOrder) }}"
                        class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-slate-950">

                    @error('sort_order')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>
            </div>

            <!-- Buttons -->
            <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">

                <a href="{{ route('admin.why-choose.index') }}"
                   class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-md bg-slate-900 text-white h-9 px-4 py-2 text-sm hover:bg-slate-800">
                    Save Feature Item
                </button>

            </div>

        </form>
    </div>
</div>

<!-- Icon Preview Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const iconInput = document.getElementById('icon');
    const previewBox = document.getElementById('icon-preview-box');
    const presetButtons = document.querySelectorAll('.icon-preset-btn');

    if (!iconInput || !previewBox) return;

    function updatePreview(value) {

        const iconClass = (value || '').trim() || 'bi bi-stars';

        // Only accept Bootstrap icon class names in this field.
        previewBox.innerHTML = '';

        const icon = document.createElement('i');
        icon.className = iconClass;
        previewBox.appendChild(icon);

        presetButtons.forEach(button => {

            const selected = button.dataset.icon === iconClass;

            button.classList.toggle('bg-rose-50', selected);
            button.classList.toggle('border-rose-300', selected);
            button.classList.toggle('text-rose-700', selected);
            button.classList.toggle('font-semibold', selected);

        });
    }

    presetButtons.forEach(button => {

        button.addEventListener('click', function () {

            const iconValue = this.dataset.icon;

            iconInput.value = iconValue;
            updatePreview(iconValue);

        });

    });

    iconInput.addEventListener('input', function () {
        updatePreview(this.value);
    });

    updatePreview(iconInput.value);

});
</script>

@endsection