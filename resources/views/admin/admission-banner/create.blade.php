@extends('admin.layout')

@section('title', 'Add Admission Banner')
@section('header', 'Create Admission Banner (CTA)')

@section('content')
<div class="space-y-6 w-full">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-jrs-navy font-heading">New Admission CTA Banner</h2>
            <p class="text-xs text-slate-500 mt-0.5">Create a new admission call-to-action banner for the website.</p>
        </div>
        <a href="{{ route('admin.admission-banner.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Overview</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <form action="{{ route('admin.admission-banner.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Typography Section -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 font-heading border-b border-slate-100 pb-2">Banner Typography</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label for="title" class="block text-xs font-bold text-slate-700">Main Heading <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy transition-all @error('title') border-red-500 @enderror"
                               placeholder="e.g. Give Your Child A Strong Foundation">
                        @error('title')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="title_highlight" class="block text-xs font-bold text-amber-600">Highlight Text (Amber)</label>
                        <input type="text" name="title_highlight" id="title_highlight" value="{{ old('title_highlight') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-amber-300 text-sm text-amber-800 bg-amber-50/30 focus:outline-hidden focus:ring-2 focus:ring-amber-400/30 focus:border-amber-500 transition-all @error('title_highlight') border-red-500 @enderror"
                               placeholder="e.g. For Tomorrow">
                        @error('title_highlight')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="description" class="block text-xs font-bold text-slate-700">Subtitle / Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-hidden focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy transition-all @error('description') border-red-500 @enderror"
                              placeholder="e.g. Join JRS International School and be a part of a nurturing environment...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Background Photograph Upload Section -->
            <div>
                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Background Photograph',
                    'current' => null,
                    'currentPath' => null,
                    'aspect' => 'banner',
                    'help' => 'High-resolution horizontal photograph recommended. JPG, PNG, WEBP (Max 10MB).',
                ])
            </div>

            <!-- Status Checkbox -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                    <label for="is_active" class="text-xs font-bold text-slate-800 block cursor-pointer">Set as Active Banner</label>
                    <p class="text-[11px] text-slate-500 mt-0.5">Activating this banner will make it the live CTA across the website.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Action Buttons (No Delete Option) -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.admission-banner.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-red-700 text-white shadow-xs transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Create Banner</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
