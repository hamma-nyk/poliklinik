@props(['route', 'label', 'count', 'icon', 'activeColor', 'bgColor', 'darkBgColor', 'hoverBg'])

<a href="{{ route($route) }}" 
   class="group rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 transition-all hover:bg-neutral-50 dark:hover:bg-neutral-700 {{ $activeColor }}">
    <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
        <h3 class="tracking-tight text-sm font-medium">{{ $label }}</h3>
        <div class="h-4 w-4 text-neutral-500 dark:text-neutral-400">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
            </svg>
        </div>
    </div>
    <div class="p-6 pt-0">
        <div class="text-2xl font-bold">{{ number_format($count) }}</div>
    </div>
</a>