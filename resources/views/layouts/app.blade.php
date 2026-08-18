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
        
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

            @include('layouts.navigation')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                
                <header class="flex items-center justify-between px-6 py-4 bg-white dark:bg-neutral-800 border-b border-neutral-200 dark:border-neutral-600 md:hidden"> <!-- transition-colors duration-300 -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-neutral-500 dark:text-neutral-400 focus:outline-none hover:text-neutral-700 dark:hover:text-neutral-200">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="font-bold text-neutral-700 dark:text-neutral-200">Poliklinik System</div>
                </header>

                @if (isset($header))
                    <header class="bg-white dark:bg-neutral-800 shadow-sm z-10 border-b border-neutral-200 border-transparent dark:border-neutral-600 transition-colors duration-300"> 
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
            
        </div>
        @stack('scripts')
    </body>
</html>