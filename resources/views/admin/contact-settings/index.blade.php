@extends('admin.layout')

@section('title', 'Contact Us Settings')
@section('header', 'Contact Us')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Top Action Header Banner -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-red-50 text-jrs-red text-xs font-semibold uppercase tracking-wider mb-1.5 border border-red-100">
                <span class="w-1.5 h-1.5 rounded-full bg-jrs-red animate-pulse"></span>
                <span>Get In Touch</span>
            </div>
            <h2 class="text-xl font-extrabold text-jrs-navy font-heading">Contact Information</h2>
            <p class="text-xs text-slate-500 mt-1">Manage official contact information, address, phone number, and Google Maps link.</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Contact Details</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Edit Contact Information</h3>
            </div>
        </div>

        <form action="{{ route('admin.contact-settings.update') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Address -->
            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Campus Address *</label>
                <textarea name="address" id="address" rows="3" required placeholder="e.g. JRS International School, Narapally, Near Uppal Depot, Hyderabad, Telangana" class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 leading-relaxed">{{ old('address', $contact->address) }}</textarea>
                @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number *</label>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone', $contact->phone) }}" placeholder="e.g. +91 915740 43210" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $contact->email) }}" placeholder="e.g. info@jrsinternationalschool.com" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Map Direct Link -->
            <div>
                <label for="map_link" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Google Maps Link (URL)</label>
                <input type="url" name="map_link" id="map_link" value="{{ old('map_link', $contact->map_link) }}" placeholder="https://maps.google.com/?q=..." class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none text-slate-800 font-mono text-xs">
                <span class="text-[11px] text-slate-400 mt-1 block">Link opens when visitors click "Get Directions" or the map button.</span>
                @error('map_link') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
