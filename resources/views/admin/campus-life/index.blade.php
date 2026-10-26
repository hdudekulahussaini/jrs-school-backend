@extends('admin.layout')

@section('title', 'Campus Tour & Life At JRS')
@section('header', 'Campus Tour & Life')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Campus Tour & Life At JRS</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('card', $totalCount) }}
                </div>
            </div>
            <p class="text-sm text-slate-500">
                Manage "Experience The Spirit Of JRS International School" showcase cards with photos, badges, and icons.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.campus-life.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Campus Card</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Search -->
    <div class="flex items-center justify-between gap-3">
        <form action="{{ route('admin.campus-life.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-80">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search campus cards..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.campus-life.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
        <span class="text-xs text-slate-500 font-medium hidden sm:inline-block">Total: {{ $totalCount }} cards</span>
    </div>

    <!-- Cards Grid & Table (shadcn/ui style) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Image</th>
                        <th class="h-10 px-4 min-w-[200px]">Card Title & Subtitle</th>
                        <th class="h-10 px-4 w-28 text-center">Icon</th>
                        <th class="h-10 px-4 w-32 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($items as $item)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-400">
                                #{{ $item->sort_order }}
                            </td>

                            <!-- Image Preview -->
                            <td class="p-4 align-middle">
                                <div class="w-20 h-14 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden relative shadow-2xs">
                                    @if($item->image_full_url)
                                        <img src="{{ $item->image_full_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Title & Subtitle -->
                            <td class="p-4 align-middle">
                                <div class="font-semibold text-slate-900 font-heading">{{ $item->title }}</div>
                                @if($item->subtitle)
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $item->subtitle }}</div>
                                @endif
                            </td>

                            <!-- Icon Badge -->
                            <td class="p-4 align-middle text-center">
                                <div class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-rose-50/80 border border-rose-200/70 text-rose-600 text-base shadow-2xs">
                                    @if(str_contains($item->icon ?? '', '<'))
                                        {!! $item->icon !!}
                                    @elseif(str_starts_with($item->icon ?? '', 'bi ') || str_starts_with($item->icon ?? '', 'fa-'))
                                        <i class="{{ $item->icon }}"></i>
                                    @else
                                        @php
                                            $aliasMap = [
                                                'leaf' => 'bi bi-tree-fill',
                                                'atom' => 'bi bi-lightbulb-fill',
                                                'book' => 'bi bi-book-half',
                                                'trophy' => 'bi bi-trophy-fill',
                                                'graduation-cap' => 'bi bi-mortarboard-fill',
                                                'flask' => 'bi bi-moisture',
                                                'monitor' => 'bi bi-laptop',
                                                'palette' => 'bi bi-palette-fill',
                                                'music' => 'bi bi-music-note-beamed',
                                                'school' => 'bi bi-buildings-fill',
                                                'bus' => 'bi bi-bus-front-fill',
                                                'users' => 'bi bi-people-fill',
                                                'shield' => 'bi bi-shield-check',
                                            ];
                                            $iconClass = $aliasMap[$item->icon ?? ''] ?? ('bi bi-' . ($item->icon ?? 'book-half'));
                                        @endphp
                                        <i class="{{ $iconClass }}"></i>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.campus-life.edit', $item->id) }}" class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-md transition-colors" title="Edit Card">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.campus-life.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this campus card?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Delete Card">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500 text-sm">
                                No Campus Tour cards found. Click "Add Campus Card" to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $items->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
