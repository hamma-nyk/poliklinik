<x-app-layout title="Riwayat Stok Opname">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Riwayat Stok Opname') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Monitoring penyesuaian stok fisik vs sistem</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Stock Opname</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Search & Action --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-4 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                
                <form method="GET" action="{{ route('inventory.stock-opnames.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full sm:w-20 items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="No. Dokumen / Catatan..." 
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('inventory.stock-opnames.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90 w-full md:w-auto uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Mulai Opname
                    </a>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Waktu & Tanggal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">No. Dokumen</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Catatan Penyesuaian</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Petugas</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($opnames as $opname)
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 group">
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-bold">
                                        {{ \Carbon\Carbon::parse($opname->opname_date)->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] mt-0.5 font-medium italic text-slate-500 dark:text-slate-400">
                                        {{ $opname->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex items-center rounded-md border border-transparent bg-slate-900 text-slate-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-50 dark:text-slate-900 font-mono uppercase">
                                        #{{ $opname->opname_number }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-medium line-clamp-1 max-w-xs" title="{{ $opname->notes }}">
                                        {{ $opname->notes ?: '-' }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-xs font-medium dark:border-slate-800 dark:bg-slate-900 mr-3 uppercase">
                                            {{ substr($opname->creator->name ?? '?', 0, 2) }}
                                        </div>
                                        <span class="grid gap-0.5 font-medium">{{ $opname->creator->name ?? 'Sistem' }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    <a href="{{ route('inventory.stock-opnames.show', $opname->id) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-8 px-3 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50 uppercase tracking-widest">
                                        Detail
                                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 align-middle text-center py-24">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-6 rounded-full mb-4 border border-dashed border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="font-semibold text-lg uppercase tracking-tight text-slate-500 dark:text-slate-400">Belum ada riwayat</h3>
                                        <p class="text-sm mt-1 max-w-sm mx-auto italic leading-relaxed text-slate-500 dark:text-slate-400">Riwayat Stok Opname akan muncul di sini setelah Anda melakukan penyesuaian stok inventaris.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($opnames->hasPages())
                    <div class="border-t border-slate-200 dark:border-slate-800 p-4 transition-colors">
                        {{ $opnames->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>