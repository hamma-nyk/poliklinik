<x-app-layout title="Stock Adjustment">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Penyesuaian Stok') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Koreksi manual inventaris (Rusak, Hilang, atau Temuan)</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Adjustment</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 dark:bg-neutral-700 rounded-xl text-indigo-600 dark:text-indigo-400 border border-transparent dark:border-neutral-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-neutral-800 dark:text-neutral-100 uppercase tracking-tight">Log Koreksi Stok</h3>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Menampilkan mutasi penyesuaian manual</p>
                    </div>
                </div>
                <div class="mb-4 flex gap-2">
                <a href="{{ route('inventory.adjustments.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto uppercase tracking-wider">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Buat Penyesuaian
                </a>
                
    {{-- Tombol untuk membuka Modal Filter --}}
    <div x-data="{ openFilter: false }" class="relative">
        <button @click="openFilter = !openFilter" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Laporan Per Periode
        </button>

        {{-- Dropdown / Modal Kecil --}}
        <div x-show="openFilter" 
             @click.outside="openFilter = false"
             class="absolute right-0 z-50 mt-2 w-80 rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4"
             style="display: none;">
            
            <form action="{{ route('inventory.stock_adjustment.export_period') }}" method="GET" target="_blank">
                <div class="mb-3">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-1 block">Dari Tanggal</label>
                    <input type="date" name="start_date" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required value="{{ date('Y-m-01') }}">
                </div>
                <div class="mb-4">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-1 block">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required value="{{ date('Y-m-d') }}">
                </div>

                <div class="flex gap-2">
                    <button type="submit" name="type" value="pdf" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 flex-1">
                        PDF
                    </button>
                    <button type="submit" name="type" value="excel" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 flex-1">
                        Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>

            {{-- Table Content --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Tanggal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Item Obat</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Tipe Adjustment</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Kuantitas</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Alasan / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($adjustments as $trx)
                                @foreach($trx->items as $item)
                                <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                    <td class="p-4 align-middle whitespace-nowrap">
                                        <div class="font-medium">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $trx->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="font-medium">{{ $item->medicine->name }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $item->medicine->code }}</div>
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        @if($trx->type == 'in')
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-emerald-500/10 text-emerald-500 px-2.5 py-0.5 text-xs font-semibold">
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-destructive/10 text-destructive px-2.5 py-0.5 text-xs font-semibold">
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        <div class="text-md font-bold tabular-nums {{ $trx->type == 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $trx->type == 'in' ? '+' : '-' }}{{ number_format($item->quantity) }}
                                        </div>
                                        <div class="text-[10px] text-neutral-400 uppercase font-semibold">{{ $item->medicine->unit }}</div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="text-sm">
                                            {{ str_replace('Adjustment: ', '', $trx->notes) ?: 'Tanpa catatan khusus' }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-6 bg-neutral-50 dark:bg-neutral-700 rounded-full mb-4 text-neutral-300 dark:text-neutral-500 transition-colors border border-dashed dark:border-neutral-600">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            </div>
                                            <h3 class="text-neutral-500 dark:text-neutral-400 font-bold text-lg uppercase tracking-tight">Belum ada penyesuaian</h3>
                                            <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1 max-w-xs mx-auto italic leading-relaxed">Semua riwayat koreksi stok manual akan tercatat secara permanen di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($adjustments->hasPages())
                    <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                        {{ $adjustments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>