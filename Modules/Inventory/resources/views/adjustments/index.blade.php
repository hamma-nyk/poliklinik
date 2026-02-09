<x-app-layout title="Stock Adjustment">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('Penyesuaian Stok') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Koreksi manual inventaris (Rusak, Hilang, atau Temuan)</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Adjustment</span>
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
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar --}}
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 dark:bg-slate-700 rounded-xl text-indigo-600 dark:text-indigo-400 border border-transparent dark:border-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Log Koreksi Stok</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan mutasi penyesuaian manual</p>
                    </div>
                </div>
                <div class="mb-4 flex gap-2">
                <a href="{{ route('inventory.adjustments.create') }}" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all duration-200 uppercase tracking-wider">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Buat Penyesuaian
                </a>
                
    {{-- Tombol untuk membuka Modal Filter --}}
    <div x-data="{ openFilter: false }" class="relative">
        <button @click="openFilter = !openFilter" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 shadow-sm hover:bg-indigo-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Laporan Per Periode
        </button>

        {{-- Dropdown / Modal Kecil --}}
        <div x-show="openFilter" 
             @click.outside="openFilter = false"
             class="absolute z-50 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 p-4"
             style="display: none;">
            
            <form action="{{ route('inventory.stock_adjustment.export_period') }}" method="GET" target="_blank">
                <div class="mb-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" class="w-full border-slate-300 rounded-lg text-sm" required value="{{ date('Y-m-01') }}">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="w-full border-slate-300 rounded-lg text-sm" required value="{{ date('Y-m-d') }}">
                </div>

                <div class="flex gap-2">
                    <button type="submit" name="type" value="pdf" class="flex-1 bg-red-600 text-white text-xs py-2 rounded font-bold hover:bg-red-700">
                        PDF
                    </button>
                    <button type="submit" name="type" value="excel" class="flex-1 bg-green-600 text-white text-xs py-2 rounded font-bold hover:bg-green-700">
                        Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>

            {{-- Table Content --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-[2rem] border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-700/30 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700">
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-6 py-5">Item Obat</th>
                                <th class="px-6 py-5 text-center">Tipe Adjustment</th>
                                <th class="px-6 py-5 text-center">Kuantitas</th>
                                <th class="px-8 py-5">Alasan / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($adjustments as $trx)
                                @foreach($trx->items as $item)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</div>
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">{{ $trx->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-800 dark:text-slate-200 text-base leading-none mb-1 group-hover:text-indigo-600 transition-colors">{{ $item->medicine->name }}</div>
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono font-semibold tracking-widest uppercase italic">{{ $item->medicine->code }}</div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        @if($trx->type == 'in')
                                            <span class="inline-flex items-center px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-emerald-200 dark:border-emerald-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-rose-200 dark:border-rose-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <div class="text-xl font-bold tabular-nums {{ $trx->type == 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $trx->type == 'in' ? '+' : '-' }}{{ number_format($item->quantity) }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ $item->medicine->unit }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl border border-slate-100 dark:border-slate-600 text-sm text-slate-600 dark:text-slate-400 italic leading-relaxed">
                                            {{ str_replace('Adjustment: ', '', $trx->notes) ?: 'Tanpa catatan khusus' }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-6 bg-slate-50 dark:bg-slate-700 rounded-full mb-4 text-slate-300 dark:text-slate-500 transition-colors border border-dashed dark:border-slate-600">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            </div>
                                            <h3 class="text-slate-500 dark:text-slate-400 font-bold text-lg uppercase tracking-tight">Belum ada penyesuaian</h3>
                                            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1 max-w-xs mx-auto italic leading-relaxed">Semua riwayat koreksi stok manual akan tercatat secara permanen di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($adjustments->hasPages())
                    <div class="p-8 border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30 transition-colors">
                        {{ $adjustments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>