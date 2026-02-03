<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan Pemakaian Obat') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Rekapitulasi pengeluaran resep dan penggunaan logistik medis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-rose-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Pemakaian</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('clinical.reports.medicines') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-rose-500 focus:ring-rose-500 text-sm transition-all shadow-sm">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-rose-500 focus:ring-rose-500 text-sm transition-all shadow-sm">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" name="action" value="filter" 
                            class="flex-1 md:flex-none bg-slate-800 dark:bg-rose-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-700 dark:hover:bg-rose-700 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
                            Tampilkan
                        </button>
                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="flex-1 md:flex-none bg-rose-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-rose-700 transition-all flex items-center justify-center shadow-lg shadow-rose-200 dark:shadow-none">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Results --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-rose-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-bold text-slate-700 dark:text-slate-200 uppercase text-xs tracking-wider">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Laporan Pengeluaran Stok</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-900/20">
                                <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-16">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Informasi Obat</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Satuan</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-tighter bg-rose-50/30 dark:bg-rose-900/10">Total Terpakai</th>
                                <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Sisa Stok Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($data as $index => $row)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                <td class="px-8 py-5 text-center text-sm font-medium text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $row->medicine->name ?? 'Obat Dihapus' }}</div>
                                    <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">{{ $row->medicine->code ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                        {{ $row->medicine->unit ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="inline-flex items-center px-4 py-1.5 bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-2xl font-black text-sm border border-rose-100 dark:border-rose-800/50 shadow-sm">
                                        {{ number_format($row->total_qty, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php $stock = $row->medicine->current_stock ?? 0; @endphp
                                    <span class="text-sm font-black {{ $stock <= 5 ? 'text-rose-600 animate-pulse' : 'text-slate-700 dark:text-slate-300' }}">
                                        {{ number_format($stock, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold">Data Pemakaian Kosong</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Tidak ditemukan riwayat obat keluar pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>