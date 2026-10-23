@extends('admin.layout')

@section('title', 'Contact Messages')
@section('header', 'Contact Messages & Inquiries')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 font-heading">Parent & Visitor Inquiries</h3>
                <p class="text-xs text-slate-500">Messages submitted through the contact page</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                {{ $messages->total() }} Messages
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($messages as $msg)
                <div class="p-5 flex flex-col sm:flex-row items-start justify-between gap-4 hover:bg-slate-50/70 transition-colors {{ $msg->status === 'unread' ? 'bg-blue-50/20' : '' }}">
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900 text-sm">{{ $msg->name }}</span>
                            @if($msg->status === 'unread')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">New Message</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 text-xs text-slate-500 font-medium">
                            <a href="mailto:{{ $msg->email }}" class="text-jrs-navy hover:underline">✉️ {{ $msg->email }}</a>
                            @if($msg->phone)
                                <a href="tel:{{ $msg->phone }}" class="text-slate-600 hover:text-jrs-red">📞 {{ $msg->phone }}</a>
                            @endif
                            <span>• {{ $msg->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($msg->subject)
                            <div class="text-xs font-bold text-slate-700 mt-2">Subject: {{ $msg->subject }}</div>
                        @endif
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            {{ $msg->message }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if($msg->status === 'unread')
                            <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200">
                                    Mark as Read
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-500 text-sm">
                    No contact messages yet.
                </div>
            @endforelse
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
