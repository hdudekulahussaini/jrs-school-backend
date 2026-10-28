@extends('admin.layout')

@section('title', 'Header Top Bar | JRS School Admin')
@section('header', 'Header Top Bar Settings')

@section('content')
<div class="space-y-6">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-bold text-jrs-navy font-heading">Global Header Top Bar</h2>
            <p class="text-xs text-slate-500 mt-0.5">Top bar contact numbers, email address, affiliation badge, and school prospectus.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.top-bar.edit') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Top Bar</span>
            </a>
        </div>
    </div>

    @if($topBar)
    <!-- PRIMARY TABLE: Top Bar Settings Table View -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                <h3 class="font-bold text-slate-900 text-xs sm:text-sm tracking-wide uppercase font-heading">Top Bar Configuration Record</h3>
            </div>
            <span class="text-xs text-slate-400">ID #{{ $topBar->id }} • Updated {{ $topBar->updated_at ? $topBar->updated_at->diffForHumans() : 'Recently' }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                        <th class="h-10 px-4 w-12 text-center">ID</th>
                        <th class="h-10 px-4 min-w-[220px]">Contact Numbers</th>
                        <th class="h-10 px-4 min-w-[200px]">Email Address</th>
                        <th class="h-10 px-4 min-w-[180px]">Affiliation Badge</th>
                        <th class="h-10 px-4 min-w-[240px]">School Prospectus</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="transition-colors hover:bg-slate-50/60">
                        <!-- ID -->
                        <td class="p-4 align-middle text-center font-mono text-xs text-slate-400 font-bold">
                            #{{ $topBar->id }}
                        </td>

                        <!-- Contact Numbers -->
                        <td class="p-4 align-middle space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md bg-rose-50 text-jrs-red flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </span>
                                <span class="font-bold text-slate-900 text-xs">{{ $topBar->phone }}</span>
                            </div>
                            @if($topBar->phone_2)
                                <div class="flex items-center gap-2 pt-1 border-t border-slate-100">
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </span>
                                    <span class="font-medium text-slate-700 text-xs">{{ $topBar->phone_2 }}</span>
                                </div>
                            @endif
                        </td>

                        <!-- Email Address -->
                        <td class="p-4 align-middle">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <a href="mailto:{{ $topBar->email }}" class="text-xs font-semibold text-slate-800 hover:text-jrs-navy hover:underline">
                                    {{ $topBar->email }}
                                </a>
                            </div>
                        </td>

                        <!-- Affiliation Badge -->
                        <td class="p-4 align-middle">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-jrs-navy/10 text-jrs-navy border border-jrs-navy/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-jrs-navy"></span>
                                {{ $topBar->cbse_affiliation_text }}
                            </span>
                        </td>

                        <!-- School Prospectus -->
                        <td class="p-4 align-middle space-y-1">
                            @if($topBar->prospectus_title)
                                <div class="font-semibold text-slate-900 text-xs flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <span>{{ $topBar->prospectus_title }}</span>
                                </div>
                            @endif
                            <div>
                                @if(!empty($topBar->prospectus_file))
                                    <a href="{{ asset(ltrim($topBar->prospectus_file, '/')) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 hover:bg-emerald-100 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span>PDF File Upload</span>
                                    </a>
                                @elseif(!empty($topBar->prospectus_url))
                                    <a href="{{ $topBar->prospectus_url }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200 hover:bg-blue-100 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span class="truncate max-w-[150px]">{{ $topBar->prospectus_url }}</span>
                                    </a>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="p-4 align-middle text-center">
                            @if($topBar->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Disabled
                                </span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="p-4 align-middle text-right">
                            <a href="{{ route('admin.top-bar.edit') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
        No Top Bar record found. Run <code class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-xs font-mono">php artisan db:seed --class=TopBarSeeder</code> to seed default data.
    </div>
    @endif

</div>
@endsection
