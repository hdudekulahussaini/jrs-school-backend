@extends('admin.layout')

@section('title', 'Add News Announcement')
@section('header', 'Create News Ticker')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.tickers.index') }}" class="hover:text-slate-900 transition-colors">News Ticker</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">New Announcement</span>
        </div>
        <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors shadow-2xs gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card (shadcn/ui style) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 font-heading">
                Announcement Details
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Add the announcement text and an optional PDF URL.</p>
        </div>

        <form action="{{ route('admin.tickers.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Announcement Title -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        News Ticker Text <span class="text-red-500">*</span>
                    </label>
                    <span class="text-xs text-slate-400"><span id="charCount">0</span>/500 characters</span>
                </div>
                <textarea name="title" id="title" rows="3" required maxlength="500" placeholder="Enter the announcement to display in the news ticker." class="flex min-h-[80px] w-full rounded-md border {{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-transparent px-3 py-2 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">{{ old('title') }}</textarea>
                @error('title')
                    <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label for="pdf_url" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    PDF URL <span class="text-slate-400 font-normal lowercase">(optional)</span>
                </label>
                <div class="relative">
                    <input type="url" name="pdf_url" id="pdf_url" value="{{ old('pdf_url') }}" placeholder="https://example.com/school-prospectus.pdf" class="flex h-9 w-full rounded-md border {{ $errors->has('pdf_url') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-200' }} bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>
                @error('pdf_url')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 mt-1.5">For a PDF announcement only. The marquee displays the announcement as plain text.</p>
            </div>

            <!-- Submit Buttons (shadcn/ui style) -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.tickers.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white hover:bg-slate-100 hover:text-slate-900 text-slate-700 h-9 px-4 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white hover:bg-slate-800 h-9 px-4 shadow-xs gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Publish Announcement</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const titleInput = document.getElementById('title');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        if (charCount && titleInput) {
            charCount.textContent = titleInput.value.length;
        }
    }

    if (titleInput) {
        titleInput.addEventListener('input', updateCharCount);
        updateCharCount();
    }
</script>
@endpush
@endsection
