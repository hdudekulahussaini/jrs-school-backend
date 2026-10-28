@extends('admin.layout')

@section('title', 'Chairman of JRS')
@section('header', 'Chairman of JRS (Leadership)')

@section('content')
<div class="space-y-6">

    <!-- PRIMARY TABLE: Records Table View -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-jrs-red"></span>
                <h3 class="font-bold text-slate-900 text-xs sm:text-sm tracking-wide uppercase font-heading">Chairman Leadership Record</h3>
            </div>
            <span class="text-xs text-slate-400">Total: {{ $chairmen->count() }} record</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                        <th class="h-10 px-4 w-12 text-center">ID</th>
                        <th class="h-10 px-4 w-20 text-center">Photo</th>
                        <th class="h-10 px-4 min-w-[200px]">Leadership Profile</th>
                        <th class="h-10 px-4 min-w-[260px]">Address & Message</th>
                        <th class="h-10 px-4 min-w-[220px]">Strategic Commitment</th>
                        <th class="h-10 px-4 w-28 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($chairmen as $item)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- ID -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-400 font-bold">
                                #{{ $item->id }}
                            </td>

                            <!-- Photo -->
                            <td class="p-4 align-middle text-center">
                                <div class="w-14 h-16 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden mx-auto flex items-center justify-center shadow-2xs">
                                    @if($item->image_full_url)
                                        <img src="{{ $item->image_full_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Leadership Profile -->
                            <td class="p-4 align-middle space-y-1">
                                @if($item->profile_badge)
                                    <span class="inline-block text-[10px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded uppercase tracking-wider">
                                        {{ $item->profile_badge }}
                                    </span>
                                @endif
                                <div class="font-bold text-slate-900 font-heading text-sm">
                                    {{ $item->name }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ $item->sub_title }}
                                </div>
                                @if($item->quote)
                                    <div class="text-[11px] text-slate-600 italic bg-slate-50 p-1.5 rounded border border-slate-200/80 max-w-xs line-clamp-2">
                                        {{ $item->quote }}
                                    </div>
                                @endif
                            </td>

                            <!-- Address & Message -->
                            <td class="p-4 align-middle space-y-1.5">
                                @if($item->section_badge)
                                    <span class="inline-block text-[10px] font-bold text-jrs-navy bg-slate-100 px-2 py-0.5 rounded uppercase tracking-wider">
                                        {{ $item->section_badge }}
                                    </span>
                                @endif
                                <div class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1">
                                    {{ $item->title }}
                                </div>
                                <div class="text-xs text-slate-500 line-clamp-3 leading-relaxed max-w-sm">
                                    {{ $item->paragraph }}
                                </div>
                                <div class="text-[11px] text-slate-400 font-medium pt-1">
                                    Sign-off: <span class="text-slate-700 font-semibold">{{ $item->signoff_name }}</span> ({{ $item->signoff_sub }})
                                </div>
                            </td>

                            <!-- Strategic Commitment -->
                            <td class="p-4 align-middle space-y-1">
                                @if($item->commitment_badge)
                                    <span class="inline-block text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded uppercase tracking-wider">
                                        {{ $item->commitment_badge }}
                                    </span>
                                @endif
                                @if($item->commitment_title)
                                    <div class="font-bold text-slate-900 text-xs line-clamp-1">
                                        {{ $item->commitment_title }}
                                    </div>
                                @endif
                                @if($item->commitment_description)
                                    <div class="text-xs text-slate-500 line-clamp-2 leading-relaxed max-w-xs">
                                        {{ $item->commitment_description }}
                                    </div>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="p-4 align-middle text-center">
                                @if($item->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <form action="{{ route('admin.chairman.toggle', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg text-xs font-semibold transition-colors border border-slate-200 bg-white hover:bg-slate-100 text-slate-700 h-8 px-2.5 shadow-2xs" title="{{ $item->is_active ? 'Click to deactivate' : 'Click to activate' }}">
                                            {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.chairman.edit', $item->id) }}" class="inline-flex items-center justify-center rounded-lg text-xs font-bold transition-colors bg-jrs-red hover:bg-red-700 text-white h-8 px-3 gap-1 shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 text-sm">
                                No chairman content found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
