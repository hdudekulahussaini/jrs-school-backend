@extends('admin.layout')

@section('title', 'Admission Enquiry #' . $admissionEnquiry->id . ' - ' . $admissionEnquiry->grade)
@section('header', 'Admission Enquiry Details')

@section('content')
<div class="space-y-6 w-full">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.admission-enquiries.index') }}"
               class="p-2 text-slate-400 hover:text-jrs-navy hover:bg-slate-100 rounded-lg transition-colors"
               title="Back to All Admission Enquiries">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold text-slate-400">#{{ $admissionEnquiry->id }}</span>
                    @if($admissionEnquiry->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> ⏳ Pending Review
                        </span>
                    @elseif($admissionEnquiry->status === 'contacted')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 📞 Contacted Parent
                        </span>
                    @elseif($admissionEnquiry->status === 'admitted')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 🎓 Admitted
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> ✖ Closed / Archived
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold font-heading text-jrs-navy mt-1">
                    Enquiry for {{ $admissionEnquiry->grade }}
                </h1>
                <p class="text-xs text-slate-500">
                    Received {{ $admissionEnquiry->created_at->timezone(config('app.display_timezone'))->format('M d, Y \a\t h:i A T') }} ({{ $admissionEnquiry->created_at->diffForHumans() }})
                </p>
            </div>
        </div>

        @php
            $mobileNumber = preg_replace('/[^0-9]/', '', (string) $admissionEnquiry->parent_mobile);
            $whatsappNumber = strlen($mobileNumber) === 10 ? '91' . $mobileNumber : $mobileNumber;
        @endphp

        <div class="flex items-center gap-2">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $admissionEnquiry->parent_mobile) }}"
               class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-colors inline-flex items-center gap-1.5 shadow-xs">
                <i class="bi bi-telephone-fill"></i>
                <span>Call Parent</span>
            </a>

            @if($whatsappNumber)
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Hello, greeting from JRS International School regarding your admission enquiry for ' . $admissionEnquiry->grade . '.') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors inline-flex items-center gap-1.5 shadow-xs">
                    <i class="bi bi-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
            @endif

            <form action="{{ route('admin.admission-enquiries.destroy', $admissionEnquiry) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to permanently delete admission enquiry #{{ $admissionEnquiry->id }}?');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                        title="Delete Enquiry">
                    <i class="bi bi-trash3 text-sm"></i>
                </button>
            </form>
        </div>
    </div>


    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Details Column (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Student & Application Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-jrs-navy to-slate-800 text-white flex items-center justify-center font-bold text-lg shadow-xs">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Student & Admission Information</h2>
                            <p class="text-xs text-slate-500">Official details submitted by the parent</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-red-50 text-jrs-red border border-red-200 text-xs font-bold">
                        {{ $admissionEnquiry->admission_type }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Grade / Class Applied -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-book mr-1"></i>Applying Grade / Class
                        </span>
                        <p class="text-base font-extrabold text-jrs-navy">
                            {{ $admissionEnquiry->grade }}
                        </p>
                    </div>

                    <!-- Student Date of Birth -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-calendar-event mr-1"></i>Student Date of Birth
                        </span>
                        @if($admissionEnquiry->student_dob)
                            <p class="text-base font-extrabold text-slate-800">
                                {{ $admissionEnquiry->student_dob->format('d M, Y') }}
                                <span class="text-xs font-semibold text-slate-500 font-sans">
                                    ({{ \Carbon\Carbon::parse($admissionEnquiry->student_dob)->age }} years old)
                                </span>
                            </p>
                        @else
                            <p class="text-xs text-slate-400 italic">Not specified</p>
                        @endif
                    </div>

                    <!-- Academic Year -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-calendar-range mr-1"></i>Academic Year
                        </span>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $admissionEnquiry->academic_year ?? '2026-2027' }}
                        </p>
                    </div>

                    <!-- Branch / School Campus -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-geo-alt mr-1"></i>Campus Branch
                        </span>
                        <p class="text-sm font-bold text-slate-800">
                            {{ $admissionEnquiry->branch ?? 'JRS INTERNATIONAL SCHOOL' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Parent Contact Channel Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="bi bi-telephone-outbound-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Parent Contact Details</h3>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70">
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block mb-1">
                            <i class="bi bi-phone mr-1"></i>Parent Mobile Number
                        </span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $admissionEnquiry->parent_mobile) }}" class="text-base font-extrabold text-jrs-navy hover:text-jrs-red transition-colors inline-flex items-center gap-1.5">
                            <span>{{ $admissionEnquiry->parent_mobile }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Parent Enquiry Notes or Initial Message -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <div class="w-7 h-7 rounded-lg bg-red-50 text-jrs-red flex items-center justify-center text-xs">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Parent Enquiry Notes / Requirements</h3>
                </div>

                <div class="relative bg-slate-50 rounded-xl p-5 border border-slate-200/80">
                    <i class="bi bi-quote text-slate-300 text-3xl absolute top-3 right-4 select-none"></i>
                    @if(!empty($admissionEnquiry->notes))
                        <p class="text-sm text-slate-800 leading-relaxed whitespace-pre-wrap font-sans relative z-10">
                            {{ $admissionEnquiry->notes }}
                        </p>
                    @else
                        <p class="text-xs text-slate-400 italic relative z-10">
                            No special requirements or remarks were submitted with this enquiry.
                        </p>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Management Column (1 col) -->
        <div class="space-y-6">

            <!-- Status & Counselor Notes Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="bi bi-sliders text-jrs-red"></i>
                    <span>Enquiry Status & Notes</span>
                </h3>

                <form action="{{ route('admin.admission-enquiries.update', $admissionEnquiry) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Enquiry Status</label>
                        <select name="status" class="w-full text-xs font-bold rounded-lg px-3 py-2 border border-slate-300 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-white">
                            <option value="pending" {{ $admissionEnquiry->status === 'pending' ? 'selected' : '' }}>⏳ Pending Review</option>
                            <option value="contacted" {{ $admissionEnquiry->status === 'contacted' ? 'selected' : '' }}>📞 Contacted Parent</option>
                            <option value="admitted" {{ $admissionEnquiry->status === 'admitted' ? 'selected' : '' }}>🎓 Student Admitted</option>
                            <option value="closed" {{ $admissionEnquiry->status === 'closed' ? 'selected' : '' }}>✖ Closed / Archive</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Counselor Remarks / Notes</label>
                        <textarea name="notes" rows="4" placeholder="Enter follow-up notes, discussion details, or scheduled campus tour date..."
                                  class="w-full text-xs rounded-lg px-3 py-2 border border-slate-300 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none bg-white text-slate-800">{{ old('notes', $admissionEnquiry->notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-jrs-navy hover:bg-jrs-red text-white text-xs font-bold rounded-lg transition-colors shadow-xs">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Submission Metadata Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="bi bi-info-circle text-slate-400"></i>
                    <span>Submission Info</span>
                </h3>

                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Record ID</span>
                        <span class="font-mono font-bold text-slate-700">#{{ $admissionEnquiry->id }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Submitted At</span>
                        <span class="font-medium text-slate-700">{{ $admissionEnquiry->created_at->timezone(config('app.display_timezone'))->format('d M Y, h:i A T') }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Last Updated</span>
                        <span class="font-medium text-slate-700">{{ $admissionEnquiry->updated_at->timezone(config('app.display_timezone'))->format('d M Y, h:i A T') }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Source</span>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold text-[10px]">Website Enquiry Form</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
