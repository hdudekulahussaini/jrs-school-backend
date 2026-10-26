@extends('admin.layout')

@section('title', 'Edit Job Opening - Careers Page')
@section('header', 'Edit Job Opening')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.job-openings.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Job Openings</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Edit: {{ $opening->title }}</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Update job details, experience, qualification, or status.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-3xl">
        <form action="{{ route('admin.job-openings.update', $opening->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Position Title <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $opening->title) }}" required class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                        @error('title')
                            <p class="text-xs text-jrs-red mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Department / Wing
                        </label>
                        <input type="text" name="department" id="department" value="{{ old('department', $opening->department) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="job_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Job Type
                        </label>
                        <select name="job_type" id="job_type" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                            <option value="Full-Time" {{ old('job_type', $opening->job_type) === 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Part-Time" {{ old('job_type', $opening->job_type) === 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                            <option value="Contract" {{ old('job_type', $opening->job_type) === 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>

                    <div>
                        <label for="experience" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Experience Required
                        </label>
                        <input type="text" name="experience" id="experience" value="{{ old('experience', $opening->experience) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>

                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Display Order
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $opening->sort_order) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                <div>
                    <label for="qualification" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Required Qualification
                    </label>
                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $opening->qualification) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Role Overview & Key Responsibilities
                    </label>
                    <textarea name="description" id="description" rows="4" class="flex w-full rounded-md border border-slate-200 bg-white p-3 text-xs sm:text-sm shadow-xs">{{ old('description', $opening->description) }}</textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $opening->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-navy border-slate-300 focus:ring-jrs-navy cursor-pointer">
                    <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">
                        Active Position (Visible on Careers Page)
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.job-openings.index') }}" class="px-4 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-5 py-2 gap-2 cursor-pointer">
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
