@extends('admin.layout')

@section('title', 'Add Work Culture & Benefit Card - Careers Page')
@section('header', 'Add Benefit Card')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-benefits.index') }}" class="text-xs text-slate-500 hover:text-jrs-navy font-medium flex items-center gap-1">
                    &larr; Back to Benefits
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-jrs-navy font-heading">Add Benefit Card</h2>
            <p class="text-xs text-slate-500">
                Create a card highlighting an aspect of school work culture (e.g. Collaborative Community, Continuous Growth).
            </p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.careers-benefits.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
            <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">
                Card Information
            </h3>

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="text-xs font-semibold text-slate-700">
                    Card Title <span class="text-jrs-red">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       placeholder="e.g. Collaborative Community"
                       required
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                @error('title')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icon Selector -->
            <div class="space-y-1.5">
                <label for="icon" class="text-xs font-semibold text-slate-700">
                    Icon Preset <span class="text-jrs-red">*</span>
                </label>
                <select id="icon" 
                        name="icon" 
                        required
                        class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    @foreach($icons as $key => $label)
                        <option value="{{ $key }}" {{ old('icon') == $key ? 'selected' : '' }}>
                            {{ $label }} ({{ $key }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-slate-500">Renders as a crisp white vector icon centered in a deep-navy circle matching the site design.</p>
                @error('icon')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="text-xs font-semibold text-slate-700">
                    Description <span class="text-jrs-red">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          required
                          placeholder="e.g. Work with passionate educators and supportive leadership."
                          class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section Badge -->
            <div class="space-y-1.5">
                <label for="badge" class="text-xs font-semibold text-slate-700">
                    Section Badge Reference
                </label>
                <input type="text" 
                       id="badge" 
                       name="badge" 
                       value="{{ old('badge', 'WORK CULTURE & BENEFITS') }}"
                       class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                <p class="text-[11px] text-slate-500">Default: WORK CULTURE & BENEFITS</p>
                @error('badge')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <!-- Sort Order -->
                <div class="space-y-1.5">
                    <label for="sort_order" class="text-xs font-semibold text-slate-700">Display Order</label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', $nextOrder) }}" 
                           min="0"
                           class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    <p class="text-[11px] text-slate-500">Lower numbers display first (e.g. 1, 2, 3, 4)</p>
                </div>

                <!-- Is Active -->
                <div class="flex items-center sm:pt-6">
                    <label class="relative inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="text-xs font-semibold text-slate-700">Display Live on Careers Page</span>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.careers-benefits.index') }}" class="px-4 py-2 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 text-xs font-semibold rounded-md bg-jrs-red text-white hover:opacity-90 shadow-xs">
                Save Benefit Card
            </button>
        </div>
    </form>

</div>
@endsection
