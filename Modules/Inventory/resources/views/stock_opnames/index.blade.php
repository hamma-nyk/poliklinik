<x-app-layout title="Riwayat Stok Opname">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('Riwayat Stok Opname') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Monitoring penyesuaian stok fisik vs sistem</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Stock Opname</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center p-4 mb-4 text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm relative dark:bg-slate-800 dark:text-emerald-400 dark:border-slate-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Search & Action --}}
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                
                <form method="GET" action="{{ route('inventory.stock-opnames.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="w-full sm:w-24 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-indigo-500 focus:ring-indigo-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 transition-all">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="No. Dokumen / Catatan..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100 dark:placeholder-slate-400">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('inventory.stock-opnames.create') }}" class="inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all duration-200 w-full md:w-auto uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Mulai Opname
                    </a>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-700/30 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700">
                                <th class="px-6 py-4 text-left">Waktu & Tanggal</th>
                                <th class="px-6 py-4 text-left">No. Dokumen</th>
                                <th class="px-6 py-4 text-left">Catatan Penyesuaian</th>
                                <th class="px-6 py-4 text-left">Petugas</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($opnames as $opname)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                        {{ \Carbon\Carbon::parse($opname->opname_date)->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-500 mt-0.5 font-medium italic">
                                        {{ $opname->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-indigo-50 dark:bg-slate-700 text-indigo-700 dark:text-indigo-300 rounded-xl text-[11px] font-bold font-mono border border-indigo-100 dark:border-slate-600 tracking-tight uppercase">
                                        #{{ $opname->opname_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-700 dark:text-slate-300 font-medium line-clamp-1 max-w-xs" title="{{ $opname->notes }}">
                                        {{ $opname->notes ?: '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-[10px] font-bold text-slate-600 dark:text-slate-300 mr-3 uppercase shadow-sm">
                                            {{ substr($opname->creator->name ?? '?', 0, 2) }}
                                        </div>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $opname->creator->name ?? 'Sistem' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <a href="{{ route('inventory.stock-opnames.show', $opname->id) }}" class="inline-flex items-center px-4 py-1.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-[10px] font-bold uppercase tracking-widest text-slate-700 dark:text-slate-300 shadow-sm hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all active:scale-95">
                                        Detail
                                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-6 bg-slate-50 dark:bg-slate-700 rounded-full mb-4 text-slate-300 dark:text-slate-500 border border-dashed dark:border-slate-600 transition-colors">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold text-lg uppercase tracking-tight">Belum ada riwayat</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1 max-w-sm mx-auto italic leading-relaxed">Riwayat Stok Opname akan muncul di sini setelah Anda melakukan penyesuaian stok inventaris.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($opnames->hasPages())
                    <div class="p-6 border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30 transition-colors">
                        {{ $opnames->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>