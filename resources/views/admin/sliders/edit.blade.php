@extends('admin.layout')

@section('title', 'Edit Hero Slide #' . $slider->id)
@section('header', 'Edit Slide')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb & Actions (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.sliders.index') }}" class="hover:text-slate-900 transition-colors">Hero Sliders</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit #{{ $slider->id }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
                &larr; Back to list
            </a>
        </div>
    </div>

    <!-- Main Card Container (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900">Edit Hero Slide #{{ $slider->id }}</h3>
                <p class="text-sm text-slate-500 mt-1.5">
                    Update the typography, CTA buttons, background photograph, or order sequence.
                </p>
            </div>
            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $slider->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                {{ $slider->is_active ? 'Active' : 'Disabled' }}
            </div>
        </div>

        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Typography & Headings -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">1. Text & Headings</h4>
                </div>

                <div class="space-y-2">
                    <label for="badge_title" class="text-sm font-medium leading-none text-slate-700">Top Tagline / Badge</label>
                    <input type="text" name="badge_title" id="badge_title" value="{{ old('badge_title', $slider->badge_title) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="title" class="text-sm font-medium leading-none text-slate-700">Main Title (Line 1) <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $slider->title) }}" class="flex h-9 w-full rounded-md border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        @error('title')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="highlight_text" class="text-sm font-medium leading-none text-slate-700">Highlighted Title (Line 2 in Yellow)</label>
                        <input type="text" name="highlight_text" id="highlight_text" value="{{ old('highlight_text', $slider->highlight_text) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium leading-none text-slate-700">Paragraph Description</label>
                    <textarea name="description" id="description" rows="3" class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('description', $slider->description) }}</textarea>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Call-to-Action Buttons -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">2. Call-to-Action Buttons</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Primary Button -->
                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-600"></span>
                            <span class="text-xs font-semibold text-slate-900">Primary Button (Solid Red)</span>
                        </div>
                        <div class="space-y-1.5">
                            <label for="primary_button_text" class="text-xs font-medium text-slate-600">Button Label</label>
                            <input type="text" name="primary_button_text" id="primary_button_text" value="{{ old('primary_button_text', $slider->primary_button_text) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                            <p class="text-[11px] text-slate-500">CTA label on the solid red button.</p>
                        </div>
                    </div>

                    <!-- Secondary Button -->
                    <div class="rounded-lg border border-slate-200 bg-slate-50/50 p-4 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span class="text-xs font-semibold text-slate-900">Secondary Button (Transparent Glass)</span>
                        </div>
                        <div class="space-y-1.5">
                            <label for="secondary_button_text" class="text-xs font-medium text-slate-600">Button Label</label>
                            <input type="text" name="secondary_button_text" id="secondary_button_text" value="{{ old('secondary_button_text', $slider->secondary_button_text) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        </div>
                        <div class="space-y-1.5">
                            <label for="secondary_button_url" class="text-xs font-medium text-slate-600">Button Target URL</label>
                            <input type="text" name="secondary_button_url" id="secondary_button_url" value="{{ old('secondary_button_url', $slider->secondary_button_url) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Background Photograph -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">3. Background Photograph</h4>
                    <p class="text-xs text-slate-500">Replace current background photograph with instant preview before saving.</p>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Slide Photograph',
                    'current' => $slider->image_full_url ?? null,
                    'currentPath' => $slider->image_path ?? null,
                    'removeName' => 'remove_image',
                    'aspect' => 'banner',
                    'help' => 'Recommended: High-resolution school campus or activity image (1920×1080px).',
                    'urlField' => true,
                    'urlName' => 'image_url',
                    'urlValue' => old('image_url'),
                ])
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 4: Display Settings & Publish Switch -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">4. Display Settings</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                    <div class="space-y-2">
                        <label for="sort_order" class="text-sm font-medium leading-none text-slate-700">Display Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        <p class="text-xs text-slate-500">Order sequence (lower numbers first).</p>
                    </div>

                    <!-- Switch (shadcn/ui style Switch) -->
                    <div class="sm:pt-3">
                        <div class="flex items-center space-x-3 rounded-lg border border-slate-200 p-3 shadow-2xs bg-white">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900"></div>
                            </label>
                            <div class="space-y-0.5">
                                <span class="text-xs font-semibold text-slate-900">Slide Active</span>
                                <p class="text-[11px] text-slate-500">Published on site</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions (shadcn/ui CardFooter) -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-2">
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 transition-colors gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
