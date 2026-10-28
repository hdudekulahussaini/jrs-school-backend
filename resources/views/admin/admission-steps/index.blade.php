@extends('admin.layout')

@section('title', 'Admission Process Steps')
@section('header', 'Admission Process')

@section('content')
<div class="space-y-8">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.admission-steps.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Step</span>
        </a>
    </div>



    <!-- Data Table View -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-jrs-navy font-heading text-sm sm:text-base">All Registered Steps ({{ $totalCount }})</h3>
            <span class="text-xs text-slate-400">Ordered by Step Sequence</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase font-semibold text-[11px] tracking-wider">
                        <th class="py-3 px-4 w-16 text-center">Step</th>
                        <th class="py-3 px-4 w-24 text-center">Badge Icon</th>
                        <th class="py-3 px-4 min-w-[200px]">Step Title</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 w-24 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($steps as $step)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 text-center font-extrabold text-jrs-navy text-sm">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg {{ $step->accent_color === 'navy' ? 'bg-jrs-navy' : 'bg-jrs-red' }} text-white text-xs font-bold">
                                    {{ $step->badge_number }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($step->icon)
                                    <div class="inline-flex items-center justify-center w-9 h-9 rounded-lg {{ $step->accent_color === 'navy' ? 'bg-sky-50 text-jrs-navy border-sky-200' : 'bg-red-50 text-jrs-red border-red-200' }} border text-lg shadow-2xs">
                                        @if(str_contains($step->icon, '<'))
                                            {!! $step->icon !!}
                                        @elseif(str_starts_with($step->icon, 'bi ') || str_starts_with($step->icon, 'fa-'))
                                            <i class="{{ $step->icon }}"></i>
                                        @else
                                            <i class="bi bi-{{ $step->icon }}"></i>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">No icon</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ $step->title }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 max-w-md truncate">
                                {{ $step->description ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('admin.admission-steps.edit', $step->id) }}" class="p-1.5 rounded-md text-slate-600 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Step">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.admission-steps.destroy', $step->id) }}" method="POST" onsubmit="return confirm('Delete Step {{ $step->step_number }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Step">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                No admission steps recorded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($steps->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $steps->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
