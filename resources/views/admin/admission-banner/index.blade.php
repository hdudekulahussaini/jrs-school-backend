@extends('admin.layout')

@section('title', 'Admission Banner')
@section('header', 'Admission Banner (CTA)')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    @if($banner)
    <!-- Field Configuration & Content Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Field Configuration & Content Data</h3>
                <span class="text-xs text-slate-400">ID #{{ $banner->id }} • Updated {{ $banner->updated_at->diffForHumans() }}</span>
            </div>
            <a href="{{ route('admin.admission-banner.edit', $banner->id) }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-red-700 text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Content</span>
            </a>
        </div>

        <div class="divide-y divide-slate-100 text-sm">
            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Main Heading</span>
                <span class="sm:col-span-3 font-bold text-slate-900">{{ $banner->title }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Highlight Text (Amber)</span>
                <span class="sm:col-span-3 font-bold text-amber-500">{{ $banner->title_highlight ?? '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Description / Paragraph</span>
                <span class="sm:col-span-3 text-slate-700 leading-relaxed text-xs">{{ $banner->description ?? '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Primary Button</span>
                <div class="sm:col-span-3 text-xs flex items-center">
                    <span class="font-bold text-jrs-red">{{ $banner->primary_button_text }}</span>
                    @if($banner->primary_button_link)
                        <span class="text-slate-400 mx-2">&rarr;</span>
                        <code class="text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $banner->primary_button_link }}</code>
                    @endif
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Secondary Button</span>
                <div class="sm:col-span-3 text-xs">
                    <span class="font-bold text-slate-800">{{ $banner->secondary_button_text }}</span>
                    <span class="text-slate-400 mx-2">&rarr;</span>
                    <code class="text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $banner->secondary_button_link }}</code>
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-2 items-center">
                <span class="text-xs font-bold text-slate-500 uppercase">Background Image</span>
                <div class="sm:col-span-3 flex items-center gap-3">
                    @if($banner->image_full_url)
                        <img src="{{ $banner->image_full_url }}" alt="Background" class="w-20 h-12 rounded-lg object-cover border border-slate-200 shrink-0">
                        <span class="text-xs text-slate-600 font-mono">{{ $banner->image_path }}</span>
                    @else
                        <span class="text-xs text-slate-400">None</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
        No admission banner record found. Run <code class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-xs font-mono">php artisan db:seed --class=AdmissionBannerSeeder</code> to seed default data.
    </div>
    @endif

</div>
@endsection
