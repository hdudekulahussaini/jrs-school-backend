@extends('admin.layout')

@section('title', 'Admission FAQs')
@section('header', 'Admission FAQs')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Action Header Banner -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-red-50 text-jrs-red text-xs font-semibold uppercase tracking-wider mb-1.5 border border-red-100">
                <span class="w-1.5 h-1.5 rounded-full bg-jrs-red animate-pulse"></span>
                <span>Admissions FAQs</span>
            </div>
            <h2 class="text-xl font-extrabold text-jrs-navy font-heading">Frequently Asked Questions</h2>
            <p class="text-xs text-slate-500 mt-1">Manage questions and answers displayed in the FAQ accordion on the Admissions page.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.admission-faqs.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add FAQ</span>
            </a>
        </div>
    </div>

    <!-- Data Table View -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-jrs-navy font-heading text-sm sm:text-base">All Admission FAQs ({{ $totalCount }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase font-semibold text-[11px] tracking-wider">
                        <th class="py-3 px-4 w-16 text-center">#</th>
                        <th class="py-3 px-4 min-w-[260px]">Question</th>
                        <th class="py-3 px-4">Answer</th>
                        <th class="py-3 px-4 w-24 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 text-center font-extrabold text-jrs-navy text-sm">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-jrs-navy text-xs font-bold font-mono">
                                    {{ $faq->id }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800 text-sm">
                                {{ $faq->question }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 leading-relaxed max-w-lg">
                                <div class="line-clamp-2">
                                    {{ $faq->answer }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.admission-faqs.edit', $faq->id) }}" class="p-1.5 rounded-md text-slate-600 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.admission-faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete FAQ">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <p class="text-sm">No FAQs found. Run the seeder or click "Add FAQ" to create one.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
