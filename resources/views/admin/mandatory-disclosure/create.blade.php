@extends('admin.layout')

@php
    $isGeneralInfo = ($category === 'general_info');
@endphp

@section('title', ($isGeneralInfo ? 'Add General Information Item' : 'Add Mandatory Disclosure Entry') . ' | JRS School Admin')
@section('header', $isGeneralInfo ? 'Add General Information' : 'Add Mandatory Disclosure Entry')

@section('content')
<div class="space-y-6 w-full">

    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.mandatory-disclosure.index', ['table' => $category ?? 'general_info']) }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
                    &larr; Back to {{ $isGeneralInfo ? 'General Information' : 'Mandatory Disclosure' }}
                </a>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 mt-1 font-heading">
                @if($category === 'general_info')
                    Add General Information Item
                @elseif($category === 'document')
                    Add Certificate / Document Entry
                @elseif($category === 'infrastructure')
                    Add School Infrastructure Item
                @elseif($category === 'smc')
                    Add School Management Committee Item
                @else
                    Add Mandatory Disclosure Entry
                @endif
            </h2>
            <p class="text-sm text-slate-500">
                @if($isGeneralInfo)
                    Enter S.NO, Information Title, and Details value.
                @else
                    Configure statutory information or attach downloadable document.
                @endif
            </p>
        </div>
    </div>

    <form action="{{ route('admin.mandatory-disclosure.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 bg-white border border-slate-200 rounded-2xl shadow-xs space-y-6">

            <!-- Category Hidden Input -->
            <input type="hidden" name="category" id="category" value="{{ old('category', $category ?? 'general_info') }}">

            @if(!$isGeneralInfo)
            <!-- Section Tab Indicator for Non-General Info -->
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Target Section:</span>
                    <span class="text-xs font-bold text-jrs-navy">
                        @if($category === 'document')
                            Table 2: Documents And Information
                        @elseif($category === 'infrastructure')
                            Table 3: School Infrastructure
                        @elseif($category === 'smc')
                            Table 4: School Management Committee (SMC)
                        @endif
                    </span>
                </div>
            </div>
            @endif

            <!-- Common Row: S.NO and Title -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label for="s_no" class="block text-xs font-semibold text-slate-700">S. NO.</label>
                    <input type="text" id="s_no" name="s_no" value="{{ old('s_no') }}" placeholder="e.g. 1" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>

                <div class="sm:col-span-3 space-y-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        <span>{{ $isGeneralInfo ? 'Information' : 'Title / Description' }}</span> <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="{{ $isGeneralInfo ? 'e.g. Name of the School or Affiliation No.' : 'e.g. Copies of Affiliation / Upgradation Letter' }}" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>
            </div>

            <!-- Details / Value (For General Info and Infrastructure) -->
            @if($isGeneralInfo || $category === 'infrastructure')
            <div class="space-y-1.5">
                <label for="value" class="block text-xs font-semibold text-slate-700">
                    <span>Details</span> @if($isGeneralInfo)<span class="text-rose-500">*</span>@endif
                </label>
                <textarea id="value" name="value" rows="3" {{ $isGeneralInfo ? 'required' : '' }} placeholder="{{ $isGeneralInfo ? 'e.g. JRS INTERNATIONAL SCHOOL or Sy. No. 129, Narapally...' : 'e.g. 12,477 Sq. Mtr. (3.08 Acres) or 22 Classrooms' }}" class="w-full p-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">{{ old('value') }}</textarea>
            </div>
            @endif

            <!-- Document Upload & Link Fields -->
            @if($category === 'document')
            <div class="space-y-4 pt-2 border-t border-slate-100">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        <span>Upload PDF Document</span> <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="file" name="file_upload" accept=".pdf" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                    <p class="text-[11px] text-slate-400">Upload CBSE certificate / statutory record. Accepted format: PDF only (Max 20MB).</p>
                </div>
            </div>
            @elseif($category === 'infrastructure' || $category === 'smc')
            <div class="space-y-4 pt-2 border-t border-slate-100">
                <div class="space-y-1.5">
                    <label for="button_label" class="block text-xs font-semibold text-slate-700">
                        Action Button Label <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="text" id="button_label" name="button_label" value="{{ old('button_label') }}" placeholder="e.g. Land Certificate or Watch Video" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">Label shown on the button (e.g. "Land Certificate" for Row 1, "Watch Video" for Row 7).</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Upload Document / PDF <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="file" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.png" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy/10 file:text-jrs-navy hover:file:bg-jrs-navy/20 cursor-pointer">
                    <p class="text-[11px] text-slate-400">Upload Land Certificate or safety document. Accepted formats: PDF, DOC, JPG, PNG (Max 20MB).</p>
                </div>

                <div class="space-y-1.5">
                    <label for="file_url" class="block text-xs font-semibold text-slate-700">
                        YouTube Video Link or External URL <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="url" id="file_url" name="file_url" value="{{ old('file_url') }}" placeholder="https://www.youtube.com/watch?v=... or https://..." class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                    <p class="text-[11px] text-slate-400">For inspection video (Row 7), paste the YouTube video link here.</p>
                </div>
            </div>
            @endif

            @if($category === 'smc')
            <hr class="border-slate-100">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div class="space-y-1.5">
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700">Display Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $nextOrder) }}" min="0" class="w-full h-10 px-3.5 rounded-xl border border-slate-200 bg-white text-sm shadow-xs focus:outline-none focus:ring-2 focus:ring-jrs-navy/20 focus:border-jrs-navy">
                </div>

                <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start gap-3 mt-4 sm:mt-0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                    <div>
                        <label for="is_active" class="text-xs font-bold text-slate-800 cursor-pointer">Published / Active</label>
                        <p class="text-[11px] text-slate-400">Display this row on the public website table.</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.mandatory-disclosure.index', ['table' => $category ?? 'general_info']) }}" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-navy hover:opacity-95 text-white transition-all shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Save Entry</span>
            </button>
        </div>

    </form>
</div>
@endsection
