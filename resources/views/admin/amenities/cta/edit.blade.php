@extends('admin.layout')

@section('title', 'Edit Amenities CTA Banner')
@section('header', 'Edit Amenities CTA Banner')

@section('content')
<div class="space-y-6 w-full">

    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.amenities-cta.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-medium flex items-center gap-1">
                    &larr; Back to CTA Banners
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Edit Amenities CTA Banner</h2>
            <p class="text-xs text-slate-500">
                Update banner #{{ $cta->id }}: <span class="font-semibold text-jrs-navy">{{ $cta->title }}</span>
            </p>
        </div>
    </div>

    <form action="{{ route('admin.amenities-cta.update', $cta->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
            <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">
                Banner Content
            </h3>

            <!-- Eyebrow Badge -->
            <div class="space-y-1.5">
                <label for="badge" class="text-xs font-semibold text-slate-700">Eyebrow Badge</label>
                <input type="text" 
                       id="badge" 
                       name="badge" 
                       value="{{ old('badge', $cta->badge) }}" 
                       placeholder="e.g. JOIN THE JRS JOURNEY"
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                @error('badge')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="text-xs font-semibold text-slate-700">Headline <span class="text-jrs-red">*</span></label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $cta->title) }}" 
                       required
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                @error('title')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Highlight Accent -->
            <div class="space-y-1.5">
                <label for="highlight_text" class="text-xs font-semibold text-slate-700">
                    Highlighted Word (Rendered in Amber/Gold)
                </label>
                <input type="text" 
                       id="highlight_text" 
                       name="highlight_text" 
                       value="{{ old('highlight_text', $cta->highlight_text) }}" 
                       placeholder="e.g. Excellence."
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                <p class="text-[11px] text-slate-500">The exact text in the headline that will be colored in bright yellow/gold.</p>
                @error('highlight_text')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-semibold text-slate-700">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('description', $cta->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.amenities-cta.index') }}" class="px-4 py-2 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 text-xs font-semibold rounded-md bg-jrs-red text-white hover:opacity-90 shadow-xs">
                Update CTA Banner
            </button>
        </div>
    </form>

</div>
@endsection
