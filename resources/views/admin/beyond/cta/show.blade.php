@extends('admin.layout')

@section('title', 'CTA Banner Details')
@section('header', 'CTA Banner Details')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.beyond-classroom-cta.index') }}" class="text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to CTA Banners</span>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">
                    {{ $cta->title }} 
                    @if($cta->highlight_text)
                        <span class="text-amber-500">{{ $cta->highlight_text }}</span>
                    @endif
                </h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cta->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $cta->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    {{ $cta->is_active ? 'Active' : 'Disabled' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.beyond-classroom-cta.edit', $cta->id) }}" class="inline-flex items-center justify-center rounded-md text-xs sm:text-sm font-semibold transition-opacity bg-jrs-navy hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Banner</span>
            </a>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Content Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-5">
                <h3 class="text-base font-bold text-jrs-navy font-heading border-b border-slate-100 pb-3">Banner Typography & Buttons</h3>
                
                <div class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Headline</span>
                        <p class="font-bold text-base text-jrs-navy mt-1">
                            {{ $cta->title }}
                            @if($cta->highlight_text)
                                <span class="text-amber-500">{{ $cta->highlight_text }}</span>
                            @endif
                        </p>
                    </div>

                    @if($cta->badge)
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Badge Tag</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700 mt-1">
                                {{ $cta->badge }}
                            </span>
                        </div>
                    @endif

                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Subheading Description</span>
                        <p class="text-slate-700 mt-1 leading-relaxed">{{ $cta->description ?? '—' }}</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Artwork & Meta Card -->
        <div class="space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-jrs-navy font-heading border-b border-slate-100 pb-2">Artwork Photograph</h3>
                <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-900 aspect-16/9">
                    <img src="{{ $cta->image_full_url }}" alt="CTA" class="w-full h-full object-cover">
                </div>

                <div class="pt-3 border-t border-slate-100 text-xs space-y-2 text-slate-500">
                    <div class="flex items-center justify-between">
                        <span>Status:</span>
                        <span class="font-semibold {{ $cta->is_active ? 'text-emerald-600' : 'text-slate-500' }}">
                            {{ $cta->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Last Updated:</span>
                        <span class="text-slate-700">{{ $cta->updated_at?->diffForHumans() ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
