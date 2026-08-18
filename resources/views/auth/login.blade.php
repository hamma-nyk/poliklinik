<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-50">
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
<body class="h-full font-sans antialiased text-neutral-950 selection:bg-neutral-900 selection:text-white">

    <div class="flex min-h-screen">

        <div class="hidden sm:flex sm:w-1/2 bg-neutral-950 relative overflow-hidden items-center justify-center">
            
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=2070&auto=format&fit=crop" 
                     class="w-full h-full object-cover opacity-30 mix-blend-overlay transition-transform duration-[20s] hover:scale-110 ease-linear grayscale" 
                     alt="Medical Tech">
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/80 to-neutral-900/50"></div>
            </div>

            <div class="relative z-10 p-12 text-white max-w-lg animate-fade-in-up">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2.5 bg-white/5 backdrop-blur-sm border border-white/10 rounded-md shadow-sm">
                        <svg class="w-6 h-6 text-neutral-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    
                    <span class="text-xs font-semibold tracking-widest uppercase text-neutral-300 border border-neutral-700 bg-neutral-800/50 px-3 py-1 rounded-md">POLIKLINIK</span>
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-bold tracking-tight mb-6 leading-tight text-white">
                    PT. Nusantara Building Industries
                </h1>
                
                <p class="text-neutral-400 text-lg font-normal leading-relaxed border-l-2 border-neutral-700 pl-6">
                    Sistem manajemen klinis terpadu untuk efisiensi operasional dan pemantauan kesehatan karyawan secara real-time.
                </p>
                
                <div class="mt-12 flex gap-6 text-xs font-medium text-neutral-500 uppercase tracking-wide">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 
                        System Online
                    </div>
                    <div class="flex items-center gap-2">
                         <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        End-to-End Encrypted
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full sm:w-1/2 flex flex-col justify-center items-center bg-neutral-50 relative">

            <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-xl shadow border border-neutral-200 dark:bg-neutral-950 dark:border-neutral-800 z-10 mx-4 animate-fade-in-up delay-100">
                
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-semibold tracking-tight text-neutral-900">
                        Sign In
                    </h2>
                    <p class="mt-2 text-sm text-neutral-500">
                        Masuk untuk mengakses dashboard
                    </p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="username" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-neutral-900">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="username" name="username" type="text" autocomplete="username" required value="{{ old('username') }}"
                                class="flex h-10 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 pl-9 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="Masukkan username">
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-2 text-sm text-destructive" />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-neutral-900">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="flex h-10 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 pl-9 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-destructive" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <input id="remember_me" name="remember" type="checkbox" 
                                class="h-4 w-4 shrink-0 rounded-sm border border-neutral-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-neutral-900 cursor-pointer">
                            <label for="remember_me" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-neutral-600 cursor-pointer select-none">Ingat perangkat ini</label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-neutral-900 hover:text-neutral-700 hover:underline">
                                    Lupa password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                            class="inline-flex w-full items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 hover:bg-neutral-900/90 h-10 px-4 py-2">
                            Log In
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center animate-fade-in-up delay-200">
                    <p class="text-xs text-neutral-500 leading-relaxed">
                        &copy;2026 IKOIT | PT. Nusantara Building Industries<br>
                        Authorized Personnel Only.
                    </p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>