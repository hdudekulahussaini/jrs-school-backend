@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

    @if(isset($dbConnected) && !$dbConnected)
        <div class="p-5 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-slate-900 font-heading">MySQL Service Not Running</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Please open your <strong>XAMPP Control Panel</strong> and click <strong>Start</strong> on MySQL (Port 3306). Then click <strong>"Seed Demo Data"</strong> at the top right to populate all school content!</p>
                </div>
            </div>
            <a href="http://localhost/phpmyadmin" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white shadow-sm shrink-0">
                Open phpMyAdmin &rarr;
            </a>
        </div>
    @endif

    <!-- Live Website & Ticker Status Banner -->
    <div class="bg-gradient-to-r from-jrs-navy via-jrs-navy-light to-jrs-navy rounded-2xl p-4 sm:p-6 text-white shadow-lg relative overflow-hidden border border-white/10">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-jrs-red text-white">Live System</span>
                    <span class="text-xs text-amber-300 font-medium">Academic Year 2026-2027</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold font-heading">JRS International School Portal</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl">
                    Centralized dashboard managing the front-facing React web app at <a href="https://jrs-school.vercel.app/" target="_blank" class="underline text-amber-300 font-medium hover:text-white">https://jrs-school.vercel.app</a>. Monitor leads, update news ticker, publish events, and manage campus programmes.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.enquiries.index') }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>View All Enquiries</span>
                </a>
                <a href="{{ route('admin.api.docs') }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm transition-all border border-white/20 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    <span>API Specs</span>
                </a>
            </div>
        </div>

        <!-- Live Marquee Ticker Preview on Homepage -->
        <div class="mt-4 pt-4 border-t border-white/10 flex items-center gap-3">
            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-jrs-red text-white text-[11px] font-bold uppercase tracking-wider shrink-0">
                <svg class="w-3.5 h-3.5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>Live Ticker Preview</span>
            </div>
            <div class="flex-1 overflow-hidden text-xs sm:text-sm text-slate-200">
                <marquee behavior="scroll" direction="left" scrollamount="5" class="py-0.5">
                    @forelse($tickers as $ticker)
                        <span class="inline-flex items-center gap-2 mr-8">
                            <span class="text-amber-400 font-bold">★</span>
                            <span>{{ $ticker->title }}</span>
                        </span>
                    @empty
                        <span>Admissions Open for Academic Year 2026–2027 (Nursery to Grade XII) — Enroll Today!</span>
                    @endforelse
                </marquee>
            </div>
            <a href="{{ route('admin.tickers.index') }}" class="text-xs font-semibold text-amber-300 hover:text-white underline shrink-0">Edit Ticker</a>
        </div>
    </div>

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Metric 1: Total Enquiries -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Enquiries</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-jrs-accent flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $totalEnquiries }}</div>
                <div class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Active Leads</span>
                </div>
            </div>
            <div class="mt-3 text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3">
                <span>New Today: <strong class="text-slate-800">{{ $newEnquiriesToday }}</strong></span>
                <a href="{{ route('admin.enquiries.index') }}" class="text-jrs-red font-semibold hover:underline">Manage &rarr;</a>
            </div>
        </div>

        <!-- Metric 2: Pending Leads -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pending Action</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 font-heading">{{ $pendingEnquiries }}</div>
                <div class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Requires Call</div>
            </div>
            <div class="mt-3 text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3">
                <span>Contacted: <strong class="text-slate-800">{{ $statusCounts['contacted'] }}</strong></span>
                <a href="{{ route('admin.enquiries.index', ['status' => 'new']) }}" class="text-jrs-red font-semibold hover:underline">View New &rarr;</a>
            </div>
        </div>

        <!-- Metric 3: Active News Items -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">News Ticker Items</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-jrs-red flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $activeTickers }}</div>
                <div class="text-xs font-semibold text-jrs-red bg-red-50 px-2 py-0.5 rounded-full">Broadcasting</div>
            </div>
            <div class="mt-3 text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3">
                <span>Top of Homepage</span>
                <a href="{{ route('admin.tickers.index') }}" class="text-jrs-red font-semibold hover:underline">Edit Ticker &rarr;</a>
            </div>
        </div>

        <!-- Metric 4: Contact Inquiries -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Contact Messages</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $totalMessages }}</div>
                @if($unreadMessages > 0)
                    <div class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">{{ $unreadMessages }} Unread</div>
                @else
                    <div class="text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">All Read</div>
                @endif
            </div>
            <div class="mt-3 text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3">
                <span>General inquiries</span>
                <a href="{{ route('admin.messages.index') }}" class="text-jrs-red font-semibold hover:underline">Open Inbox &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Lead Status Pipeline Overview -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs">
        <h3 class="text-base font-bold text-slate-900 mb-4 font-heading flex items-center justify-between">
            <span>Admission Pipeline Breakdown</span>
            <span class="text-xs font-normal text-slate-500">Academic Year 2026-2027</span>
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 text-center">
                <span class="text-xs font-bold text-blue-700 uppercase">New Leads</span>
                <div class="text-2xl font-black text-blue-900 mt-1 font-heading">{{ $statusCounts['new'] }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-100 text-center">
                <span class="text-xs font-bold text-amber-700 uppercase">Contacted</span>
                <div class="text-2xl font-black text-amber-900 mt-1 font-heading">{{ $statusCounts['contacted'] }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-indigo-50/70 border border-indigo-100 text-center">
                <span class="text-xs font-bold text-indigo-700 uppercase">Campus Tour</span>
                <div class="text-2xl font-black text-indigo-900 mt-1 font-heading">{{ $statusCounts['scheduled_tour'] }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-100 text-center">
                <span class="text-xs font-bold text-emerald-700 uppercase">Enrolled</span>
                <div class="text-2xl font-black text-emerald-900 mt-1 font-heading">{{ $statusCounts['admitted'] }}</div>
            </div>
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-center col-span-2 sm:col-span-1">
                <span class="text-xs font-bold text-slate-600 uppercase">Closed</span>
                <div class="text-2xl font-black text-slate-700 mt-1 font-heading">{{ $statusCounts['closed'] }}</div>
            </div>
        </div>
    </div>

    <!-- Recent Admission Enquiries Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900 font-heading">Recent Admission Enquiries</h3>
                <p class="text-xs text-slate-500 mt-0.5">Leads received via the home page and admissions forms</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.enquiries.export') }}" class="px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Export CSV</span>
                </a>
                <a href="{{ route('admin.enquiries.index') }}" class="px-3 py-1.5 text-xs font-bold text-white bg-jrs-red hover:bg-jrs-red-dark rounded-lg transition-colors">
                    View All
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5">Student / Parent</th>
                        <th class="py-3 px-4">Grade Applying</th>
                        <th class="py-3 px-4">Contact Info</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentEnquiries as $enquiry)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-slate-900">{{ $enquiry->student_name }}</div>
                                <div class="text-xs text-slate-500">Parent: {{ $enquiry->parent_name }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-xs font-semibold text-slate-700">
                                    {{ $enquiry->grade_applying }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs space-y-0.5">
                                <div class="font-medium text-slate-900">{{ $enquiry->phone }}</div>
                                <div class="text-slate-500">{{ $enquiry->email }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($enquiry->status === 'new')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> New
                                    </span>
                                @elseif($enquiry->status === 'contacted')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Contacted
                                    </span>
                                @elseif($enquiry->status === 'scheduled_tour')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Campus Tour
                                    </span>
                                @elseif($enquiry->status === 'admitted')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Admitted
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-500">
                                {{ $enquiry->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <a href="{{ route('admin.enquiries.index', ['search' => $enquiry->student_name]) }}" class="text-xs font-bold text-jrs-navy hover:text-jrs-red transition-colors">
                                    Manage Lead &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 text-sm">
                                No admission enquiries yet. Click <strong>"Seed Demo Data"</strong> at the top right to populate sample leads.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Access Content Management Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: News Marquee Ticker -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-jrs-red flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <h4 class="font-bold text-slate-900 font-heading">Breaking News Marquee</h4>
                <p class="text-xs text-slate-500 mt-1">Manage the rolling red news banner on top of the school website (admissions alerts, prospectus links).</p>
            </div>
            <a href="{{ route('admin.tickers.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-jrs-red hover:underline">
                <span>Manage Announcements</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Card 2: What's Happening Events -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="font-bold text-slate-900 font-heading">What's Happening Events</h4>
                <p class="text-xs text-slate-500 mt-1">Publish campus events, Annual Day fests, sports championships, and STEM exhibitions.</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 hover:underline">
                <span>Manage Events ({{ $totalEvents }})</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Card 3: School Contact Settings -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h4 class="font-bold text-slate-900 font-heading">School Info & Prospectus</h4>
                <p class="text-xs text-slate-500 mt-1">Configure school phone numbers, admission helpline, campus address, and official brochure PDF link.</p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:underline">
                <span>Update Contact Info</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

</div>
@endsection
