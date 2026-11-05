@extends('admin.layout')

@section('title', 'Admission Popups')
@section('header', 'Admission Popups')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-jrs-navy">Admission Popup Management</h1>
            <p class="mt-1 text-xs text-slate-500">Create and manage the admission popups displayed on the website.</p>
        </div>
        @if($popups->isEmpty())
            <a href="{{ route('admin.admission-popup.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-jrs-red px-4 py-2.5 text-xs font-bold text-white shadow-xs transition-colors hover:bg-red-700">
                <i class="bi bi-plus-lg"></i>
                <span>Add Admission Popup</span>
            </a>
        @endif
    </div>

    @if($errors->has('popup'))
        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first('popup') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3 font-bold">Popup</th>
                        <th scope="col" class="px-5 py-3 font-bold">Academic Year</th>
                        <th scope="col" class="px-5 py-3 font-bold">Phone</th>
                        <th scope="col" class="px-5 py-3 font-bold">Status</th>
                        <th scope="col" class="px-5 py-3 text-right font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($popups as $popup)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($popup->image_full_url)
                                        <img src="{{ $popup->image_full_url }}" alt="" class="h-12 w-12 rounded-lg border border-slate-200 object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-400">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $popup->badge_text ?: 'Admission Popup' }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">{{ $popup->school_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $popup->academic_year_highlight ?: '—' }}</td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $popup->phone_number ?: '—' }}</td>
                            <td class="px-5 py-4">
                                @if($popup->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.admission-popup.edit', $popup->id) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50" title="Edit popup">
                                        <i class="bi bi-pencil"></i><span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin.admission-popup.toggle-record', $popup->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-2 text-xs font-semibold {{ $popup->is_active ? 'border-amber-200 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                            <i class="bi bi-power"></i><span>{{ $popup->is_active ? 'Disable' : 'Enable' }}</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.admission-popup.destroy', $popup->id) }}" method="POST" onsubmit="return confirm('Delete this Admission Popup?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                                            <i class="bi bi-trash3"></i><span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="text-sm font-semibold text-slate-700">No admission popups yet</div>
                                <p class="mt-1 text-xs text-slate-500">Create a popup to configure the admission message shown to visitors.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($popups->hasPages())
            <div class="border-t border-slate-200 p-4">{{ $popups->links() }}</div>
        @endif
    </div>
</div>
@endsection
