<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan Mutasi Stok') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Monitoring pergerakan keluar-masuk item logistik medis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Mutasi Obat</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('clinical.reports.mutation') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('clinical.reports.index') }}" 
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-[11px] font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-600 transition-all shadow-sm active:scale-95 uppercase tracking-widest group">
                            <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" name="action" value="filter" 
                            class="flex-1 md:flex-none bg-slate-800 dark:bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-700 dark:hover:bg-indigo-700 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
                            Tampilkan
                        </button>
                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="flex-1 md:flex-none bg-rose-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-rose-700 transition-all flex items-center justify-center shadow-lg shadow-rose-200 dark:shadow-none">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Results --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-bold text-slate-700 dark:text-slate-200 uppercase text-xs tracking-wider">
                            Mutasi Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-900/20">
                                <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-16">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Detail Item Obat</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Satuan</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-green-600 dark:text-green-400 uppercase tracking-tighter bg-green-50/30 dark:bg-green-900/10">Total Masuk</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-tighter bg-rose-50/30 dark:bg-rose-900/10">Total Keluar</th>
                                <th class="px-8 py-4 text-center text-[11px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter bg-blue-50/30 dark:bg-blue-900/10">Stok Akhir</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($data as $index => $row)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                <td class="px-8 py-5 text-center text-sm font-medium text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $row->name }}</div>
                                    <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">{{ $row->code }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                        {{ $row->unit }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-5 text-center bg-green-50/10 dark:bg-green-900/5">
                                    <div class="inline-flex items-center text-sm font-black text-green-600 dark:text-green-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        {{ number_format($row->total_in ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-center bg-rose-50/10 dark:bg-rose-900/5">
                                    <div class="inline-flex items-center text-sm font-black text-rose-600 dark:text-rose-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        {{ number_format($row->total_out ?? 0, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="px-8 py-5 text-center bg-blue-50/10 dark:bg-blue-900/5">
                                    <span class="text-base font-black text-blue-800 dark:text-blue-300">
                                        {{ number_format($row->current_stock, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
    <a href="{{ url('/inventory/reports/stock-card') }}?medicine_id={{ $row->id }}&start_date={{ $startDate }}&end_date={{ $endDate }}" 
       class="inline-flex p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-xl transition-all"
       title="Lihat Kartu Stok">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </a>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold">Tidak Ada Mutasi</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Belum ada pergerakan stok (Masuk/Keluar) pada periode ini.</p>
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