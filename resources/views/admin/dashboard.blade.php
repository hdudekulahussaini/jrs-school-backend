@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@php
    use App\Models\AdmissionEnquiry;
    use App\Models\ContactInquiry;
    use App\Models\HeroSlider;
    use App\Models\NewsTicker;
    use App\Models\SchoolEvent;
    use App\Models\GalleryAlbum;
    use App\Models\GalleryItem;
    use App\Models\AcademicProgram;
    use App\Models\Facility;
    use App\Models\BeyondClassroom;
    use App\Models\NewsMedia;
    use App\Models\BreadcrumbBanner;

    // CRM counts
    $totalAdmissionEnquiries  = AdmissionEnquiry::count();
    $pendingAdmissionEnquiries = AdmissionEnquiry::where('status', 'pending')->count();
    $totalContactInquiries    = ContactInquiry::count();
    $pendingContactInquiries  = ContactInquiry::where('status', 'pending')->count();

    // Content counts
    $totalSliders    = HeroSlider::count();
    $totalTickers    = NewsTicker::count();
    $totalEvents     = SchoolEvent::count();
    $totalAlbums     = GalleryAlbum::count();
    $totalPhotos     = GalleryItem::count();
    $totalPrograms   = AcademicProgram::count();
    $totalFacilities = Facility::count();
    $totalBeyond     = BeyondClassroom::count();
    $totalMedia      = NewsMedia::count();
    $totalBanners    = BreadcrumbBanner::count();

    // Recent enquiries
    $recentAdmissions = AdmissionEnquiry::latest()->take(5)->get();
    $recentContacts   = ContactInquiry::latest()->take(5)->get();
