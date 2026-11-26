<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
        <title>{{ $title ?? config('app.name', 'Poliklinik: PT Nusantara Building Industries') }}</title>
        <link rel="icon" href="{{ asset('logo.ico') }}" type="icon/ico">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <script>
                // 1. Cek apakah user pernah milih tema sebelumnya?
                const userTheme = localStorage.getItem('theme');
                // 2. Cek apakah sistem operasi user mode gelap?
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                // 3. Tentukan status awal
                if (userTheme === 'dark' || (!userTheme && systemDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    </head>
    
    <body class="font-sans antialiased bg-neutral-50 dark:bg-neutral-900 text-neutral-950 dark:text-neutral-50 transition-colors duration-300">
        
        <canvas id="particles-canvas" class="fixed inset-0 z-0 pointer-events-none" aria-hidden="true"></canvas>

        <div x-data="{ sidebarOpen: false }" class="relative z-10 flex h-screen overflow-hidden">

            @include('layouts.navigation')

            <div class="relative flex flex-col flex-1 min-w-0 overflow-hidden">
                
                <header class="flex items-center justify-between px-4 py-3 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md border-b border-neutral-200/80 dark:border-neutral-700/50 md:hidden shrink-0 transition-colors duration-300">
                    <button @click="sidebarOpen = true" type="button" aria-label="Buka menu navigasi" class="p-1.5 -ml-1.5 rounded-md text-neutral-500 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="text-sm font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">Poliklinik System</span>
                    <div class="w-6"></div>
                </header>

                <div class="flex-1 overflow-y-auto overflow-x-hidden flex flex-col">
                    @if (isset($header))
                        <header class="bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md shadow-sm z-10 border-b border-neutral-200/80 dark:border-neutral-700/50 transition-colors duration-300 shrink-0 md:h-[84px] flex items-center"> 
                            <div class="w-full max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                        <div class="max-w-7xl mx-auto">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
            
        </div>
        @stack('scripts')
    </body>
</html>