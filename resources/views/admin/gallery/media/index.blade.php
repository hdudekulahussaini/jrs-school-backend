@extends('admin.layout')

@section('title', 'News & Media Coverage | JRS School Admin')
@section('header', 'News & Media (Press Coverage)')

@section('content')
<div class="space-y-6">

    <!-- Top Breadcrumb & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">News & Media Coverage</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                    {{ $totalCount }} {{ Str::plural('Article', $totalCount) }}
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Manage newspaper press clippings, media coverage features, and campus achievements published under the Gallery &gt; News &amp; Media section.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.gallery-albums.index') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Gallery Albums</span>
            </a>
            <a href="{{ route('admin.news-media.create') }}" class="inline-flex items-center justify-center rounded-xl text-xs sm:text-sm font-semibold transition-all bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add Press Article</span>
            </a>
        </div>
    </div>

    <!-- Stats Pill Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Press Articles</p>
                <p class="text-2xl font-bold text-slate-900 mt-1 font-heading">{{ $totalCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Featured In News</p>
                <p class="text-2xl font-bold text-amber-600 mt-1 font-heading">{{ $featuredCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Campus Press</p>
                <p class="text-2xl font-bold text-jrs-navy mt-1 font-heading">{{ $latestCount }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-jrs-navy flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Active Published</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1 font-heading">{{ \App\Models\NewsMedia::where('is_active', true)->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <form action="{{ route('admin.news-media.index') }}" method="GET" class="flex flex-wrap items-center gap-2 w-full sm:w-auto flex-1">
            <div class="relative w-full sm:w-80">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Telugu/English title, newspaper, location..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>

            <select name="type" onchange="this.form.submit()" class="h-9 px-3 text-xs rounded-md border border-slate-200 bg-white text-slate-700 shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                <option value="">All Categories</option>
                <option value="featured" {{ request('type') === 'featured' ? 'selected' : '' }}>Featured In News (Top Section)</option>
                <option value="latest" {{ request('type') === 'latest' ? 'selected' : '' }}>Campus Press (Latest News)</option>
            </select>

            <select name="status" onchange="this.form.submit()" class="h-9 px-3 text-xs rounded-md border border-slate-200 bg-white text-slate-700 shadow-xs focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>

            @if(request('search') || request('type') || request('status'))
                <a href="{{ route('admin.news-media.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-semibold border border-slate-200 bg-white px-3 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Media Table List -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-semibold text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-28">Clipping</th>
                        <th class="h-10 px-4">Headline &amp; Details</th>
                        <th class="h-10 px-4 w-44">Newspaper &amp; Date</th>
                        <th class="h-10 px-4 w-32 text-center">Placement</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors group">
                            <td class="p-4 text-center font-mono text-xs text-slate-400 font-semibold">
                                #{{ $item->sort_order }}
                            </td>
                            <td class="p-4">
                                <div class="relative w-20 h-16 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shadow-xs flex-shrink-0 group/img">
                                    @if($item->image_path)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-slate-900 group-hover:text-jrs-navy transition-colors text-sm line-clamp-1">
                                            {{ $item->title }}
                                        </h3>
                                    </div>
                                    @if($item->english_title)
                                        <p class="text-xs text-slate-600 line-clamp-1 italic font-medium">
                                            "{{ $item->english_title }}"
                                        </p>
                                    @endif
                                    @if($item->description)
                                        <p class="text-xs text-slate-400 line-clamp-1">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-800">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                        <span>{{ $item->newspaper_name }}</span>
                                    </div>
                                    @if($item->location)
                                        <p class="text-[11px] text-slate-400">
                                            • {{ $item->location }}
                                        </p>
                                    @endif
                                    <p class="text-[11px] font-mono text-slate-500">
                                        {{ $item->formatted_date }}
                                    </p>
                                </div>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($item->is_featured)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200/60 shadow-2xs">
                                        <svg class="w-3 h-3 text-amber-600 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Featured Top
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-600">
                                        Campus Press
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.news-media.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition-all {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $item->is_active ? 'Active' : 'Draft' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.news-media.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Article">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ addslashes($item->title) }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete Article">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mx-auto flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <h3 class="text-base font-semibold text-slate-900">No News &amp; Media articles found</h3>
                                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Get started by creating your first newspaper clipping or press coverage highlight.</p>
                                <div class="mt-4">
                                    <a href="{{ route('admin.news-media.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-jrs-navy text-white hover:opacity-95 shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span>Add First Article</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $items->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-xs" onclick="closeDeleteModal()"></div>
        <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900" id="modal-title">Delete Press Article</h3>
            <p class="text-sm text-slate-500 mt-2">
                Are you sure you want to delete <span id="deleteItemTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone and its newspaper clipping image will be removed.
            </p>
            <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-rose-600 rounded-xl hover:bg-rose-700 transition-colors shadow-xs">
                    Delete Article
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, title) {
        document.getElementById('deleteItemTitle').textContent = `"${title}"`;
        document.getElementById('deleteForm').action = `{{ url('admin/news-media') }}/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
