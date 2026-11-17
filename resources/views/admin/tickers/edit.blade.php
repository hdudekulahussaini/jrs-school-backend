@extends('admin.layout')

@section('title', 'Edit News Announcement #' . $ticker->id)
@section('header', 'Edit Announcement')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.tickers.index') }}" class="hover:text-slate-900 transition-colors">News Ticker</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit #{{ $ticker->id }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Form Card (shadcn/ui style) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-900 font-heading">Edit Announcement #{{ $ticker->id }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Created on {{ $ticker->created_at->format('M d, Y') }} • Last updated {{ $ticker->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        <form action="{{ route('admin.tickers.update', $ticker->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Announcement Title -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        Announcement Text <span class="text-red-500">*</span>
                    </label>
                    <span class="text-xs text-slate-400"><span id="charCount">{{ strlen($ticker->title) }}</span>/500 characters</span>
                </div>
                <textarea name="title" id="title" rows="3" required class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-transparent px-3 py-2 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('title', $ticker->title) }}</textarea>
                @error('title')
                    <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Badge Text -->
                <div>
                    <label for="badge_text" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Badge Label
                    </label>
                    <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $ticker->badge_text) }}" placeholder="NEWS, ALERT, NOTICE, EVENT" class="flex h-9 w-full rounded-md border {{ $errors->has('badge_text') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    <!-- Quick Preset Badges -->
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-[11px] text-slate-400">Presets:</span>
                        <button type="button" onclick="setPresetBadge('NEWS')" class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-2 py-0.5 text-[10px] font-semibold text-red-700 hover:bg-red-100 transition-colors">NEWS</button>
                        <button type="button" onclick="setPresetBadge('ADMISSIONS')" class="inline-flex items-center rounded-md border border-amber-200 bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-800 hover:bg-amber-100 transition-colors">ADMISSIONS</button>
                        <button type="button" onclick="setPresetBadge('ALERT')" class="inline-flex items-center rounded-md border border-indigo-200 bg-indigo-50 px-2 py-0.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100 transition-colors">ALERT</button>
                        <button type="button" onclick="setPresetBadge('NOTICE')" class="inline-flex items-center rounded-md border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-700 hover:bg-slate-100 transition-colors">NOTICE</button>
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Display Order Sequence
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $ticker->sort_order) }}" min="0" class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    <p class="text-[11px] text-slate-400 mt-1.5">Lower numbers display first (0, 1, 2...).</p>
                </div>
            </div>

            <!-- Target Link URL -->
            <div>
                <label for="link_url" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Target Click URL / Web Link <span class="text-slate-400 font-normal lowercase">(optional)</span>
                </label>
                <div class="relative">
                    <input type="text" name="link_url" id="link_url" value="{{ old('link_url', $ticker->link_url) }}" placeholder="https://jrs-school.vercel.app/admissions" class="flex h-9 w-full rounded-md border {{ $errors->has('link_url') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">If set, clicking the announcement in the marquee opens this page.</p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-100 hover:text-slate-900 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 h-9 px-4 shadow-xs gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Update Announcement</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const titleInput = document.getElementById('title');
    const badgeInput = document.getElementById('badge_text');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        if (charCount && titleInput) {
            charCount.textContent = titleInput.value.length;
        }
    }

    function setPresetBadge(text) {
        if (badgeInput) {
            badgeInput.value = text;
        }
    }

    if (titleInput) {
        titleInput.addEventListener('input', updateCharCount);
        updateCharCount();
    }
</script>
@endpush
@endsection
