@extends('admin.layout')

@section('title', 'Inquiry #' . $contactInquiry->id . ' - ' . $contactInquiry->parent_name)
@section('header', 'Contact Inquiry Details')

@section('content')
<div class="space-y-6 w-full">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.contact-inquiries.index') }}"
               class="p-2 text-slate-400 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors"
               title="Back to Contact Inquiries">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold text-slate-400">#{{ $contactInquiry->id }}</span>
                    @if($contactInquiry->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending Follow-up
                        </span>
                    @elseif($contactInquiry->status === 'contacted')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Contacted
                        </span>
                    @elseif($contactInquiry->status === 'resolved')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Resolved
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Closed
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold font-heading text-jrs-navy mt-1">{{ $contactInquiry->parent_name }}</h1>
                <p class="text-xs text-slate-500">
                    Received {{ $contactInquiry->created_at->format('M d, Y \a\t h:i A') }} ({{ $contactInquiry->created_at->diffForHumans() }})
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="tel:{{ $contactInquiry->phone }}"
               class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <i class="bi bi-telephone-fill"></i>
                <span>Call Now</span>
            </a>
            @if($contactInquiry->email)
                <a href="mailto:{{ $contactInquiry->email }}"
                   class="px-3.5 py-2 bg-jrs-navy hover:bg-jrs-red text-white text-xs font-semibold rounded-lg transition-colors inline-flex items-center gap-1.5 shadow-xs">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Email</span>
                </a>
            @endif
            <form action="{{ route('admin.contact-inquiries.destroy', $contactInquiry) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to permanently delete inquiry #{{ $contactInquiry->id }}?');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                        title="Delete Inquiry">
                    <i class="bi bi-trash3 text-sm"></i>
                </button>
            </form>
        </div>
    </div>


    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Details & Message Column (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Parent & Contact Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-jrs-navy to-slate-800 text-white flex items-center justify-center font-bold text-lg shadow-xs">
                            {{ strtoupper(substr($contactInquiry->parent_name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">{{ $contactInquiry->parent_name }}</h2>
                            <p class="text-xs text-slate-500">Contact Us Page &bull; Online Inquiry</p>
                        </div>
                    </div>
                    @if($contactInquiry->grade)
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Grade Applied / Interested</span>
                            <span class="inline-block mt-0.5 px-3 py-1 rounded-full bg-red-50 text-jrs-red border border-red-200 text-xs font-bold">
                                <i class="bi bi-mortarboard-fill mr-1"></i>{{ $contactInquiry->grade }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Contact Channels -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-phone mr-1"></i>Phone Number
                        </span>
                        <a href="tel:{{ $contactInquiry->phone }}" class="text-sm font-bold text-jrs-navy hover:text-jrs-red transition-colors inline-flex items-center gap-1.5">
                            <span>{{ $contactInquiry->phone }}</span>
                        </a>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-envelope mr-1"></i>Email Address
                        </span>
                        @if($contactInquiry->email)
                            <a href="mailto:{{ $contactInquiry->email }}" class="text-sm font-semibold text-slate-700 hover:text-jrs-navy transition-colors">
                                {{ $contactInquiry->email }}
                            </a>
                        @else
                            <span class="text-xs text-slate-400 italic">Not provided</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- The Query / Message Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="w-7 h-7 rounded-lg bg-red-50 text-jrs-red flex items-center justify-center text-xs">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Your Query Or Message</h3>
                </div>

                <div class="relative bg-slate-50 rounded-xl p-5 border border-slate-200/80">
                    <i class="bi bi-quote text-slate-300 text-3xl absolute top-3 right-4 select-none"></i>
                    <p class="text-sm text-slate-800 leading-relaxed whitespace-pre-wrap font-sans relative z-10">
                        {{ $contactInquiry->message }}
                    </p>
                </div>
            </div>

        </div>

            <!-- Status Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="bi bi-sliders text-jrs-red"></i>
                    <span>Inquiry Status</span>
                </h3>

                <form action="{{ route('admin.contact-inquiries.update', $contactInquiry) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Change Status</label>
                        <select name="status" class="w-full text-xs font-bold rounded-lg px-3 py-2 border border-slate-300 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-white">
                            <option value="pending" {{ $contactInquiry->status === 'pending' ? 'selected' : '' }}>⏳ Pending Follow-up</option>
                            <option value="contacted" {{ $contactInquiry->status === 'contacted' ? 'selected' : '' }}>📞 Contacted Parent</option>
                            <option value="resolved" {{ $contactInquiry->status === 'resolved' ? 'selected' : '' }}>✓ Resolved / Answered</option>
                            <option value="closed" {{ $contactInquiry->status === 'closed' ? 'selected' : '' }}>✖ Closed / Archive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2 bg-jrs-navy hover:bg-jrs-red text-white text-xs font-bold rounded-lg transition-colors shadow-xs">
                        Update Status
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection
