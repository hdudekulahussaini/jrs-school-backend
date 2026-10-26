@extends('admin.layout')

@section('title', 'Admission Criteria & Guidelines')
@section('header', 'Admission Criteria & Guidelines')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Action Header Banner -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-red-50 text-jrs-red text-xs font-semibold uppercase tracking-wider mb-1.5 border border-red-100">
                <span class="w-1.5 h-1.5 rounded-full bg-jrs-red animate-pulse"></span>
                <span>Arrangements & Policy</span>
            </div>
            <h2 class="text-xl font-extrabold text-jrs-navy font-heading">Admission Criteria & Guidelines</h2>
            <p class="text-xs text-slate-500 mt-1">Manage the policy cards displayed on the "Admission Criteria & Guidelines" section of the Admissions page.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.admission-criteria.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Policy Card</span>
            </a>
        </div>
    </div>

    <!-- Data Table View -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-jrs-navy font-heading text-sm sm:text-base">All Policy Cards ({{ $totalCount }})</h3>
            <span class="text-xs text-slate-400">Ordered by Card Sequence</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase font-semibold text-[11px] tracking-wider">
                        <th class="py-3 px-4 w-16 text-center">No.</th>
                        <th class="py-3 px-4 w-20 text-center">Icon</th>
                        <th class="py-3 px-4 w-44">Target / Tag</th>
                        <th class="py-3 px-4 min-w-[200px]">Card Title & Guidance</th>
                        <th class="py-3 px-4 min-w-[220px]">Checklist Points / Callout Note</th>
                        <th class="py-3 px-4 w-24 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($criteria as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 text-center font-extrabold text-jrs-navy text-sm">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-jrs-navy text-xs font-bold font-mono">
                                    {{ $item->watermark_number }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->icon)
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-[#0b1c3e] text-white text-base shadow-sm">
                                        @if(str_contains($item->icon, '<'))
                                            {!! $item->icon !!}
                                        @elseif(str_starts_with($item->icon, 'bi ') || str_starts_with($item->icon, 'fa-'))
                                            <i class="{{ $item->icon }}"></i>
                                        @else
                                            <i class="bi bi-{{ $item->icon }}"></i>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">No icon</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($item->badge_tag)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $item->badge_tag }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $item->title }}</div>
                                <div class="text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->description ?? '—' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if(!empty($item->points) && count($item->points) > 0)
                                    <ul class="space-y-1">
                                        @foreach($item->points as $point)
                                            <li class="flex items-center gap-1.5 text-[11px] text-slate-700">
                                                <i class="bi bi-check-circle-fill text-emerald-500 text-xs shrink-0"></i>
                                                <span>{{ $point }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if($item->note)
                                    <div class="mt-1.5 p-2 rounded-lg bg-slate-50 border border-slate-200 text-[11px] text-slate-600 italic">
                                        {{ $item->note }}
                                    </div>
                                @endif

                                @if(empty($item->points) && empty($item->note))
                                    <span class="text-slate-400 italic text-[11px]">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.admission-criteria.edit', $item->id) }}" class="p-1.5 rounded-md text-slate-600 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Card">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.admission-criteria.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete policy card {{ $item->title }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Card">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <p class="text-sm">No criteria cards found. Run the seeder or click "Add Policy Card" to add cards.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($criteria->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $criteria->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
