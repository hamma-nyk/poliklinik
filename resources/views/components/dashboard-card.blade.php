@props(['route', 'label', 'count', 'icon', 'activeColor', 'bgColor', 'darkBgColor', 'hoverBg'])

<a href="{{ route($route) }}" 
   class="group bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl {{ $activeColor }}">
    <div class="flex justify-between items-start mb-4">
        <div class="p-3 {{ $bgColor }} {{ $darkBgColor }} rounded-2xl transition-all duration-300 {{ $hoverBg }} group-hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
            </svg>
        </div>
        <span class="text-3xl font-bold text-slate-800 dark:text-slate-100 tracking-tighter">
            {{ number_format($count) }}
        </span>
    </div>
    <div>
        <div class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.15em] mb-1">
            {{ $label }}
        </div>
        <div class="flex items-center text-[10px] font-bold opacity-0 group-hover:opacity-100 transition-opacity {{ str_replace('bg-', 'text-', explode(' ', $bgColor)[0]) }}">
            Lihat Detail 
            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </div>
    </div>
</a>