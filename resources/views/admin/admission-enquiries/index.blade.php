@extends('admin.layout')

@section('title', 'Admission Enquiries')
@section('header', 'Admission Enquiries')

@section('content')
<div class="space-y-6">

    <!-- Stats Quick Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.admission-enquiries.index') }}" class="p-4 rounded-2xl bg-white border {{ !$status ? 'border-jrs-navy ring-2 ring-jrs-navy/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">All Submissions</span>
                <i class="bi bi-inbox text-slate-400 text-base"></i>
            </div>
            <p class="text-2xl font-black text-jrs-navy mt-2">{{ $stats['total'] }}</p>
        </a>

        <a href="{{ route('admin.admission-enquiries.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-700">Pending Review</span>
                <i class="bi bi-clock-history text-amber-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-amber-600 mt-2">{{ $stats['pending'] }}</p>
        </a>

        <a href="{{ route('admin.admission-enquiries.index', ['status' => 'contacted']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'contacted' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-blue-700">Contacted</span>
                <i class="bi bi-telephone-outbound text-blue-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-blue-600 mt-2">{{ $stats['contacted'] }}</p>
        </a>

        <a href="{{ route('admin.admission-enquiries.index', ['status' => 'admitted']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'admitted' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-700">Admitted</span>
                <i class="bi bi-check-circle-fill text-emerald-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-emerald-600 mt-2">{{ $stats['admitted'] }}</p>
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
        <form method="GET" action="{{ route('admin.admission-enquiries.index') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative flex-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by mobile number, grade, branch..." class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
            </div>

            <!-- Per Page Selector -->
            <div class="flex items-center gap-1.5 shrink-0">
                <label for="per_page" class="text-xs font-semibold text-slate-500 whitespace-nowrap">Show:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()" class="px-2.5 py-2 rounded-xl text-xs border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 bg-white cursor-pointer font-bold">
                    <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10 / page</option>
                    <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25 / page</option>
                    <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50 / page</option>
                    <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100 / page</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2 rounded-xl bg-jrs-navy hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                Filter
            </button>
            @if($search || $status || ($perPage ?? 10) != 10)
                <a href="{{ route('admin.admission-enquiries.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all inline-flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Bulk Action Toolbar (Appears when items are selected) -->
    <div id="bulkActionBar" class="hidden items-center justify-between gap-3 p-3.5 rounded-2xl bg-red-50 border border-red-200 shadow-2xs transition-all">
        <div class="flex items-center gap-2 text-xs font-bold text-red-900">
            <span class="w-7 h-7 rounded-lg bg-red-100 text-jrs-red flex items-center justify-center text-sm font-bold">
                <i class="bi bi-check2-square"></i>
            </span>
            <span><strong id="selectedCount" class="text-jrs-red font-black">0</strong> admission enquiry(s) selected</span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" id="deselectAllBtn" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 transition-all cursor-pointer shadow-2xs">
                Deselect All
            </button>
            <button type="button" id="bulkDeleteBtn" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 text-white transition-all shadow-sm inline-flex items-center gap-1.5 cursor-pointer">
                <i class="bi bi-trash3 text-xs"></i>
                <span>Delete Selected</span>
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4 w-10 text-center">
                            <input type="checkbox" id="selectAllCheckbox" class="w-4 h-4 rounded border-slate-300 text-jrs-navy focus:ring-jrs-navy cursor-pointer" title="Select all on this page">
                        </th>
                        <th class="py-3 px-4">#ID</th>
                        <th class="py-3 px-4">Parent Mobile</th>
                        <th class="py-3 px-4">Grade & Student DOB</th>
                        <th class="py-3 px-4">Admission Type & Branch</th>
                        <th class="py-3 px-4">Submitted On</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($enquiries as $enquiry)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 text-center">
                                <input type="checkbox" value="{{ $enquiry->id }}" class="row-checkbox w-4 h-4 rounded border-slate-300 text-jrs-navy focus:ring-jrs-navy cursor-pointer">
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-500">
                                <a href="{{ route('admin.admission-enquiries.show', $enquiry) }}" class="hover:text-jrs-red hover:underline">
                                    #{{ $enquiry->id }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $enquiry->parent_mobile) }}" class="inline-flex items-center gap-1.5 font-bold text-jrs-navy hover:text-jrs-red transition-colors">
                                    <i class="bi bi-telephone-fill text-slate-400 text-xs"></i>
                                    <span>{{ $enquiry->parent_mobile }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $enquiry->grade }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    DOB: {{ $enquiry->student_dob ? $enquiry->student_dob->format('d M, Y') : 'N/A' }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-[10px] font-bold text-slate-700 tracking-wider">
                                    {{ $enquiry->admission_type }}
                                </span>
                                <div class="text-[11px] text-slate-500 mt-0.5 truncate max-w-[200px]" title="{{ $enquiry->branch }}">
                                    {{ $enquiry->branch }} ({{ $enquiry->academic_year }})
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                <div>{{ $enquiry->created_at->timezone(config('app.display_timezone'))->format('d M, Y') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $enquiry->created_at->timezone(config('app.display_timezone'))->format('h:i A T') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('admin.admission-enquiries.update', $enquiry) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg px-2.5 py-1 border transition-all cursor-pointer outline-none
                                        {{ $enquiry->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $enquiry->status === 'contacted' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $enquiry->status === 'admitted' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $enquiry->status === 'closed' ? 'bg-slate-100 text-slate-600 border-slate-200' : '' }}
                                    ">
                                        <option value="pending" {{ $enquiry->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="contacted" {{ $enquiry->status === 'contacted' ? 'selected' : '' }}>📞 Contacted</option>
                                        <option value="admitted" {{ $enquiry->status === 'admitted' ? 'selected' : '' }}>🎓 Admitted</option>
                                        <option value="closed" {{ $enquiry->status === 'closed' ? 'selected' : '' }}>✖ Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.admission-enquiries.show', $enquiry) }}"
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-jrs-navy hover:bg-slate-100 transition-colors inline-block"
                                   title="View Full Enquiry Details">
                                    <i class="bi bi-eye text-sm"></i>
                                </a>
                                <form action="{{ route('admin.admission-enquiries.destroy', $enquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete enquiry #{{ $enquiry->id }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Enquiry">
                                        <i class="bi bi-trash3 text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <i class="bi bi-inbox text-slate-300 text-3xl block mb-2"></i>
                                <p class="text-slate-500 font-medium text-xs">No admission enquiries found.</p>
                                <p class="text-slate-400 text-[11px] mt-1">When parents fill in the Enquiry Form on the website, they will appear here in real time.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                Showing <span class="font-bold text-slate-700">{{ $enquiries->firstItem() ?? 0 }}</span>
                to <span class="font-bold text-slate-700">{{ $enquiries->lastItem() ?? 0 }}</span>
                of <span class="font-bold text-slate-700">{{ $enquiries->total() }}</span> enquiries
            </div>
            @if($enquiries->hasPages())
                <div>
                    {{ $enquiries->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Bulk Delete Form -->
    <form id="bulkDeleteForm" action="{{ route('admin.admission-enquiries.bulk-destroy') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulkDeleteInputs"></div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const selectedCountSpan = document.getElementById('selectedCount');
    const deselectAllBtn = document.getElementById('deselectAllBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const bulkDeleteInputs = document.getElementById('bulkDeleteInputs');

    function updateSelection() {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        const count = checked.length;
        selectedCountSpan.textContent = count;

        if (count > 0) {
            bulkActionBar.classList.remove('hidden');
            bulkActionBar.classList.add('flex');
        } else {
            bulkActionBar.classList.add('hidden');
            bulkActionBar.classList.remove('flex');
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (rowCheckboxes.length > 0 && count === rowCheckboxes.length);
            selectAllCheckbox.indeterminate = (count > 0 && count < rowCheckboxes.length);
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            rowCheckboxes.forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateSelection();
        });
    }

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelection);
    });

    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function () {
            rowCheckboxes.forEach(cb => cb.checked = false);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
            updateSelection();
        });
    }

    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function () {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            const count = checked.length;
            if (count === 0) return;

            if (confirm(`Are you sure you want to permanently delete ${count} selected admission enquiry(s)? This action cannot be undone.`)) {
                bulkDeleteInputs.innerHTML = '';
                checked.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    bulkDeleteInputs.appendChild(input);
                });
                bulkDeleteForm.submit();
            }
        });
    }
});
</script>
@endsection
