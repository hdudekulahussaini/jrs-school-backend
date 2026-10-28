@extends('admin.layout')

@section('title', 'New Teaching at JRS Section')
@section('header', 'New Teaching Section')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-teaching.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Teaching at JRS</span>
                </a>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">New Teaching Section Copy</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Configure headline, red highlighted phrases, description, and school campus photograph.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.careers-teaching.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Typography & Headlines Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Headline & Highlights</h3>
                    <p class="text-xs text-slate-500">Configure top red badge, headline, and red emphasized words.</p>
                </div>

                <!-- Badge & Full Title -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Top Red Pill Badge
                        </label>
                        <input type="text" name="badge" id="badge" value="{{ old('badge', 'TEACHING AT JRS') }}" placeholder="e.g. TEACHING AT JRS" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Full Headline <span class="text-jrs-red">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', 'Grow. Teach. Inspire. Make A Difference.') }}" required placeholder="e.g. Grow. Teach. Inspire. Make A Difference." class="flex h-9 w-full rounded-md border {{ $errors->has('title') ? 'border-jrs-red ring-1 ring-jrs-red' : 'border-slate-200' }} bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                    </div>
                </div>

                <!-- Red Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="highlight_1" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Highlight 1 (Rendered in Red)
                        </label>
                        <input type="text" name="highlight_1" id="highlight_1" value="{{ old('highlight_1', 'Inspire.') }}" placeholder="e.g. Inspire." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <p class="text-[11px] text-slate-400 mt-1">Highlighted in crimson red in the headline.</p>
                    </div>

                    <div>
                        <label for="highlight_2" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Highlight 2 (Rendered in Red)
                        </label>
                        <input type="text" name="highlight_2" id="highlight_2" value="{{ old('highlight_2', 'Difference.') }}" placeholder="e.g. Difference." class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                        <p class="text-[11px] text-slate-400 mt-1">Highlighted in crimson red in the headline.</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Description Paragraph <span class="text-jrs-red">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required placeholder="We believe that the teacher community at JRS is our unique asset..." class="flex w-full rounded-md border border-slate-200 bg-white p-3 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">{{ old('description', 'We believe that the teacher community at JRS is our unique asset. Here, teachers are given the push to innovate, create, and approach teaching methodology through interactive and research-based methods. Teacher Development programs are constantly conducted to enhance our teachers with the latest developments in the field of education. Teacher seminars, events, and workshops are organized on-campus periodically through professional training centers.') }}</textarea>
                </div>
            </div>

            <!-- Contact & Image Card -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-jrs-navy font-heading">Artwork & Resume Contact</h3>
                    <p class="text-xs text-slate-500">Campus photograph and contact details for applicants.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="apply_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Resume Submission Email
                        </label>
                        <input type="email" name="apply_email" id="apply_email" value="{{ old('apply_email', 'careers@jrsschool.com') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs font-mono">
                    </div>

                    <div>
                        <label for="apply_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            HR / Contact Phone
                        </label>
                        <input type="text" name="apply_phone" id="apply_phone" value="{{ old('apply_phone', '+91 98765 43210') }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-xs sm:text-sm shadow-xs">
                    </div>
                </div>

                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'image_file',
                        'id' => 'image_file',
                        'label' => 'School Campus Photo (Optional)',
                        'aspect' => 'landscape',
                        'help' => 'Leave blank to use the default JRS International School campus photograph.',
                    ])
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded text-jrs-navy border-slate-300 focus:ring-jrs-navy cursor-pointer">
                    <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">
                        Set as Active Section on Careers Page
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.careers-teaching.index') }}" class="px-4 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-5 py-2 gap-2 cursor-pointer">
                    <span>Create Section Copy</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
