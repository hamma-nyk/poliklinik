<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Internal System - Poliklinik</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Custom */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 selection:bg-blue-500 selection:text-white">

    <div class="flex min-h-screen">

        <div class="hidden sm:flex sm:w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center">
            
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=2070&auto=format&fit=crop" 
                     class="w-full h-full object-cover opacity-50 mix-blend-overlay transition-transform duration-[20s] hover:scale-110 ease-linear" 
                     alt="Medical Tech">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            </div>

            <div class="relative z-10 p-12 text-white max-w-lg animate-fade-in-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="text-xs font-bold tracking-[0.2em] uppercase text-blue-200 border border-blue-500/30 bg-blue-500/10 px-3 py-1 rounded-full">Secure Access</span>
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-bold tracking-tight mb-6 leading-tight">
                    Enterprise <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-300">Health System</span>
                </h1>
                
                <p class="text-slate-300 text-lg font-light leading-relaxed border-l-2 border-blue-500 pl-6">
                    Sistem manajemen klinis terpadu untuk efisiensi operasional dan pemantauan kesehatan karyawan secara real-time.
                </p>
                
                <div class="mt-12 flex gap-6 text-xs font-medium text-slate-400 uppercase tracking-wide">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span> 
                        System Online
                    </div>
                    <div class="flex items-center gap-2">
                         <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        End-to-End Encrypted
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-1/2 flex flex-col justify-center items-center bg-slate-50 relative">
            
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-[20%] -right-[10%] w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
                <div class="absolute top-[40%] -left-[10%] w-72 h-72 bg-cyan-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
            </div>

            <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-2xl shadow-xl shadow-slate-200/50 z-10 mx-4 animate-fade-in-up delay-100 border border-slate-100">
                
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                        Sign In
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Masuk untuk mengakses dashboard
                    </p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Corporate Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-lg leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                                placeholder="user@company.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-lg leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">Ingat perangkat ini</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 hover:underline">
                                    Lupa password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg shadow-blue-900/20 text-sm font-bold text-white bg-slate-900 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all duration-300 transform hover:-translate-y-1">
                            LOG IN
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center animate-fade-in-up delay-200">
                    <p class="text-xs text-slate-400 leading-relaxed">
                        &copy; {{ date('Y') }} PT. Corporate Name. <br>
                        Authorized Personnel Only.
                    </p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>