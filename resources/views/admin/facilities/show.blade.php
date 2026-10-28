@extends('admin.layout')

@section('title', 'Facility: ' . $facility->title)
@section('header', 'Facility Details')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb & Top Actions (shadcn/ui style) -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.facilities.index') }}" class="hover:text-slate-900 transition-colors">Facilities</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">{{ $facility->title }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Facility</span>
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 h-9 px-3.5 transition-colors">
                &larr; Back
            </a>
        </div>
    </div>

    <!-- Frontend Card Preview (Replicating exact card design from user screenshot) -->
    <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 flex flex-col items-center justify-center">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">
            Frontend Card Representation
        </div>

        <!-- Single Facility Card Replica matching screenshot -->
        <div class="w-72 bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 flex flex-col">
            <!-- Top Photo with bottom curve -->
            <div class="relative h-44 w-full overflow-hidden bg-slate-100">
                @if($facility->image_full_url)
                    <img src="{{ $facility->image_full_url }}" alt="{{ $facility->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">No Image Uploaded</div>
                @endif

                <!-- Curved SVG wave at bottom of image matching screenshot -->
                <div class="absolute bottom-0 inset-x-0 overflow-hidden leading-none z-10">
                    <svg viewBox="0 0 500 150" preserveAspectRatio="none" class="w-full h-10 {{ $facility->theme_color === 'red' ? 'text-red-600' : 'text-jrs-navy' }} fill-current">
                        <path d="M0.00,49.98 C150.00,140.00 349.81,-40.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"></path>
                    </svg>
                </div>

                <!-- Floating circular Icon centered on the wave -->
                <div class="absolute -bottom-4 left-6 z-20 w-11 h-11 rounded-full {{ $facility->theme_color === 'red' ? 'bg-red-600' : 'bg-jrs-navy' }} text-white border-2 border-white shadow-md flex items-center justify-center text-lg">
                    @if(\Illuminate\Support\Str::startsWith($facility->icon, ['bi ', 'bi-', 'fa-']))
                        <i class="{{ \Illuminate\Support\Str::startsWith($facility->icon, 'bi-') && !\Illuminate\Support\Str::startsWith($facility->icon, 'bi ') ? 'bi ' . $facility->icon : $facility->icon }}"></i>
                    @elseif($facility->icon === 'flask')
                        🧪
                    @elseif($facility->icon === 'book')
                        📖
                    @elseif($facility->icon === 'trophy')
                        🏃
                    @elseif($facility->icon === 'bus')
                        🚌
                    @elseif($facility->icon === 'school')
                        🏫
                    @elseif($facility->icon === 'monitor')
                        🖥️
                    @elseif(!empty($facility->icon))
                        <i class="{{ \Illuminate\Support\Str::startsWith($facility->icon, 'bi') ? $facility->icon : 'bi bi-' . $facility->icon }}"></i>
                    @else
                        <i class="bi bi-laptop"></i>
                    @endif
                </div>
            </div>

            <!-- Content Body -->
            <div class="p-6 pt-7 space-y-2">
                <h4 class="font-bold text-slate-900 text-base font-heading">{{ $facility->title }}</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-sans">{{ $facility->description }}</p>
            </div>
        </div>
    </div>

    <!-- Properties Card (shadcn/ui Card) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="space-y-1">
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">Facility Information</h3>
                <p class="text-sm text-slate-500">Structured field values and database properties.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $facility->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-200 bg-slate-100 text-slate-600' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $facility->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                <span>{{ $facility->is_active ? 'Status: Active' : 'Status: Disabled' }}</span>
            </span>
        </div>

        <div class="divide-y divide-slate-100 text-sm">
            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Facility Title:</span>
                <span class="sm:col-span-2 font-semibold text-slate-900">{{ $facility->title }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Description:</span>
                <span class="sm:col-span-2 text-slate-700 leading-relaxed">{{ $facility->description ?: '—' }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Wave Accent Theme:</span>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full {{ $facility->theme_color === 'red' ? 'bg-red-600' : 'bg-jrs-navy' }}"></span>
                    <span class="capitalize font-semibold text-slate-800">{{ $facility->theme_color === 'red' ? 'Red Wave (#e31e24)' : 'Navy Wave (#031c3f)' }}</span>
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Icon Key:</span>
                <span class="sm:col-span-2 font-mono text-xs text-slate-800 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md {{ $facility->theme_color === 'red' ? 'bg-red-600' : 'bg-jrs-navy' }} text-white flex items-center justify-center text-xs">
                        @if(\Illuminate\Support\Str::startsWith($facility->icon, ['bi ', 'bi-', 'fa-']))
                            <i class="{{ \Illuminate\Support\Str::startsWith($facility->icon, 'bi-') && !\Illuminate\Support\Str::startsWith($facility->icon, 'bi ') ? 'bi ' . $facility->icon : $facility->icon }}"></i>
                        @elseif(!empty($facility->icon))
                            <i class="bi bi-{{ $facility->icon }}"></i>
                        @else
                            <i class="bi bi-laptop"></i>
                        @endif
                    </span>
                    <span>{{ $facility->icon ?: 'bi bi-laptop' }}</span>
                </span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Destination URL:</span>
                <div class="sm:col-span-2">
                    @if($facility->destination_url)
                        <a href="{{ $facility->destination_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:underline font-mono break-all">
                            <span>{{ $facility->destination_url }}</span>
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @else
                        <span class="text-slate-400 text-xs italic">— None —</span>
                    @endif
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Image Asset:</span>
                <div class="sm:col-span-2 space-y-1">
                    <span class="text-xs text-slate-700 font-mono break-all block">{{ $facility->image_path ?: 'Default' }}</span>
                    @if($facility->image_full_url)
                        <a href="{{ $facility->image_full_url }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline">
                            <span>Open original image</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Display Order:</span>
                <span class="sm:col-span-2 font-mono text-slate-900 font-semibold">#{{ $facility->sort_order }}</span>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-1">
                <span class="font-medium text-slate-500">Created:</span>
                <span class="sm:col-span-2 text-slate-600 text-xs">{{ $facility->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
