<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | JRS International School</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        jrs: {
                            navy: '#031c3f',
                            'navy-dark': '#01122a',
                            'navy-light': '#0a2a5a',
                            red: '#e31e24',
                            'red-dark': '#b91c1c',
                            gold: '#f59e0b',
                            amber: '#ffbe1a',
                            accent: '#013aa3',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #01122a 0%, #031c3f 50%, #0a2a5a 100%);
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 antialiased text-slate-800 relative overflow-hidden">

    <!-- Decorative background glow spheres -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-jrs-red/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white shadow-xl shadow-black/20 p-2 mb-3">
                <span class="font-extrabold text-jrs-navy text-2xl tracking-tighter">JRS</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white font-heading tracking-tight">JRS International School</h1>
            <p class="text-xs text-amber-300 font-medium tracking-wide mt-1 uppercase">Admin Portal & Management System</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl shadow-black/40 p-7 sm:p-9 border border-white/20">

            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900 font-heading">Sign In to Dashboard</h2>
                <p class="text-xs text-slate-500 mt-1">Enter your administrator credentials to continue</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Admin Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/></svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', 'admin@jrsschool.com') }}" required placeholder="admin@jrsschool.com" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red transition-all">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password" value="admin123" required placeholder="••••••••" class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-jrs-red/20 focus:border-jrs-red transition-all">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1" checked class="w-4 h-4 text-jrs-red rounded border-slate-300 focus:ring-jrs-red">
                        <span class="text-xs text-slate-600 font-medium">Remember me</span>
                    </label>
                    <span class="text-xs text-slate-400">Secure Access</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-4 py-3 rounded-xl bg-jrs-red hover:bg-jrs-red-dark text-white font-bold text-sm shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2">
                    <span>Sign In to Dashboard</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="mt-6 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-slate-800 uppercase tracking-wider text-[10px]">Default Credentials</span>
                    <button type="button" onclick="fillCredentials()" class="text-jrs-red font-bold hover:underline text-[11px]">Fill Form</button>
                </div>
                <div class="grid grid-cols-2 gap-2 text-slate-600">
                    <div>
                        <span class="text-[10px] text-slate-400 block">Email:</span>
                        <code class="font-bold text-slate-800 select-all">admin@jrsschool.com</code>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block">Password:</span>
                        <code class="font-bold text-slate-800 select-all">admin123</code>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer link back to website -->
        <div class="text-center mt-6">
            <a href="https://jrs-school.vercel.app/" target="_blank" class="text-xs text-slate-300 hover:text-white transition-colors inline-flex items-center gap-1.5">
                <span>← Back to JRS International School Website</span>
            </a>
        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            if (passInput.type === 'password') {
                passInput.type = 'text';
            } else {
                passInput.type = 'password';
            }
        }

        function fillCredentials() {
            document.getElementById('email').value = 'admin@jrsschool.com';
            document.getElementById('password').value = 'admin123';
        }
    </script>
</body>
</html>
