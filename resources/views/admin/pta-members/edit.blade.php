@extends('admin.layout')

@section('title', 'Edit PTA Member')
@section('header', 'Edit Member')

@section('content')
<div class="space-y-6 w-full">

    <!-- Breadcrumb -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2 text-sm text-slate-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.pta-members.index') }}" class="hover:text-slate-900 transition-colors">PTA Members</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">Edit Member</span>
        </div>
        <a href="{{ route('admin.pta-members.index') }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-slate-200 bg-white px-3 h-8 text-slate-700 hover:bg-slate-50 transition-colors">
            &larr; Back to list
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold leading-none tracking-tight text-slate-900 font-heading">Edit Member: {{ $member->name }}</h3>
                <p class="text-sm text-slate-500 mt-1.5">Modify committee role, address, phone number, or photo.</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $member->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $member->is_active ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                {{ $member->is_active ? 'Active' : 'Disabled' }}
            </span>
        </div>

        <form action="{{ route('admin.pta-members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Member Info -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium leading-none text-slate-700">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $member->name) }}" class="flex h-9 w-full rounded-md border @error('name') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        @error('name')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="designation" class="text-sm font-medium leading-none text-slate-700">Designation / Role <span class="text-red-500">*</span></label>
                        <input type="text" name="designation" id="designation" required value="{{ old('designation', $member->designation) }}" placeholder="e.g. CHAIRMAN, MEMBER, SECRETARY" class="flex h-9 w-full rounded-md border @error('designation') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                        @error('designation')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="phone" class="text-sm font-medium leading-none text-slate-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="text-sm font-medium leading-none text-slate-700">Location / Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $member->address) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-slate-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 2: Photo Upload & Current Avatar -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Avatar / Photo</h4>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image',
                    'id' => 'image',
                    'label' => 'Member Avatar Photo',
                    'current' => $member->image_full_url ?? null,
                    'currentPath' => $member->image_path ?? null,
                    'aspect' => 'avatar',
                    'help' => 'Supported formats: JPG, PNG, WEBP (Max 6MB). Square or portrait recommended.',
                ])
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100"></div>

            <!-- Section 3: Ordering -->
            <div>
                <div class="space-y-2 max-w-xs">
                    <label for="sort_order" class="text-sm font-medium leading-none text-slate-700">Display Order</label>
                    <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $member->sort_order) }}" class="flex h-9 w-full rounded-md border border-slate-200 bg-white px-3 py-1 text-sm shadow-xs transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pta-members.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-200 bg-white px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors bg-slate-900 text-white shadow-xs hover:bg-slate-800 h-9 px-4 py-2 gap-2">
                    <span>Update Member</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
