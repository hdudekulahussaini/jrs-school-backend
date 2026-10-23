@extends('admin.layout')

@section('title', 'Hero Banner Slides')
@section('header', 'Homepage Hero Banner')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner Visual Preview -->
    @if($slides->where('is_active', true)->first())
        @php $activeSlide = $slides->where('is_active', true)->first(); @endphp
        <div class="relative rounded-2xl overflow-hidden bg-jrs-navy text-white p-6 sm:p-10 shadow-xl border border-white/10 min-h-[260px] flex flex-col justify-center">
            <div class="absolute inset-0 bg-gradient-to-r from-jrs-navy via-jrs-navy/90 to-transparent z-10 pointer-events-none"></div>
            <div class="relative z-20 max-w-xl">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="text-xs font-bold tracking-wider uppercase text-amber-300">{{ $activeSlide->badge_text }}</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight font-heading leading-tight">
                    <span>{{ $activeSlide->title_line1 }}</span>
                    <span class="text-amber-400 block">{{ $activeSlide->title_line2 }}</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-200 mt-2 line-clamp-2 max-w-lg">
                    {{ $activeSlide->description }}
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <span class="px-5 py-2 rounded-full text-xs font-bold text-white bg-jrs-red shadow-md">
                        {{ $activeSlide->cta_primary_text }} &rarr;
                    </span>
                    @if($activeSlide->cta_secondary_text)
                        <span class="px-4 py-2 rounded-full text-xs font-semibold text-white bg-white/20 border border-white/30 backdrop-blur-sm">
                            {{ $activeSlide->cta_secondary_text }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add New Hero Slide Form -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs h-fit">
            <h3 class="text-base font-bold text-slate-900 font-heading mb-1">Add Hero Slide</h3>
            <p class="text-xs text-slate-500 mb-4">Add a new high-impact banner slide for the homepage</p>

            <form action="{{ route('admin.hero.store') }}" method="POST" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Top Badge Text</label>
                    <input type="text" name="badge_text" required value="NURTURING BRIGHT MINDS • BUILDING A BETTER TOMORROW" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Heading Line 1</label>
                        <input type="text" name="title_line1" required placeholder="Empowering" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Heading Line 2</label>
                        <input type="text" name="title_line2" required placeholder="Future Leaders" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Description Paragraph</label>
                    <textarea name="description" rows="3" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red" placeholder="At JRS International School, we inspire curiosity, creativity and compassion..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Primary CTA Button</label>
                        <input type="text" name="cta_primary_text" value="Admissions 2026-27" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Primary Link</label>
                        <input type="text" name="cta_primary_link" value="/admissions" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Secondary Button</label>
                        <input type="text" name="cta_secondary_text" value="Take a Virtual Tour" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Secondary Link</label>
                        <input type="text" name="cta_secondary_link" value="#tour" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Image URL / Path</label>
                    <input type="text" name="image_url" value="/images/hero image.png" required class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Display Order</label>
                    <input type="number" name="sort_order" value="1" class="w-24 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-jrs-red hover:bg-jrs-red-dark shadow-md shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Save Hero Slide</span>
                </button>
            </form>
        </div>

        <!-- Hero Slides List -->
        <div class="lg:col-span-2 space-y-4">
            @forelse($slides as $slide)
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-jrs-red uppercase">{{ $slide->badge_text }}</span>
                            <span class="text-xs text-slate-400">• Order: {{ $slide->sort_order }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mt-1 font-heading">
                            {{ $slide->title_line1 }} <span class="text-amber-500">{{ $slide->title_line2 }}</span>
                        </h4>
                        <p class="text-xs text-slate-600 mt-1 line-clamp-2">{{ $slide->description }}</p>
                        <div class="flex items-center gap-2 mt-2 text-xs font-semibold text-slate-500">
                            <span>CTA: <strong class="text-slate-800">{{ $slide->cta_primary_text }}</strong> ({{ $slide->cta_primary_link }})</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <form action="{{ route('admin.hero.toggle', $slide->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-bold transition-colors {{ $slide->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $slide->is_active ? 'Active' : 'Draft' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.hero.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Delete this hero slide?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                    No hero banner slides configured yet. Add one using the form on the left.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
