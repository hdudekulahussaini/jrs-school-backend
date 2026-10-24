@extends('admin.layout')

@section('title', 'Hero Slide #' . $slider->id)
@section('header', 'Slide Details')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Breadcrumb & Top Actions (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.sliders.index') }}" class="hover:text-slate-900 transition-colors">Hero Sliders</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Slide #{{ $slider->id }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Slide</span>
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 h-9 px-3.5 transition-colors">
                &larr; Back
            </a>
        </div>
    </div>

    <!-- Slide Hero Preview Banner Card (shadcn/ui style) -->
    @if($slider->image_full_url)
    <div class="rounded-xl border border-slate-200 overflow-hidden bg-slate-950 text-white shadow-xs">
        <div class="relative w-full h-56 sm:h-72 overflow-hidden flex items-end">
            <img src="{{ $slider->image_full_url }}" alt="{{ $slider->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
            
            <div class="relative z-10 p-6 space-y-2 max-w-xl">
                @if($slider->badge_title)
                    <div class="inline-flex items-center rounded-md border border-white/20 bg-white/10 backdrop-blur-xs px-2.5 py-0.5 text-xs font-semibold text-slate-200 uppercase tracking-wider">
                        {{ $slider->badge_title }}
                    </div>
                @endif
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white leading-tight">
                    <span>{{ $slider->title }}</span>
                    @if($slider->highlight_text)
                        <span class="text-amber-400 block sm:inline sm:ml-1">{{ $slider->highlight_text }}</span>
                    @endif
                </h1>
                @if($slider->description)
                    <p class="text-xs sm:text-sm text-slate-300 line-clamp-2">{{ $slider->description }}</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Properties Card (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900">Slide Properties</h3>
                <p class="text-sm text-muted-foreground text-slate-500">Structured field values and display configuration.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $slider->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $slider->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                <span>{{ $slider->is_active ? 'Status: Active' : 'Status: Disabled' }}</span>
            </span>
        </div>

        <div class="divide-y divide-slate-100 text-sm">
            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Badge / Tagline:</span>
                <span class="sm:col-span-2 text-slate-900">{{ $slider->badge_title ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Main Title:</span>
                <span class="sm:col-span-2 font-semibold text-slate-900">{{ $slider->title }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Highlighted Title:</span>
                <span class="sm:col-span-2 font-semibold text-amber-600">{{ $slider->highlight_text ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Description:</span>
                <span class="sm:col-span-2 text-slate-700 leading-relaxed">{{ $slider->description ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Primary Button:</span>
                <span class="sm:col-span-2 font-medium text-slate-900">{{ $slider->primary_button_text ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Secondary Button:</span>
                <div class="sm:col-span-2 space-y-1">
                    <span class="font-medium text-slate-900">{{ $slider->secondary_button_text ?: '—' }}</span>
                    @if($slider->secondary_button_url)
                        <div class="text-xs text-blue-600 font-mono break-all">{{ $slider->secondary_button_url }}</div>
                    @endif
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Background Image:</span>
                <div class="sm:col-span-2 space-y-1">
                    <span class="text-xs text-slate-700 font-mono break-all block">{{ $slider->image_path ?: 'Default' }}</span>
                    @if($slider->image_full_url)
                        <a href="{{ $slider->image_full_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline">
                            <span>Open photo</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Contact Phone:</span>
                <span class="sm:col-span-2 text-slate-900 font-mono text-xs">{{ $slider->contact_phone ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Display Order:</span>
                <span class="sm:col-span-2 font-mono text-slate-900 font-semibold">#{{ $slider->sort_order }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Created:</span>
                <span class="sm:col-span-2 text-slate-600 text-xs">{{ $slider->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>

    <!-- API Response Snippet (shadcn/ui Card + Code) -->
    <div class="rounded-xl border border-slate-200 bg-slate-950 text-slate-100 shadow-xs overflow-hidden">
        <div class="px-5 py-3 border-b border-slate-800 flex items-center justify-between text-xs">
            <div class="flex items-center space-x-2">
                <span class="rounded bg-emerald-500/20 text-emerald-400 font-mono font-bold px-1.5 py-0.5 text-[11px]">GET</span>
                <span class="font-mono text-slate-300">/api/hero-slider</span>
            </div>
            <span class="text-slate-500 text-[11px]">JSON Payload</span>
        </div>
        <pre class="p-4 text-xs font-mono text-emerald-400 overflow-x-auto">{{ json_encode($slider, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
    </div>

</div>
@endsection