@endphp

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════════
         WELCOME BANNER
    ═══════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl bg-jrs-navy text-white shadow-sm">
        <!-- Decorative blobs -->
        <div class="absolute -top-12 -right-12 w-56 h-56 bg-jrs-red/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 left-1/3 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-5 p-6 sm:p-8">
            <!-- Text block -->
            <div class="space-y-3 max-w-xl text-center md:text-left">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 border border-white/20 text-[11px] font-semibold tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Portal Active — {{ now()->format('D, d M Y') }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-heading leading-tight">
                    Welcome back,<br class="hidden sm:block">
                    <span class="text-jrs-red">{{ Auth::user()->name ?? 'Administrator' }}</span>
                </h1>
                <p class="text-xs sm:text-sm text-white/70 leading-relaxed">
                    Manage all JRS International School website content — hero sliders, admissions, gallery, events, and more — from one place.
                </p>
                <!-- Quick-action pill row -->
                <div class="pt-1 flex flex-wrap gap-2 justify-center md:justify-start">
                    @foreach ([
                        ['Admissions', 'admin.admission-enquiries.index'],
                        ['Enquiries',  'admin.contact-inquiries.index'],
                        ['Hero Sliders','admin.sliders.index'],
                        ['Events',     'admin.events.index'],
                        ['Gallery',    'admin.gallery-albums.index'],
                    ] as [$label, $route])
                    <a href="{{ route($route) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[11px] font-semibold
                              {{ $loop->first ? 'bg-jrs-red hover:opacity-90' : 'bg-white/10 hover:bg-white/20 border border-white/20' }}
                              text-white transition-all">
                        {{ $label }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Logo badge -->
            <div class="shrink-0 bg-white rounded-2xl p-4 shadow-2xl border border-white/30">
                <img src="{{ asset('images/logo.png') }}" alt="JRS International School"
                     class="h-16 sm:h-20 w-auto object-contain">
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         CRM STAT CARDS — Enquiries at a glance
    ═══════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Enquiries & CRM</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Admission Enquiries Total --}}
            <a href="{{ route('admin.admission-enquiries.index') }}"
               class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-5 shadow-xs hover:shadow-md hover:border-jrs-navy/20 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Total Admission Enquiries</p>
                        <p class="mt-2 text-3xl font-extrabold text-jrs-navy font-heading">{{ $totalAdmissionEnquiries }}</p>
                        <p class="mt-1 text-xs text-slate-500">All time submissions</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-jrs-navy/8 flex items-center justify-center shrink-0 group-hover:bg-jrs-navy/12 transition-colors">
                        <svg class="w-5 h-5 text-jrs-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                @if($pendingAdmissionEnquiries > 0)
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-xs font-semibold text-amber-600">{{ $pendingAdmissionEnquiries }} pending</span>
                </div>
                @else
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-xs font-semibold text-emerald-600">All reviewed</span>
                </div>
                @endif
            </a>

            {{-- Pending Admission Enquiries --}}
            <a href="{{ route('admin.admission-enquiries.index') }}"
               class="group relative overflow-hidden rounded-xl border {{ $pendingAdmissionEnquiries > 0 ? 'border-amber-200 bg-amber-50/60' : 'border-slate-200 bg-white' }} p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Pending Admissions</p>
                        <p class="mt-2 text-3xl font-extrabold {{ $pendingAdmissionEnquiries > 0 ? 'text-amber-600' : 'text-slate-400' }} font-heading">{{ $pendingAdmissionEnquiries }}</p>
                        <p class="mt-1 text-xs text-slate-500">Awaiting review</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg {{ $pendingAdmissionEnquiries > 0 ? 'bg-amber-100' : 'bg-slate-100' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $pendingAdmissionEnquiries > 0 ? 'text-amber-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t {{ $pendingAdmissionEnquiries > 0 ? 'border-amber-200' : 'border-slate-100' }}">
                    <span class="text-xs text-slate-500">Click to review →</span>
                </div>
            </a>

            {{-- Contact Inquiries Total --}}
            <a href="{{ route('admin.contact-inquiries.index') }}"
               class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white p-5 shadow-xs hover:shadow-md hover:border-jrs-red/20 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Total Contact Inquiries</p>
                        <p class="mt-2 text-3xl font-extrabold text-jrs-navy font-heading">{{ $totalContactInquiries }}</p>
                        <p class="mt-1 text-xs text-slate-500">All time submissions</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-jrs-red/8 flex items-center justify-center shrink-0 group-hover:bg-jrs-red/12 transition-colors">
                        <svg class="w-5 h-5 text-jrs-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                @if($pendingContactInquiries > 0)
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-xs font-semibold text-amber-600">{{ $pendingContactInquiries }} pending</span>
                </div>
                @else
                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-xs font-semibold text-emerald-600">All reviewed</span>
                </div>
                @endif
            </a>

            {{-- Pending Contact Inquiries --}}
            <a href="{{ route('admin.contact-inquiries.index') }}"
               class="group relative overflow-hidden rounded-xl border {{ $pendingContactInquiries > 0 ? 'border-rose-200 bg-rose-50/60' : 'border-slate-200 bg-white' }} p-5 shadow-xs hover:shadow-md transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Pending Contact</p>
                        <p class="mt-2 text-3xl font-extrabold {{ $pendingContactInquiries > 0 ? 'text-rose-600' : 'text-slate-400' }} font-heading">{{ $pendingContactInquiries }}</p>
                        <p class="mt-1 text-xs text-slate-500">Awaiting response</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg {{ $pendingContactInquiries > 0 ? 'bg-rose-100' : 'bg-slate-100' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $pendingContactInquiries > 0 ? 'text-rose-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t {{ $pendingContactInquiries > 0 ? 'border-rose-200' : 'border-slate-100' }}">
                    <span class="text-xs text-slate-500">Click to respond →</span>
                </div>
            </a>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         CONTENT OVERVIEW STAT TILES
    ═══════════════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Website Content Overview</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach ([
                ['Hero Sliders',      $totalSliders,    'admin.sliders.index',           'text-cyan-600',   'bg-cyan-50',   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['News Tickers',      $totalTickers,    'admin.tickers.index',           'text-violet-600', 'bg-violet-50', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>'],
                ['School Events',     $totalEvents,     'admin.events.index',            'text-orange-600', 'bg-orange-50', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['Gallery Albums',    $totalAlbums,     'admin.gallery-albums.index',    'text-pink-600',   'bg-pink-50',   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['Gallery Photos',    $totalPhotos,     'admin.gallery-items.index',     'text-rose-600',   'bg-rose-50',   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                ['Academic Programs', $totalPrograms,   'admin.programs.index',          'text-indigo-600', 'bg-indigo-50', '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>'],
                ['Facilities',        $totalFacilities, 'admin.facilities.index',        'text-sky-600',    'bg-sky-50',    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                ['Beyond Classroom',  $totalBeyond,     'admin.beyond-classrooms.index', 'text-teal-600',   'bg-teal-50',   '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ['News & Media',      $totalMedia,      'admin.news-media.index',        'text-amber-600',  'bg-amber-50',  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>'],
                ['Page Banners',      $totalBanners,    'admin.breadcrumb-banners.index','text-emerald-600','bg-emerald-50','<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
            ] as [$label, $count, $route, $textColor, $bgColor, $svgPath])
            <a href="{{ route($route) }}"
               class="group flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-xs hover:shadow-md hover:border-slate-300 transition-all">
                <div class="flex items-center justify-between">
                    <div class="w-9 h-9 rounded-lg {{ $bgColor }} flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 {{ $textColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPath !!}</svg>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold {{ $textColor }} font-heading leading-none">{{ $count }}</p>
                    <p class="text-[11px] font-medium text-slate-500 mt-1">{{ $label }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         RECENT ACTIVITY — Two column tables
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

        {{-- Recent Admission Enquiries --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-jrs-navy/8 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-jrs-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-jrs-navy font-heading">Recent Admission Enquiries</h3>
                </div>
                <a href="{{ route('admin.admission-enquiries.index') }}" class="text-[11px] font-semibold text-jrs-red hover:underline">View all →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentAdmissions as $enq)
                <div class="flex items-center justify-between px-5 py-3 hover:bg-slate-50/60 transition-colors">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $enq->grade }} &mdash; {{ $enq->branch }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $enq->parent_mobile }} &bull; {{ $enq->created_at?->diffForHumans() }}</p>
                    </div>
                    <span class="ml-3 shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                        @switch($enq->status)
                            @case('pending')   bg-amber-100 text-amber-700 @break
                            @case('contacted') bg-blue-100 text-blue-700 @break
                            @case('admitted')  bg-emerald-100 text-emerald-700 @break
                            @default           bg-slate-100 text-slate-600
                        @endswitch">
                        {{ ucfirst($enq->status ?? 'pending') }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-xs text-slate-400">No admission enquiries yet</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Contact Inquiries --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-slate-50/60">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-jrs-red/8 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-jrs-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-jrs-navy font-heading">Recent Contact Inquiries</h3>
                </div>
                <a href="{{ route('admin.contact-inquiries.index') }}" class="text-[11px] font-semibold text-jrs-red hover:underline">View all →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentContacts as $con)
                <div class="flex items-center justify-between px-5 py-3 hover:bg-slate-50/60 transition-colors">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $con->parent_name }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $con->phone }} &bull; {{ $con->created_at?->diffForHumans() }}</p>
                    </div>
                    <span class="ml-3 shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                        @switch($con->status)
                            @case('pending')   bg-amber-100 text-amber-700 @break
                            @case('resolved')  bg-emerald-100 text-emerald-700 @break
                            @case('contacted') bg-blue-100 text-blue-700 @break
                            @default           bg-slate-100 text-slate-600
                        @endswitch">
                        {{ ucfirst($con->status ?? 'pending') }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p class="text-xs text-slate-400">No contact inquiries yet</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>


</div>
@endsection
