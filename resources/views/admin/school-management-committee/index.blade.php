@extends('admin.layout')

@section('title', 'School Management Committee (SMC)')
@section('header', 'School Management Committee (SMC)')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Header Actions & Live Site Preview Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-jrs-red"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-red-600">STATUTORY GOVERNANCE & COMPLIANCE</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900 font-heading mt-1">School Management Committee (SMC)</h2>
            <p class="text-xs text-slate-500 mt-1 max-w-2xl leading-relaxed">
                The School Management Committee (SMC) ensures academic integrity, statutory compliance, student welfare, and continuous institutional growth at JRS International School.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.school-management-committee.create') }}" class="inline-flex items-center justify-center rounded-xl text-xs font-bold transition-all bg-jrs-red hover:bg-red-700 text-white h-9 px-4 gap-2 shadow-sm shadow-red-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Member</span>
            </a>
        </div>
    </div>

    <!-- Search & Designation Filter Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.school-management-committee.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by member name, designation, address, or phone..." class="w-full pl-9 pr-4 py-2 rounded-lg text-xs border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors">
            </div>

            @if(isset($designations) && $designations->count() > 0)
                <div class="w-full sm:w-56 shrink-0">
                    <select name="designation" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg text-xs border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-700 bg-white">
                        <option value="">All Designations</option>
                        @foreach($designations as $desig)
                            <option value="{{ $desig }}" {{ request('designation') == $desig ? 'selected' : '' }}>{{ $desig }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-lg text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-white transition-colors shrink-0">
                Filter
            </button>

            @if(request()->hasAny(['search', 'designation']))
                <a href="{{ route('admin.school-management-committee.index') }}" class="w-full sm:w-auto px-3 py-2 rounded-lg text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center shrink-0">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- PRIMARY TABLE: Committee Directory -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                <h3 class="font-bold text-slate-900 text-xs sm:text-sm tracking-wide uppercase font-heading">SMC Committee Directory</h3>
            </div>
            <span class="text-xs text-slate-500 font-medium">Total: {{ $totalCount }} members</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                        <th class="h-10 px-4 w-12 text-center">ID</th>
                        <th class="h-10 px-4 w-16 text-center">Photo</th>
                        <th class="h-10 px-4 min-w-[200px]">Member & Role</th>
                        <th class="h-10 px-4 min-w-[220px]">Address / Locality</th>
                        <th class="h-10 px-4 min-w-[140px]">Contact Phone</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($members as $item)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- ID -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-400 font-bold">
                                #{{ $item->id }}
                            </td>

                            <!-- Photo -->
                            <td class="p-4 align-middle text-center">
                                <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 overflow-hidden mx-auto flex items-center justify-center shadow-2xs">
                                    @if($item->image_full_url)
                                        <img src="{{ $item->image_full_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Member Name & Role -->
                            <td class="p-4 align-middle space-y-1">
                                <div class="font-bold text-slate-900 font-heading text-sm">
                                    {{ $item->name }}
                                </div>
                                <div>
                                    @if(strtoupper($item->designation) === 'CHAIRMAN')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 border border-amber-300 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                            <span>👑</span>
                                            <span>{{ $item->designation }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-700 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                            <span>👥</span>
                                            <span>{{ $item->designation }}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Address -->
                            <td class="p-4 align-middle">
                                @if($item->address)
                                    <div class="flex items-start gap-1.5 text-xs text-slate-600">
                                        <svg class="w-3.5 h-3.5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="leading-relaxed">{{ $item->address }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">—</span>
                                @endif
                            </td>

                            <!-- Contact Phone -->
                            <td class="p-4 align-middle">
                                @if($item->phone)
                                    <a href="tel:{{ $item->phone }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-jrs-navy transition-colors">
                                        <span class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </span>
                                        <span>{{ $item->phone }}</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">—</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.school-management-committee.edit', $item->id) }}" class="inline-flex items-center justify-center rounded-lg text-xs font-bold transition-colors bg-jrs-navy hover:bg-slate-800 text-white h-8 px-3 gap-1 shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.school-management-committee.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove {{ $item->name }} from the committee?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold text-red-600 hover:text-white hover:bg-red-600 border border-red-200 h-8 w-8 transition-colors shadow-2xs" title="Delete Member">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 text-sm">
                                No School Management Committee members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $members->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
