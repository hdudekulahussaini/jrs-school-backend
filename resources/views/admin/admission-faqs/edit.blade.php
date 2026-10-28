@extends('admin.layout')

@section('title', 'Edit Admission FAQ')
@section('header', 'Edit Admission FAQ')

@section('content')
<div class="space-y-6 w-full">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.admission-faqs.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-jrs-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Back to Admission FAQs</span>
        </a>
    </div>

    <!-- Edit Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-red-600 tracking-wider uppercase font-heading">Admissions FAQs</span>
                <h3 class="font-bold text-jrs-navy font-heading text-base">Edit FAQ</h3>
            </div>
            <span class="text-xs font-mono font-bold text-jrs-navy bg-slate-100 px-2 py-1 rounded-md">ID #{{ $faq->id }}</span>
        </div>

        <form action="{{ route('admin.admission-faqs.update', $faq->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Question -->
            <div>
                <label for="question" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Question *</label>
                <input type="text" name="question" id="question" required value="{{ old('question', $faq->question) }}" placeholder="e.g. What is the admission procedure?" class="w-full px-3.5 py-2 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800">
                @error('question') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Answer -->
            <div>
                <label for="answer" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Answer *</label>
                <textarea name="answer" id="answer" rows="5" required placeholder="Provide clear and helpful answer for parents..." class="w-full px-3.5 py-2.5 rounded-xl text-sm border border-slate-200 focus:border-jrs-navy focus:ring-1 focus:ring-jrs-navy outline-none transition-colors text-slate-800 leading-relaxed">{{ old('answer', $faq->answer) }}</textarea>
                @error('answer') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.admission-faqs.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20">
                    Update FAQ
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
