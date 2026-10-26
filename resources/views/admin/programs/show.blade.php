@extends('admin.layout')

@section('title', $program->title . ' - Academic Programme Details')

@section('content')
<div class="space-y-6 max-w-6xl">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.programs.index') }}"
               class="p-2 text-slate-400 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors"
               title="Back to Programmes">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-jrs-red border border-red-200">
                        <i class="fas fa-sparkles text-[10px]"></i> {{ $program->stage_badge }}
                    </span>
                    @if($program->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i class="fas fa-check-circle text-[10px]"></i> Live
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            <i class="fas fa-eye-slash text-[10px]"></i> Hidden
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold font-heading text-jrs-navy mt-1">{{ $program->title }}</h1>
                <p class="text-xs text-slate-500 font-mono">Slug: {{ $program->slug }} &bull; Sort Order: {{ $program->sort_order }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <form action="{{ route('admin.programs.toggle', $program) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="px-3.5 py-2 text-xs font-semibold rounded-lg border transition-colors flex items-center gap-1.5 {{ $program->is_active ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                    <i class="fas {{ $program->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                    {{ $program->is_active ? 'Hide from Website' : 'Publish to Website' }}
                </button>
            </form>

            <a href="{{ route('admin.programs.edit', $program) }}"
               class="px-4 py-2 bg-jrs-navy text-white text-xs font-semibold rounded-lg hover:bg-jrs-red transition-colors flex items-center gap-1.5 shadow-sm">
                <i class="fas fa-edit"></i> Edit Programme
            </a>

            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this programme? This cannot be undone.');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2 text-slate-400 hover:text-jrs-red hover:bg-red-50 rounded-lg transition-colors"
                        title="Delete Programme">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Programme Card Presentation -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 tracking-wide uppercase">Programme Card Presentation</span>
            </div>
            <span class="text-xs text-slate-400">JRS School Frontend Card</span>
        </div>

        <div class="p-6 md:p-10 bg-slate-50/60 flex justify-center">
            <!-- The Card Component -->
            <div class="w-full max-w-4xl bg-white rounded-[2rem] p-4 md:p-6 shadow-xl border border-slate-200/80 grid md:grid-cols-2 gap-6 md:gap-8 items-center transition-all hover:shadow-2xl">
                <!-- Image Side -->
                <div class="relative w-full h-[320px] md:h-[380px] rounded-[1.5rem] overflow-hidden shadow-inner bg-slate-100 group">
                    <img src="{{ $program->image_url }}"
                         alt="{{ $program->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-[11px] font-semibold text-jrs-navy shadow-sm">
                        <i class="fas fa-camera text-jrs-red mr-1"></i> Stage Media
                    </div>
                </div>

                <!-- Content Side -->
                <div class="flex flex-col justify-center space-y-4 py-2 pr-2">
                    <!-- Badge -->
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase bg-red-50 text-jrs-red border border-red-200/80">
                            <i class="fas fa-sparkles text-[10px]"></i> {{ $program->stage_badge }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl md:text-3xl font-extrabold font-heading text-jrs-navy tracking-tight leading-tight">
                        {{ $program->title }}
                    </h2>

                    <!-- Subtitle -->
                    @if($program->subtitle)
                        <p class="text-xs font-bold uppercase tracking-wider text-jrs-red">
                            {{ $program->subtitle }}
                        </p>
                    @endif

                    <!-- Description -->
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $program->description }}
                    </p>

                    <!-- Highlights Checklist -->
                    @if(!empty($program->highlights))
                        <ul class="space-y-2.5 pt-1">
                            @foreach($program->highlights as $point)
                                <li class="flex items-start gap-2.5 text-xs text-slate-700">
                                    <span class="text-emerald-600 flex-shrink-0 mt-0.5">
                                        <i class="far fa-check-circle text-sm"></i>
                                    </span>
                                    <span class="leading-relaxed">{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="{{ $program->button_link ?: '#' }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-red transition-all duration-200 shadow hover:shadow-md group">
                            <span>{{ $program->button_text ?: 'Explore More' }}</span>
                            <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Record Details -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        <h3 class="text-sm font-bold text-jrs-navy uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-info-circle text-jrs-red"></i> Record Details
        </h3>

        <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Database ID</dt>
                <dd class="text-slate-700 font-mono font-bold mt-0.5">#{{ $program->id }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">URL Slug</dt>
                <dd class="text-slate-700 font-mono mt-0.5">{{ $program->slug }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Display Order</dt>
                <dd class="text-slate-700 font-bold mt-0.5">{{ $program->sort_order }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Button Target</dt>
                <dd class="text-slate-700 font-mono truncate mt-0.5">{{ $program->button_link ?: 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Created At</dt>
                <dd class="text-slate-700 mt-0.5">{{ $program->created_at->format('M d, Y h:i A') }}</dd>
            </div>
            <div>
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Last Updated</dt>
                <dd class="text-slate-700 mt-0.5">{{ $program->updated_at->format('M d, Y h:i A') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-slate-400 font-semibold uppercase tracking-wider text-[10px]">Image Stored Path</dt>
                <dd class="text-slate-700 font-mono text-[11px] break-all mt-0.5">{{ $program->image }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
