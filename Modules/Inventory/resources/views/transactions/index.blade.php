<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">
                    {{ __('Transaksi Obat') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Log mutasi stok barang masuk dan keluar inventaris</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Transaksi</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Obat</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Filters & Search --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 flex flex-col lg:flex-row justify-between items-center gap-4">
                
                <form method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full sm:w-20 items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    {{-- Type Filter --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="type" onchange="this.form.submit()" 
                                class="flex h-9 w-full sm:w-44 items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            <option value="">Semua Tipe Transaksi</option>
                            <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk (In)</option>
                            <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar (Out)</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode Transaksi..." 
                               class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                </form>

                <div class="w-full lg:w-auto flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('inventory.transactions.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Input Transaksi Obat Masuk
                    </a>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Tanggal & Kode</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Tipe</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Jumlah Item</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Catatan</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($transactions as $trx)
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td class="p-4 align-middle">
                                    <div class="flex items-center">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <div class="ml-4 grid gap-0.5">
                                            <div class="font-medium text-neutral-800 dark:text-neutral-200">{{ $trx->code }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 align-middle text-center">
                                    @if($trx->type == 'in')
                                        <span class="inline-flex items-center rounded-md border border-transparent bg-emerald-500/10 text-emerald-500 px-2.5 py-0.5 text-xs font-semibold">
                                            MASUK
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md border border-transparent bg-destructive/10 text-destructive px-2.5 py-0.5 text-xs font-semibold">
                                            KELUAR
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 align-middle">
                                    <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                        <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $trx->items->count() }}</span> Jenis Obat
                                    </div>
                                </td>

                                <td class="p-4 align-middle">
                                    <div class="text-sm text-neutral-500 dark:text-neutral-500 truncate max-w-xs" title="{{ $trx->notes }}">
                                        {{ $trx->notes ?? '-' }}
                                    </div>
                                </td>

                                <td class="p-4 align-middle text-center">
                                    <div class="flex justify-center items-center">
                                        <a href="{{ route('inventory.transactions.show', $trx->id) }}" 
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                                            
                                            <span class="text-[11px] font-bold uppercase tracking-widest">Detail</span>
                                            
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td colspan="5" class="p-4 align-middle text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <div class="bg-neutral-50 dark:bg-neutral-700/50 p-4 rounded-full mb-3 text-neutral-300 dark:text-neutral-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-medium text-lg">Belum ada transaksi</h3>
                                        <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1">Gunakan tombol "Input Transaksi" untuk mengelola stok.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($transactions->hasPages())
                <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                    {{ $transactions->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>