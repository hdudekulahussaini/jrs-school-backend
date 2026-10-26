@extends('admin.layout')

@section('title', 'Job Openings - Careers Page')
@section('header', 'Job Openings')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-jrs-navy font-heading">Job Openings</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('opening', $totalCount) }}
                </div>
            </div>
            <p class="text-xs sm:text-sm text-slate-500">
                Manage teaching and non-teaching job positions displayed on the Careers page.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.job-openings.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold transition-opacity bg-jrs-red hover:opacity-95 text-white shadow-xs h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Post Job Opening</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Tabs + Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 p-1 text-slate-500 w-full sm:w-auto">
            <a href="{{ route('admin.job-openings.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ !request('status') ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                All ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.job-openings.index', ['status' => 'active']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'active' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Active ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.job-openings.index', ['status' => 'inactive']) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1 text-xs font-medium transition-all {{ request('status') === 'inactive' ? 'bg-white text-jrs-navy font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Disabled ({{ $inactiveCount }})
            </a>
        </div>

        <form action="{{ route('admin.job-openings.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search positions..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-jrs-navy">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.job-openings.index', ['status' => request('status')]) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Job Openings Table -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-14 text-center">Order</th>
                        <th class="h-10 px-4 min-w-[200px]">Position Title & Dept</th>
                        <th class="h-10 px-4 min-w-[140px]">Type & Experience</th>
                        <th class="h-10 px-4 min-w-[180px]">Required Qualification</th>
                        <th class="h-10 px-4 w-24 text-center">Status</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($openings as $job)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Order -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-500">
                                {{ $job->sort_order }}
                            </td>

                            <!-- Title & Department -->
                            <td class="p-4 align-middle">
                                <div class="space-y-1">
                                    <div class="font-bold text-sm text-jrs-navy">{{ $job->title }}</div>
                                    @if($job->department)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold text-slate-600 bg-slate-100 border border-slate-200">
                                            {{ $job->department }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Type & Experience -->
                            <td class="p-4 align-middle text-xs">
                                <div class="space-y-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $job->job_type ?? 'Full-Time' }}
                                    </span>
                                    <div class="text-slate-500 font-medium">{{ $job->experience ?? '2+ Years' }}</div>
                                </div>
                            </td>

                            <!-- Qualification -->
                            <td class="p-4 align-middle text-xs text-slate-600">
                                {{ $job->qualification ?? 'Graduate / Postgraduate' }}
                            </td>

                            <!-- Status Toggle -->
                            <td class="p-4 align-middle text-center">
                                <button type="button" 
                                        onclick="toggleJobStatus({{ $job->id }}, this)" 
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer {{ $job->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $job->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-label">{{ $job->is_active ? 'Active' : 'Disabled' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.job-openings.edit', $job->id) }}" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-navy hover:bg-slate-100 transition-colors" title="Edit Opening">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" onclick="confirmDeleteJob({{ $job->id }}, '{{ addslashes($job->title) }}')" class="p-1.5 rounded-md text-slate-500 hover:text-jrs-red hover:bg-red-50 transition-colors cursor-pointer" title="Delete Opening">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                <p class="text-sm font-semibold text-slate-700">No job openings found</p>
                                <p class="text-xs text-slate-500 mt-1">Click "Post Job Opening" above to create one.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($openings->hasPages())
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                {{ $openings->links() }}
            </div>
        @endif
    </div>

    <!-- API Integration Information Card (GET only) -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-xs">
        <div class="flex items-start gap-3">
            <div class="p-2 rounded-lg bg-blue-50 text-blue-600 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="space-y-1.5 flex-1">
                <h4 class="text-sm font-bold text-jrs-navy font-heading">Frontend API Integration (Read-Only GET)</h4>
                <p class="text-xs text-slate-500">
                    The Careers page on the React website fetches active job openings via these read-only GET endpoints:
                </p>
                <div class="flex flex-wrap gap-2 pt-1 font-mono text-xs">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/careers-page
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/careers/openings
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/careers
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-100 text-slate-800 font-semibold border border-slate-200">
                        <span class="text-emerald-600 font-bold">GET</span> /api/careers/openings/{id}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteJobModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-jrs-red flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Delete Job Opening</h3>
                <p class="text-sm text-slate-500 mt-1">Are you sure you want to delete <span id="deleteJobTitle" class="font-semibold text-slate-700"></span>? This action cannot be undone.</p>
            </div>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeDeleteJobModal()" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-md transition-colors cursor-pointer">Cancel</button>
            <form id="deleteJobForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-jrs-red hover:opacity-90 rounded-md transition-opacity shadow-xs cursor-pointer">Delete Opening</button>
            </form>
        </div>
    </div>
</div>

<script>
function toggleJobStatus(id, btn) {
    fetch(`/admin/job-openings/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const label = btn.querySelector('.status-label');
            const dot = btn.querySelector('span');
            if (data.is_active) {
                btn.className = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100';
                dot.className = 'w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-500';
                label.textContent = 'Active';
            } else {
                btn.className = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all cursor-pointer bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200';
                dot.className = 'w-1.5 h-1.5 rounded-full mr-1.5 bg-slate-400';
                label.textContent = 'Disabled';
            }
        }
    })
    .catch(err => console.error('Status toggle error:', err));
}

function confirmDeleteJob(id, title) {
    document.getElementById('deleteJobTitle').textContent = `"${title}"`;
    document.getElementById('deleteJobForm').action = `/admin/job-openings/${id}`;
    document.getElementById('deleteJobModal').classList.remove('hidden');
}

function closeDeleteJobModal() {
    document.getElementById('deleteJobModal').classList.add('hidden');
}
</script>
@endsection
