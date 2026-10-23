@extends('admin.layout')

@section('title', 'Admission Enquiries')
@section('header', 'Admission Enquiries & Leads')

@section('content')
<div class="space-y-6">

    <!-- Header Actions and Filters -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.enquiries.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="lg:col-span-2 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student, parent, phone, email..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <!-- Filter Status -->
            <div>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    <option value="">All Statuses</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New Leads</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="scheduled_tour" {{ request('status') === 'scheduled_tour' ? 'selected' : '' }}>Campus Tour</option>
                    <option value="admitted" {{ request('status') === 'admitted' ? 'selected' : '' }}>Admitted / Enrolled</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Filter Grade -->
            <div>
                <select name="grade" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red">
                    <option value="">All Grades</option>
                    @foreach($grades as $g)
                        <option value="{{ $g }}" {{ request('grade') === $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-jrs-navy hover:bg-jrs-navy-dark text-white rounded-xl text-xs font-bold transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.enquiries.index') }}" class="p-2 text-slate-500 hover:text-slate-800 bg-slate-100 rounded-xl text-xs font-semibold" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
                <a href="{{ route('admin.enquiries.export', request()->all()) }}" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5" title="Export CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>CSV</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Enquiries Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5">ID</th>
                        <th class="py-3 px-5">Student / Parent</th>
                        <th class="py-3 px-4">Grade & Year</th>
                        <th class="py-3 px-4">Contact Details</th>
                        <th class="py-3 px-4">City / Inquiry Message</th>
                        <th class="py-3 px-4">Status & Action</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-5 text-right">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($enquiries as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-5 text-xs text-slate-400 font-mono">#{{ $item->id }}</td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $item->student_name }}</div>
                                <div class="text-xs text-slate-500 font-medium">Parent: {{ $item->parent_name }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-red-50 text-xs font-bold text-jrs-red border border-red-100">
                                    {{ $item->grade_applying }}
                                </span>
                                <div class="text-[11px] text-slate-400 mt-1">{{ $item->academic_year }}</div>
                            </td>
                            <td class="py-4 px-4 text-xs">
                                <a href="tel:{{ $item->phone }}" class="font-bold text-slate-800 hover:text-jrs-red flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $item->phone }}</span>
                                </a>
                                <a href="mailto:{{ $item->email }}" class="text-slate-500 hover:underline block mt-0.5">{{ $item->email }}</a>
                            </td>
                            <td class="py-4 px-4 text-xs max-w-xs">
                                @if($item->city)
                                    <div class="font-medium text-slate-700">📍 {{ $item->city }}</div>
                                @endif
                                @if($item->message)
                                    <p class="text-slate-500 mt-0.5 line-clamp-2" title="{{ $item->message }}">"{{ $item->message }}"</p>
                                @endif
                                @if($item->admin_notes)
                                    <div class="mt-1 text-[11px] text-amber-700 bg-amber-50 rounded px-2 py-0.5 border border-amber-200 inline-block">
                                        Note: {{ $item->admin_notes }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <!-- Status Changer Form -->
                                <form action="{{ route('admin.enquiries.update', $item->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg px-2 py-1 border transition-colors cursor-pointer {{ $item->status === 'new' ? 'bg-blue-50 text-blue-700 border-blue-200' : ($item->status === 'contacted' ? 'bg-amber-50 text-amber-700 border-amber-200' : ($item->status === 'scheduled_tour' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : ($item->status === 'admitted' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-700 border-slate-200'))) }}">
                                        <option value="new" {{ $item->status === 'new' ? 'selected' : '' }}>New</option>
                                        <option value="contacted" {{ $item->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="scheduled_tour" {{ $item->status === 'scheduled_tour' ? 'selected' : '' }}>Campus Tour</option>
                                        <option value="admitted" {{ $item->status === 'admitted' ? 'selected' : '' }}>Admitted</option>
                                        <option value="closed" {{ $item->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>

                                    <!-- Trigger Notes Modal -->
                                    <button type="button" onclick="openNotesModal({{ $item->id }}, '{{ addslashes($item->student_name) }}', '{{ $item->status }}', '{{ addslashes($item->admin_notes ?? '') }}')" class="p-1 text-slate-400 hover:text-slate-700" title="Add / Edit Admin Notes">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $item->created_at->format('M d, Y') }}
                                <div class="text-[10px] text-slate-400">{{ $item->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <form action="{{ route('admin.enquiries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Delete Enquiry">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500 text-sm">
                                No admission enquiries matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enquiries->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Admin Follow-Up Notes Modal -->
<div id="notesModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative">
        <h3 class="text-lg font-bold text-slate-900 font-heading mb-1" id="modalStudentName">Follow-Up Note</h3>
        <p class="text-xs text-slate-500 mb-4">Add call notes, parent feedback, or scheduled campus tour date.</p>

        <form id="notesForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="modalStatus">

            <div class="mb-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Admin Notes</label>
                <textarea name="admin_notes" id="modalNotesText" rows="4" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red" placeholder="e.g., Spoke with parent Mr. Sharma, scheduled school visit for Saturday 10:30 AM..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-2">
                <button type="button" onclick="closeNotesModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-jrs-red hover:bg-jrs-red-dark rounded-xl shadow-md">
                    Save Note
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNotesModal(id, name, status, notes) {
        document.getElementById('modalStudentName').textContent = 'Follow-Up Notes: ' + name;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalNotesText').value = notes;
        document.getElementById('notesForm').action = '/admin/enquiries/' + id;
        document.getElementById('notesModal').classList.remove('hidden');
    }

    function closeNotesModal() {
        document.getElementById('notesModal').classList.add('hidden');
    }
</script>
@endsection
