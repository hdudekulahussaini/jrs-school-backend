@extends('admin.layout')

@section('title', 'Parent Teacher Association (PTA)')
@section('header', 'PTA Committee Members')

@section('content')
<div class="space-y-6">

    <!-- Page Header (shadcn/ui style) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-heading">Parent Teacher Association</h2>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-0.5 text-xs font-semibold text-slate-700">
                    {{ $totalCount }} {{ Str::plural('member', $totalCount) }}
                </div>
            </div>
            <p class="text-sm text-slate-500">
                Manage the PTA committee members, designations (Chairman, Member), residential address, and contact numbers.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pta-members.create') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 py-2 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Add PTA Member</span>
            </a>
        </div>
    </div>

    <!-- Toolbar: Search -->
    <div class="flex items-center justify-between gap-3">
        <form action="{{ route('admin.pta-members.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-80">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone, address..." class="flex h-9 w-full rounded-md border border-slate-200 bg-white pl-9 pr-3 py-1 text-xs sm:text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
            </div>
            @if(request('search'))
                <a href="{{ route('admin.pta-members.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-2.5 h-9 text-slate-600 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>
        <span class="text-xs text-slate-500 font-medium hidden sm:inline-block">Total: {{ $totalCount }} members</span>
    </div>

    <!-- Members Table (shadcn/ui style) -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full caption-bottom text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 text-slate-500 font-medium text-xs">
                        <th class="h-10 px-4 w-16 text-center">Order</th>
                        <th class="h-10 px-4 w-20">Avatar</th>
                        <th class="h-10 px-4 min-w-[200px]">Member & Role</th>
                        <th class="h-10 px-4 min-w-[200px]">Address & Contact</th>
                        <th class="h-10 px-4 w-28 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($members as $member)
                        <tr class="transition-colors hover:bg-slate-50/60">
                            <!-- Sort Order -->
                            <td class="p-4 align-middle text-center font-mono text-xs text-slate-400">
                                #{{ $member->sort_order }}
                            </td>

                            <!-- Avatar -->
                            <td class="p-4 align-middle">
                                <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-slate-400 font-bold text-sm">
                                    @if($member->image_full_url)
                                        <img src="{{ $member->image_full_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    @endif
                                </div>
                            </td>

                            <!-- Name & Designation -->
                            <td class="p-4 align-middle">
                                <div class="font-semibold text-slate-900 font-heading text-sm">{{ $member->name }}</div>
                                <div class="mt-1">
                                    @if(strtoupper($member->designation) === 'CHAIRMAN')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                            <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            CHAIRMAN
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ strtoupper($member->designation) }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Address & Phone -->
                            <td class="p-4 align-middle space-y-1">
                                @if($member->address)
                                    <div class="flex items-center gap-1.5 text-xs text-slate-600">
                                        <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>{{ $member->address }}</span>
                                    </div>
                                @endif
                                @if($member->phone)
                                    <div class="flex items-center gap-1.5 text-xs text-slate-600 font-mono">
                                        <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        <span>{{ $member->phone }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 align-middle text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.pta-members.edit', $member->id) }}" class="p-1.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-md transition-colors" title="Edit Member">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.pta-members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PTA member?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Delete Member">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500 text-sm">
                                No PTA committee members found. Click "Add PTA Member" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $members->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
