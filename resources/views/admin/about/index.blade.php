@extends('admin.layout')

@section('title', 'About JRS Management')
@section('header', 'About JRS Section')

@section('content')
<div class="space-y-6">

    @if(!$about)
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200/80 shadow-xs">
            <p class="font-medium text-slate-700 text-sm">No About Section content configured</p>
            <a href="{{ route('admin.about.create') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-jrs-red text-white hover:bg-jrs-red-dark transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Create Section</span>
            </a>
        </div>
    @else
        <!-- Details Table & Field Summary -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 font-heading text-base">Field Configuration & Content Data</h3>
                    <span class="text-xs text-slate-400">ID #{{ $about->id }} • Updated {{ $about->updated_at->diffForHumans() }}</span>
                </div>
                <a href="{{ route('admin.about.edit', $about->id) }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Edit Content</span>
                </a>
            </div>

            <div class="divide-y divide-slate-100 text-sm">
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Eyebrow / Tagline</span>
                    <span class="sm:col-span-3 font-semibold text-slate-800">{{ $about->tagline }}</span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Main Title</span>
                    <span class="sm:col-span-3 font-bold text-slate-900">{{ $about->title }}</span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Highlight Red Title</span>
                    <span class="sm:col-span-3 font-bold text-jrs-red">{{ $about->title_highlight }}</span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Paragraph 1</span>
                    <span class="sm:col-span-3 text-slate-700 leading-relaxed text-xs">{{ $about->description_p1 }}</span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Paragraph 2</span>
                    <span class="sm:col-span-3 text-slate-700 leading-relaxed text-xs">{{ $about->description_p2 }}</span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Action Button</span>
                    <span class="sm:col-span-3 font-medium text-slate-800">{{ $about->button_text }} &rarr; <code class="text-xs text-blue-600">{{ $about->button_link }}</code></span>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2 items-center">
                    <span class="text-xs font-bold text-slate-500 uppercase">Image 1 (Students)</span>
                    <div class="sm:col-span-3 flex items-center gap-3">
                        @if($about->image_1_url)
                            <img src="{{ $about->image_1_url }}" alt="Image 1" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0">
                            <span class="text-xs text-slate-700 font-medium">{{ basename($about->image_1_url) }}</span>
                        @else
                            <span class="text-xs text-slate-400">None uploaded</span>
                        @endif
                    </div>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2 items-center">
                    <span class="text-xs font-bold text-slate-500 uppercase">Image 2 (Campus)</span>
                    <div class="sm:col-span-3 flex items-center gap-3">
                        @if($about->image_2_url)
                            <img src="{{ $about->image_2_url }}" alt="Image 2" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0">
                            <span class="text-xs text-slate-700 font-medium">{{ basename($about->image_2_url) }}</span>
                        @else
                            <span class="text-xs text-slate-400">None uploaded</span>
                        @endif
                    </div>
                </div>
                <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-500 uppercase">Video Showcase</span>
                    <span class="sm:col-span-3 text-xs text-slate-700">
                        {{ $about->video_title }} <br>
                        <a href="{{ $about->video_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $about->video_url }}</a>
                    </span>
                </div>
            </div>

            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.about.edit', $about->id) }}" class="px-5 py-2 rounded-xl text-xs font-bold bg-jrs-navy text-white hover:bg-jrs-navy-dark transition-all">
                    Edit All Fields
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
