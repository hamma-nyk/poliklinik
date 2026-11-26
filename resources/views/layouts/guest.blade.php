<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            const userTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (userTheme === 'dark' || (!userTheme && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-neutral-900 antialiased bg-neutral-50 dark:bg-neutral-900 dark:text-neutral-50 transition-colors duration-300">
        <canvas id="particles-canvas" class="fixed inset-0 z-0 pointer-events-none" aria-hidden="true"></canvas>
        <div class="relative z-10 min-h-screen flex flex-col justify-center items-center px-4 py-6 sm:px-6">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-neutral-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white/90 dark:bg-neutral-800/90 backdrop-blur-md border border-neutral-200/80 dark:border-neutral-700/60 shadow-lg rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
