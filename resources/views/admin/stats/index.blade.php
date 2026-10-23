@extends('admin.layout')

@section('title', 'Counter Statistics')
@section('header', 'Homepage Counter Statistics')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-slate-900 font-heading">Key Numbers & Metrics</h3>
            <p class="text-xs text-slate-500 mt-0.5">Edit the animated counter statistics displayed prominently on the JRS School homepage</p>
        </div>
        <span class="px-3 py-1 bg-amber-50 text-amber-800 rounded-full text-xs font-bold border border-amber-200">
            Live Counters
        </span>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($stats as $stat)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 text-center hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-jrs-navy text-white mx-auto flex items-center justify-center mb-3 shadow-md">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                
                <form action="{{ route('admin.stats.update', $stat->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Counter Value</label>
                        <input type="text" name="value" value="{{ $stat->value }}" required class="w-full text-center text-2xl font-black text-jrs-navy font-heading p-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-jrs-red">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Metric Label</label>
                        <input type="text" name="label" value="{{ $stat->label }}" required class="w-full text-center text-xs font-bold text-slate-700 p-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-jrs-red">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <span class="text-slate-400">Order:</span>
                        <input type="number" name="sort_order" value="{{ $stat->sort_order }}" class="w-16 text-center p-1 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                        <input type="hidden" name="is_active" value="1">
                    </div>

                    <button type="submit" class="w-full py-2 px-3 rounded-xl text-xs font-bold text-white bg-jrs-navy hover:bg-jrs-navy-dark shadow-sm transition-colors">
                        Save Stat
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-4 bg-white rounded-2xl p-8 text-center text-slate-500 border border-slate-200">
                No stats configured. Click "Seed Demo Data" on the top right.
            </div>
        @endforelse
    </div>

</div>
@endsection
