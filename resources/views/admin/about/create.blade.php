@extends('admin.layout')

@section('title', 'Create About Section')
@section('header', 'Create About Content')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.about.index') }}" class="hover:text-slate-800">About JRS</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">New Entry</span>
        </div>
        <a href="{{ route('admin.about.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to Overview</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <h3 class="text-lg font-bold text-slate-900 font-heading mb-6 pb-4 border-b border-slate-100">
            Create About JRS Section Content
        </h3>

        <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section Eyebrow & Titles -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Eyebrow Tagline <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tagline" value="{{ old('tagline', 'ABOUT JRS') }}" required placeholder="ABOUT JRS" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Main Heading <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', 'A Legacy Of Excellence') }}" required placeholder="A Legacy Of Excellence" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Red Accent Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_highlight" value="{{ old('title_highlight', 'In Education') }}" required placeholder="In Education" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
            </div>

            <!-- Description Paragraph 1 -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    First Paragraph (School Vision & Academics) <span class="text-red-500">*</span>
                </label>
                <textarea name="description_p1" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red leading-relaxed">{{ old('description_p1', 'JRS International School, Uppal, Hyderabad is committed to providing quality education with a perfect blend of academics, values and co-curricular activities. We focus on developing confident, responsible and compassionate individuals who are prepared for a constantly evolving world.') }}</textarea>
            </div>

            <!-- Description Paragraph 2 -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Second Paragraph (Pedagogy, Labs & Sports)
                </label>
                <textarea name="description_p2" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red leading-relaxed">{{ old('description_p2', 'Rooted in rich Indian ethos and empowered by global pedagogical standards, our campus provides modern smart classrooms, advanced robotics and science laboratories, sports coaching, and a holistic environment where every student thrives.') }}</textarea>
            </div>

            <!-- Button CTA & Link -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', 'Read more') }}" placeholder="Read more" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Button Link URL</label>
                    <input type="text" name="button_link" value="{{ old('button_link', '/about') }}" placeholder="/about" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
            </div>

            <!-- Images Upload Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                <!-- Image 1 -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Students Image (Image 1)
                    </label>
                    <input type="file" name="image_1_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:bg-jrs-navy-dark cursor-pointer border border-slate-200 rounded-xl p-1.5 bg-white">
                    <p class="text-[11px] text-slate-400 mt-1">Upload an image file (JPG, PNG, WebP).</p>
                </div>

                <!-- Image 2 -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Campus Building Image (Image 2)
                    </label>
                    <input type="file" name="image_2_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-jrs-navy file:text-white hover:file:bg-jrs-navy-dark cursor-pointer border border-slate-200 rounded-xl p-1.5 bg-white">
                    <p class="text-[11px] text-slate-400 mt-1">Upload an image file (JPG, PNG, WebP).</p>
                </div>
            </div>

            <!-- Video Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Video Box Title</label>
                    <input type="text" name="video_title" value="{{ old('video_title', 'Watch a video about how we work and try for our students') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Video URL (YouTube or MP4)</label>
                    <input type="text" name="video_url" value="{{ old('video_url', 'https://www.youtube.com') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.about.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Create & Publish</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
