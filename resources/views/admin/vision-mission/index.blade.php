@extends('admin.layout')

@section('title', 'Vision & Mission Management')
@section('header', 'Vision & Mission')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Vision & Mission Cards</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Manage the Vision and Mission highlight cards displayed on the school website homepage.
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(count($items) < 2)
                <a href="{{ route('admin.vision-mission.create') }}" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-jrs-red hover:bg-jrs-red-dark text-white shadow-md shadow-red-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Add Card</span>
                </a>
            @else
                <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200" title="Limit of 2 cards reached">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>2 Cards Maximum (Vision &amp; Mission)</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Cards List Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 font-heading text-base">All Vision & Mission Items</h3>
            <span class="text-xs text-slate-400">{{ count($items) }} cards registered</span>
        </div>

        @if(count($items) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/60">
                        <tr>
                            <th class="py-3 px-4">Card / Type</th>
                            <th class="py-3 px-4">Heading & Content</th>
                            <th class="py-3 px-4">Background Image</th>
                            <th class="py-3 px-4">Order</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($items as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Card Eyebrow / Type -->
                                <td class="py-4 px-4 align-top">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-jrs-red text-white flex items-center justify-center shrink-0 shadow-xs">
                                            @if($item->icon === 'rocket')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-red-50 text-jrs-red border border-red-100">
                                                {{ $item->eyebrow }}
                                            </span>
                                            <div class="text-[11px] text-slate-400 mt-0.5 capitalize">{{ $item->type }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Title & Description -->
                                <td class="py-4 px-4 align-top max-w-md">
                                    <h4 class="font-bold text-slate-900 text-sm font-heading leading-snug">{{ $item->title }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                </td>

                                <!-- Background Image Preview -->
                                <td class="py-4 px-4 align-top">
                                    @if($item->image_path)
                                        <div class="flex items-center gap-2">
                                            <img src="{{ $item->image_url }}" alt="Background" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shrink-0 shadow-xs">
                                            <span class="text-xs text-slate-600 truncate max-w-[120px] font-mono text-[11px]">{{ basename($item->image_path) }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No image</span>
                                    @endif
                                </td>

                                <!-- Order -->
                                <td class="py-4 px-4 align-top font-semibold text-xs text-slate-700">
                                    {{ $item->sort_order }}
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-4 align-top">
                                    <form action="{{ route('admin.vision-mission.toggle', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-colors {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                            {{ $item->is_active ? '● Active' : '○ Inactive' }}
                                        </button>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-4 align-top text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.vision-mission.edit', $item->id) }}" class="p-2 text-slate-500 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors" title="Edit Card">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.vision-mission.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete Card">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center text-slate-500">
                <p class="font-medium text-slate-700 text-sm">No Vision or Mission cards registered yet.</p>
                <a href="{{ route('admin.vision-mission.create') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-jrs-red text-white hover:bg-jrs-red-dark transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Create First Card</span>
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
