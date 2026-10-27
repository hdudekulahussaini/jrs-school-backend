@extends('admin.layout')

@section('title', 'Admin Profile Management')
@section('header', 'Admin Profile Settings')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-12">

    <!-- Top Profile Summary Card -->
    <div class="bg-gradient-to-r from-jrs-navy via-[#052b61] to-jrs-navy rounded-2xl p-6 sm:p-8 text-white shadow-md border border-white/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-20 top-0 w-32 h-32 bg-jrs-red/10 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <!-- Administrator Initial Avatar Badge -->
            <div class="relative shrink-0">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-jrs-red to-rose-700 text-white ring-4 ring-white/20 shadow-lg flex items-center justify-center font-extrabold text-3xl font-heading">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-emerald-500 ring-2 ring-jrs-navy flex items-center justify-center text-[10px] text-white shadow-xs" title="Active Administrator">
                    <i class="bi bi-shield-fill-check"></i>
                </span>
            </div>

            <!-- Profile Overview Info -->
            <div class="flex-1 text-center sm:text-left space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold tracking-wide text-white">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>System Administrator</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white font-heading tracking-tight">
                    {{ $user->name }}
                </h1>
                <p class="text-sm text-white/80 flex items-center justify-center sm:justify-start gap-2">
                    <i class="bi bi-envelope-fill text-white/60"></i>
                    <span>{{ $user->email }}</span>
                </p>
                <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs text-white/70">
                    <span class="inline-flex items-center gap-1.5">
                        <i class="bi bi-calendar3"></i>
                        <span>Member since {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</span>
                    </span>
                    @if($user->updated_at)
                    <span class="inline-flex items-center gap-1.5">
                        <i class="bi bi-clock-history"></i>
                        <span>Last updated {{ $user->updated_at->diffForHumans() }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3-Column Grid of Management Forms -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ========================================== -->
        <!-- FORM 1: UPDATE PROFILE (NAME)              -->
        <!-- ========================================== -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <!-- Form Header -->
                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-jrs-navy/10 text-jrs-navy flex items-center justify-center text-lg font-bold">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-jrs-navy font-heading">1. Personal Profile</h2>
                        <p class="text-xs text-slate-500">Update your administrator name</p>
                    </div>
                </div>

                <!-- Form Specific Alert -->
                @if(session('profile_success'))
                    <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600 text-sm"></i>
                        <span class="font-medium">{{ session('profile_success') }}</span>
                    </div>
                @endif

                <form id="profileDetailsForm" 
                      action="{{ route('admin.profile.update') }}" 
                      method="POST" 
                      class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Administrator Name -->
                    <div>
                        <label for="admin_name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" 
                                   id="admin_name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   placeholder="Your full name" 
                                   class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border {{ $errors->has('name') ? 'border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-jrs-navy focus:ring-jrs-navy/20' }} focus:outline-hidden focus:ring-3 transition-colors bg-white">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-600 mt-1 font-medium flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-jrs-navy hover:bg-[#052b61] text-white text-xs font-bold tracking-wide uppercase shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-save2"></i>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- FORM 2: UPDATE EMAIL ADDRESS               -->
        <!-- ========================================== -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <!-- Form Header -->
                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-lg font-bold">
                        <i class="bi bi-envelope-at-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-jrs-navy font-heading">2. Change Email</h2>
                        <p class="text-xs text-slate-500">Update account email address</p>
                    </div>
                </div>

                <!-- Form Specific Alert -->
                @if(session('email_success'))
                    <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600 text-sm"></i>
                        <span class="font-medium">{{ session('email_success') }}</span>
                    </div>
                @endif

                @if(session('email_info'))
                    <div class="mb-4 p-3 rounded-lg bg-blue-50 border border-blue-200 text-blue-800 text-xs flex items-center gap-2">
                        <i class="bi bi-info-circle-fill text-blue-600 text-sm"></i>
                        <span class="font-medium">{{ session('email_info') }}</span>
                    </div>
                @endif

                <form id="emailUpdateForm" 
                      action="{{ route('admin.profile.email') }}" 
                      method="POST" 
                      class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Current Email (Read-Only) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                            Current Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="text" 
                                   value="{{ $user->email }}" 
                                   disabled 
                                   class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-slate-200 bg-slate-100 text-slate-600 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- New Email -->
                    <div>
                        <label for="admin_email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            New Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" 
                                   id="admin_email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   placeholder="admin@jrsschool.com" 
                                   class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-amber-500 focus:ring-amber-500/20' }} focus:outline-hidden focus:ring-3 transition-colors bg-white">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1 font-medium flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="p-3 rounded-lg bg-amber-50/70 border border-amber-200/60 text-amber-900 text-[11px] leading-relaxed flex items-start gap-2">
                        <i class="bi bi-shield-exclamation text-amber-600 shrink-0 text-sm mt-0.5"></i>
                        <span>This email is your administrator login ID. Changing it requires using the new email for future logins.</span>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold tracking-wide uppercase shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-envelope-check"></i>
                            <span>Update Email Address</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- FORM 3: CHANGE PASSWORD                   -->
        <!-- ========================================== -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <!-- Form Header -->
                <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-jrs-red/10 text-jrs-red flex items-center justify-center text-lg font-bold">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-jrs-navy font-heading">3. Change Password</h2>
                        <p class="text-xs text-slate-500">Update security credentials</p>
                    </div>
                </div>

                <!-- Form Specific Alert -->
                @if(session('password_success'))
                    <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600 text-sm"></i>
                        <span class="font-medium">{{ session('password_success') }}</span>
                    </div>
                @endif

                <form id="passwordUpdateForm" 
                      action="{{ route('admin.profile.password') }}" 
                      method="POST" 
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   required 
                                   placeholder="Enter current password" 
                                   class="w-full pl-9 pr-10 py-2 text-sm rounded-lg border {{ $errors->has('current_password') ? 'border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-jrs-red focus:ring-jrs-red/20' }} focus:outline-hidden focus:ring-3 transition-colors bg-white">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('current_password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-xs text-red-600 mt-1 font-medium flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-key"></i>
                            </span>
                            <input type="password" 
                                   id="new_password" 
                                   name="password" 
                                   required 
                                   placeholder="At least 8 characters" 
                                   class="w-full pl-9 pr-10 py-2 text-sm rounded-lg border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-jrs-red focus:ring-jrs-red/20' }} focus:outline-hidden focus:ring-3 transition-colors bg-white">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('new_password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1 font-medium flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-check2-circle"></i>
                            </span>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Re-enter new password" 
                                   class="w-full pl-9 pr-10 py-2 text-sm rounded-lg border {{ $errors->has('password_confirmation') ? 'border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-jrs-red focus:ring-jrs-red/20' }} focus:outline-hidden focus:ring-3 transition-colors bg-white">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password_confirmation', this)" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs text-red-600 mt-1 font-medium flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-jrs-red hover:bg-red-700 text-white text-xs font-bold tracking-wide uppercase shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-lock-fill"></i>
                            <span>Change Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    // Toggle password fields visibility
    function togglePasswordVisibility(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (!field) return;

        if (field.type === 'password') {
            field.type = 'text';
            if (icon) {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        } else {
            field.type = 'password';
            if (icon) {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    }
</script>
@endpush
@endsection
