@extends('admin.layout')

@section('title', 'Edit News Announcement #' . $ticker->id)
@section('header', 'Edit Announcement')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.tickers.index') }}" class="hover:text-slate-800">News Ticker</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Edit #{{ $ticker->id }}</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.tickers.show', $ticker->id) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>View Details</span>
            </a>
            <a href="{{ route('admin.tickers.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Live Preview Box -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Live Interactive Preview</span>
            </span>
            <span class="text-xs text-slate-400">Updates dynamically as you edit below</span>
        </div>

        <div class="flex items-stretch rounded-xl overflow-hidden shadow-md border border-slate-900/10">
            <div id="previewBadge" class="bg-jrs-red text-white px-4 py-3 flex items-center gap-2 shrink-0 font-bold text-xs uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span id="previewBadgeText">{{ $ticker->badge_text ?? 'NEWS' }}</span>
            </div>
            <div class="flex-1 bg-jrs-navy text-white flex items-center px-4 overflow-hidden text-xs sm:text-sm">
                <marquee behavior="scroll" direction="left" scrollamount="6" class="py-1">
                    <span class="inline-flex items-center gap-2">
                        <span class="text-amber-400 font-bold">★</span>
                        <span id="previewTitle" class="font-medium text-slate-100">{{ $ticker->title }}</span>
                        <span id="previewLinkWrap" class="{{ empty($ticker->link_url) ? 'hidden' : '' }}">
                            <span class="underline text-amber-300 font-semibold ml-1">Open Link &rarr;</span>
                        </span>
                    </span>
                </marquee>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-900 font-heading">Edit Announcement #{{ $ticker->id }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Created on {{ $ticker->created_at->format('M d, Y') }} • Last updated {{ $ticker->updated_at->diffForHumans() }}</p>
            </div>
            <form action="{{ route('admin.tickers.toggle', $ticker->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold transition-colors {{ $ticker->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $ticker->is_active ? '● Active on Site' : '○ Disabled' }}
                </button>
            </form>
        </div>

        <form action="{{ route('admin.tickers.update', $ticker->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Announcement Title -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Announcement Text <span class="text-red-500">*</span>
                    </label>
                    <span class="text-xs text-slate-400"><span id="charCount">{{ strlen($ticker->title) }}</span>/500 characters</span>
                </div>
                <textarea name="title" id="title" rows="3" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('title') ? 'border-red-500 ring-2 ring-red-200' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red transition-all">{{ old('title', $ticker->title) }}</textarea>
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
                    <label for="badge_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Badge Label
                    </label>
                    <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $ticker->badge_text) }}" placeholder="NEWS, ALERT, NOTICE, EVENT" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('badge_text') ? 'border-red-500' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    <!-- Quick Preset Badges -->
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-[11px] text-slate-400">Presets:</span>
                        <button type="button" onclick="setPresetBadge('NEWS')" class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 hover:bg-red-200">NEWS</button>
                        <button type="button" onclick="setPresetBadge('ADMISSIONS')" class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 hover:bg-amber-200">ADMISSIONS</button>
                        <button type="button" onclick="setPresetBadge('ALERT')" class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700 hover:bg-indigo-200">ALERT</button>
                        <button type="button" onclick="setPresetBadge('NOTICE')" class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 hover:bg-slate-200">NOTICE</button>
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Display Order Sequence
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $ticker->sort_order) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                    <p class="text-[11px] text-slate-400 mt-1.5">Lower numbers display first (0, 1, 2...).</p>
                </div>
            </div>

            <!-- Target Link URL -->
            <div>
                <label for="link_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Target Click URL / Web Link <span class="text-slate-400 font-normal lowercase">(optional)</span>
                </label>
                <div class="relative">
                    <input type="text" name="link_url" id="link_url" value="{{ old('link_url', $ticker->link_url) }}" placeholder="https://jrs-school.vercel.app/admissions" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('link_url') ? 'border-red-500' : 'border-slate-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red">
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">If set, clicking the announcement in the marquee opens this page.</p>
            </div>

            <!-- Status Toggle -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                <div>
                    <div class="text-sm font-bold text-slate-900">Broadcast on Website</div>
                    <div class="text-xs text-slate-500">Show this announcement in the rolling marquee on the live website.</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $ticker->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                <button type="button" onclick="if(confirm('Delete this announcement permanently?')) { document.getElementById('deleteTickerForm').submit(); }" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete</span>
                </button>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.tickers.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-jrs-navy hover:bg-jrs-navy-dark text-white shadow-md transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Update Announcement</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Hidden delete form for delete button -->
        <form id="deleteTickerForm" action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>

@push('scripts')
<script>
    const titleInput = document.getElementById('title');
    const badgeInput = document.getElementById('badge_text');
    const linkInput = document.getElementById('link_url');
    const charCount = document.getElementById('charCount');

    const previewTitle = document.getElementById('previewTitle');
    const previewBadgeText = document.getElementById('previewBadgeText');
    const previewLinkWrap = document.getElementById('previewLinkWrap');

    function updatePreview() {
        if (titleInput.value.trim().length > 0) {
            previewTitle.textContent = titleInput.value;
        } else {
            previewTitle.textContent = 'Type announcement text in the form below...';
        }

        previewBadgeText.textContent = badgeInput.value.trim().length > 0 ? badgeInput.value.toUpperCase() : 'NEWS';
        charCount.textContent = titleInput.value.length;

        if (linkInput.value.trim().length > 0) {
            previewLinkWrap.classList.remove('hidden');
        } else {
            previewLinkWrap.classList.add('hidden');
        }
    }

    function setPresetBadge(text) {
        badgeInput.value = text;
        updatePreview();
    }

    titleInput.addEventListener('input', updatePreview);
    badgeInput.addEventListener('input', updatePreview);
    linkInput.addEventListener('input', updatePreview);

    // Initial run
    updatePreview();
</script>
@endpush
@endsection
