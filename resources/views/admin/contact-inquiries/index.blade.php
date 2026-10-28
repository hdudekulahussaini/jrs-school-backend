@extends('admin.layout')

@section('title', 'Contact Us Inquiries')
@section('header', 'Contact Messages')

@section('content')
<div class="space-y-6">

    <!-- Top Action: Quick Settings (Aligned Right) -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.contact-settings.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold transition-all border border-slate-200 shadow-2xs">
            <i class="bi bi-geo-alt-fill text-jrs-red"></i>
            <span>Contact Info Settings</span>
        </a>
    </div>

    <!-- Stats Quick Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.contact-inquiries.index') }}" class="p-4 rounded-2xl bg-white border {{ !$status ? 'border-jrs-navy ring-2 ring-jrs-navy/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">All Inquiries</span>
                <i class="bi bi-chat-left-dots text-slate-400 text-base"></i>
            </div>
            <p class="text-2xl font-black text-jrs-navy mt-2">{{ $stats['total'] }}</p>
        </a>

        <a href="{{ route('admin.contact-inquiries.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-amber-700">Pending Review</span>
                <i class="bi bi-clock-history text-amber-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-amber-600 mt-2">{{ $stats['pending'] }}</p>
        </a>

        <a href="{{ route('admin.contact-inquiries.index', ['status' => 'contacted']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'contacted' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-blue-700">Contacted</span>
                <i class="bi bi-telephone-outbound text-blue-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-blue-600 mt-2">{{ $stats['contacted'] }}</p>
        </a>

        <a href="{{ route('admin.contact-inquiries.index', ['status' => 'resolved']) }}" class="p-4 rounded-2xl bg-white border {{ $status === 'resolved' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200' }} hover:border-slate-300 transition-all shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-700">Resolved</span>
                <i class="bi bi-check-circle-fill text-emerald-500 text-base"></i>
            </div>
            <p class="text-2xl font-black text-emerald-600 mt-2">{{ $stats['resolved'] }}</p>
        </a>
    </div>


    <!-- Search & Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
        <form method="GET" action="{{ route('admin.contact-inquiries.index') }}" class="flex flex-col sm:flex-row gap-3">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative flex-1">
                <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, phone, email, grade, message..." class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
            </div>
            <button type="submit" class="px-5 py-2 rounded-xl bg-jrs-navy hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                Filter
            </button>
            @if($search || $status)
                <a href="{{ route('admin.contact-inquiries.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all inline-flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">#ID</th>
                        <th class="py-3 px-4">Parent / Guardian</th>
                        <th class="py-3 px-4">Contacts</th>
                        <th class="py-3 px-4">Grade</th>
                        <th class="py-3 px-4">Received On</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-500">
                                <a href="{{ route('admin.contact-inquiries.show', $inquiry) }}" class="hover:text-jrs-red hover:underline">
                                    #{{ $inquiry->id }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.contact-inquiries.show', $inquiry) }}" class="font-bold text-slate-800 text-sm flex items-center gap-1.5 hover:text-jrs-navy group transition-colors">
                                    <i class="bi bi-person-circle text-slate-400 group-hover:text-jrs-red transition-colors"></i>
                                    <span>{{ $inquiry->parent_name }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 space-y-1">
                                <div>
                                    <a href="tel:{{ $inquiry->phone }}" class="inline-flex items-center gap-1.5 font-bold text-jrs-navy hover:text-jrs-red transition-colors">
                                        <i class="bi bi-telephone-fill text-slate-400 text-xs"></i>
                                        <span>{{ $inquiry->phone }}</span>
                                    </a>
                                </div>
                                @if($inquiry->email)
                                    <div>
                                        <a href="mailto:{{ $inquiry->email }}" class="inline-flex items-center gap-1 text-[11px] text-slate-500 hover:text-jrs-navy transition-colors">
                                            <i class="bi bi-envelope-fill text-slate-400 text-xs"></i>
                                            <span>{{ $inquiry->email }}</span>
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($inquiry->grade)
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-red-50 text-jrs-red border border-red-100 text-[11px] font-bold">
                                        {{ $inquiry->grade }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">Not specified</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                <div>{{ $inquiry->created_at->format('d M, Y') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $inquiry->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <form action="{{ route('admin.contact-inquiries.update', $inquiry) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg px-2.5 py-1 border transition-all cursor-pointer outline-none
                                        {{ $inquiry->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $inquiry->status === 'contacted' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $inquiry->status === 'resolved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $inquiry->status === 'closed' ? 'bg-slate-100 text-slate-600 border-slate-200' : '' }}
                                    ">
                                        <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>📞 Contacted</option>
                                        <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>✓ Resolved</option>
                                        <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>✖ Closed</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.contact-inquiries.show', $inquiry) }}" 
                                   class="p-1.5 rounded-lg text-slate-400 hover:text-jrs-navy hover:bg-slate-100 transition-colors inline-block" 
                                   title="View Full Inquiry Details">
                                    <i class="bi bi-eye text-sm"></i>
                                </a>
                                <form action="{{ route('admin.contact-inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete inquiry #{{ $inquiry->id }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete Inquiry">
                                        <i class="bi bi-trash3 text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <i class="bi bi-chat-left-dots text-slate-300 text-3xl block mb-2"></i>
                                <p class="text-slate-500 font-medium text-xs">No contact inquiries received yet.</p>
                                <p class="text-slate-400 text-[11px] mt-1">When website visitors submit the "Send Us A Message" online inquiry form on the Contact page, they will show up here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
