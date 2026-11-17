@extends('admin.layout')

@section('title', 'Teaching at JRS Section Details')
@section('header', 'Teaching Section Details')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.careers-teaching.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Teaching at JRS</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">{{ $section->title }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $section->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $section->is_active ? 'Active' : 'Disabled' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.careers-teaching.edit', $section->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-navy hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Section</span>
            </a>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Content Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <h3 class="text-base font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">Typography & Messaging</h3>
                
                <div class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Heading</span>
                        <p class="font-bold text-lg text-jrs-navy mt-1 leading-snug">
                            {{ $section->title }}
                        </p>
                    </div>

                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Paragraph</span>
                        <p class="text-slate-700 mt-1 leading-relaxed text-sm whitespace-pre-line">{{ $section->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campus Image Card -->
        <div class="space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-2">Campus Photograph</h3>
                <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-100 aspect-16/10">
                    <img src="{{ $section->image_full_url }}" alt="Campus" class="w-full h-full object-cover">
                </div>

                <div class="pt-3 border-t border-slate-100 text-xs space-y-2 text-slate-500">
                    <div class="flex items-center justify-between">
                        <span>Status:</span>
                        <span class="font-semibold {{ $section->is_active ? 'text-emerald-600' : 'text-slate-500' }}">
                            {{ $section->is_active ? 'Active on Careers Page' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Last Updated:</span>
                        <span class="text-slate-700">{{ $section->updated_at?->diffForHumans() ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
