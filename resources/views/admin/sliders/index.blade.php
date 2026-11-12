@extends('admin.layout')

@section('title', 'Hero Sliders')
@section('header', 'Hero Sliders')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Hero Slider Configurations</h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Manage hero slider banners, multi-photo rotating backgrounds, action buttons, and experience seals.
            </p>
        </div>

        @if($totalCount < 1)
            <a href="{{ route('admin.sliders.create') }}" class="inline-flex items-center justify-center rounded-lg text-xs sm:text-sm font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs h-9 px-4 py-2 gap-2 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Hero Slider</span>
            </a>
        @else
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Configured (Max 1 Slider)</span>
            </div>
        @endif
    </div>

    <!-- Toolbar: Search -->
    <div class="flex items-center justify-end gap-3">
        <!-- Search Input -->
        <form action="{{ route('admin.sliders.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-80">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sliders..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Sliders Data Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">ID</th>
                        <th class="h-10 px-4 w-20 text-center">Seal</th>
                        <th class="h-10 px-4 w-44">Primary Button</th>
                        <th class="h-10 px-4 w-52">Secondary Button</th>
                        <th class="h-10 px-4 w-48">Background Photos</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sliders as $slider)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- ID -->
                            <td class="p-4 align-middle text-center">
                                <span class="inline-flex items-center justify-center font-mono text-xs font-semibold text-slate-500 bg-slate-100 rounded-md h-6 w-8">
                                    #{{ $slider->id }}
                                </span>
                            </td>

                            <!-- Seal Preview -->
                            <td class="p-4 align-middle text-center">
                                <div class="w-10 h-10 rounded-full bg-slate-950 p-1 border border-amber-400 shadow-xs flex items-center justify-center mx-auto overflow-hidden">
                                    <img src="{{ $slider->experience_badge_image_url }}" alt="Badge" class="w-full h-full object-contain">
                                </div>
                            </td>

                            <!-- Primary Button -->
                            <td class="p-4 align-middle">
                                @if($slider->primary_button_text)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-jrs-red border border-red-200">
                                        {{ $slider->primary_button_text }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Secondary Button -->
                            <td class="p-4 align-middle">
                                @if($slider->secondary_button_text)
                                    <div class="space-y-0.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $slider->secondary_button_text }}
                                        </span>
                                        @if($slider->secondary_button_url)
                                            <a href="{{ $slider->secondary_button_url }}" target="_blank" class="block text-[11px] text-slate-400 hover:text-slate-600 truncate max-w-[170px]" title="{{ $slider->secondary_button_url }}">
                                                <i class="bi bi-box-arrow-up-right text-[10px] mr-0.5"></i>{{ $slider->secondary_button_url }}
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Background Photos Preview -->
                            <td class="p-4 align-middle">
                                @php
                                    $imgs = $slider->background_images_full_urls;
                                    $imgCount = count($imgs);
                                @endphp
                                @if($imgCount > 0)
                                    <div class="space-y-1.5">
                                        <div class="grid grid-cols-3 gap-1.5 w-48">
                                            @foreach(array_slice($imgs, 0, 3) as $index => $photoUrl)
                                                <img src="{{ $photoUrl }}" alt="Background photo {{ $index + 1 }}" loading="lazy" class="h-12 w-full rounded-md border border-slate-200 bg-slate-100 object-cover shadow-2xs">
                                            @endforeach
                                        </div>
                                        <span class="text-xs font-medium text-slate-500">
                                            {{ $imgCount }} {{ Str::plural('Photo', $imgCount) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">No background photos</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Hero Slider">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $slider->id }})" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-red hover:bg-red-50 transition-colors cursor-pointer" title="Delete Hero Slider">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
                                        <i class="bi bi-images"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">No hero sliders found</p>
                                    <p class="text-xs text-slate-400">Add a new hero slider configuration (Maximum 1 allowed).</p>
                                    <a href="{{ route('admin.sliders.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold bg-jrs-red hover:bg-red-700 text-white shadow-xs transition-colors">
                                        <i class="bi bi-plus-lg"></i>
                                        <span>Add Hero Slider</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sliders->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                {{ $sliders->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-jrs-red flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Delete Hero Slider</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Hero Slider</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    document.getElementById('deleteItemTitle').textContent = `Hero Slider #${id}`;
    document.getElementById('deleteForm').action = `{{ url('admin/sliders') }}/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
