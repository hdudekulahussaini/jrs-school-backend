@extends('admin.layout')

@section('title', 'Breadcrumb Banners')
@section('header', 'Breadcrumb Banner Management')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Add Button (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.breadcrumb-banners.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>Add Banner</span>
        </a>
    </div>


    <!-- Toolbar: Search -->
    <div class="flex items-center justify-between gap-3">
        <div class="text-xs text-slate-500 font-medium">
            Showing {{ $banners->total() }} {{ Str::plural('page banner', $banners->total()) }}
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.breadcrumb-banners.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-80">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by page or title..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.breadcrumb-banners.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Banners Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-48">Page</th>
                        <th class="h-10 px-4 min-w-[240px]">Banner Heading & Highlight</th>
                        <th class="h-10 px-4 min-w-[220px]">Subtitle & Description</th>
                        <th class="h-10 px-4 w-32">Background</th>
                        <th class="h-10 px-4 w-28 text-center">Stats Cards</th>
                        <th class="h-10 px-4 w-36 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($banners as $banner)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Page -->
                            <td class="p-4 align-top">
                                <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $banner->page_name }}</div>
                                <div class="mt-1 text-[11px] text-slate-400">
                                    Breadcrumb: <span class="text-slate-600 font-medium">Home &gt; {{ $banner->breadcrumb_title }}</span>
                                </div>
                            </td>

                            <!-- Heading & Highlight -->
                            <td class="p-4 align-top">
                                <div class="font-bold text-slate-900 text-xs sm:text-sm">
                                    {{ $banner->title }}
                                    @if($banner->highlighted_title)
                                        <span class="text-amber-600 font-extrabold">{{ $banner->highlighted_title }}</span>
                                    @endif
                                </div>
                                @if($banner->secondary_button_text)
                                    <div class="mt-1.5 flex items-center gap-1.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            Btn: {{ $banner->secondary_button_text }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <!-- Subtitle & Description -->
                            <td class="p-4 align-top">
                                @if($banner->subtitle)
                                    <div class="font-semibold text-slate-800 text-xs mb-1">{{ $banner->subtitle }}</div>
                                @endif
                                <div class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $banner->description ?? 'No description provided' }}
                                </div>
                            </td>

                            <!-- Background Image -->
                            <td class="p-4 align-top">
                                <div class="relative w-24 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-900 group shrink-0">
                                    <img src="{{ $banner->background_image_url }}" alt="{{ $banner->page_name }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-[#031C3F]/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ $banner->background_image_url }}" target="_blank" class="p-1 rounded bg-white text-slate-800 text-[10px] font-bold shadow-xs">View</a>
                                    </div>
                                </div>
                            </td>

                            <!-- Stats Cards Count -->
                            <td class="p-4 align-top text-center">
                                @if($banner->isAboutBanner() && $banner->stats && $banner->stats->count() > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        {{ $banner->stats->count() }} Cards
                                    </span>
                                    <div class="mt-1 text-[10px] text-slate-400">
                                        {{ $banner->stats->pluck('value')->take(2)->join(', ') }}
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-top text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.breadcrumb-banners.edit', $banner->id) }}" class="p-1.5 rounded-md text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit Content">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.breadcrumb-banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the breadcrumb banner for &quot;{{ $banner->page_name }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md text-slate-600 hover:text-jrs-red hover:bg-red-50 transition-colors" title="Delete Banner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-800">No breadcrumb banners found</h3>
                                    <p class="text-xs text-slate-500">
                                        You haven't created any breadcrumb banners yet, or none match your search criteria.
                                    </p>
                                    <a href="{{ route('admin.breadcrumb-banners.create') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-jrs-red hover:bg-red-700 text-white font-semibold text-xs shadow-xs gap-1.5 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        <span>Create New Banner</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($banners->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $banners->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
