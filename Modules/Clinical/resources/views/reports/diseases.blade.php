<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan 10 Besar Penyakit') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Analisis pola penyakit (Morbiditas) berdasarkan diagnosa ICD-10</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Morbiditas</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('clinical.reports.diseases') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" name="action" value="filter" 
                            class="flex-1 md:flex-none bg-slate-800 dark:bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-700 dark:hover:bg-blue-700 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
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

            {{-- Result Card --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="font-bold text-slate-700 dark:text-slate-200 uppercase text-xs tracking-wider">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="inline-flex items-center px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-xl font-black text-xs border border-blue-100 dark:border-blue-800/50">
                        TOTAL SELURUH KASUS: {{ number_format($grandTotal, 0, ',', '.') }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-900/20 text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                <th class="px-8 py-4 text-center w-20">Rank</th>
                                <th class="px-6 py-4 text-left">Kode & Nama Diagnosa</th>
                                <th class="px-6 py-4 text-center">Jumlah Kasus</th>
                                <th class="px-8 py-4 text-left w-64">Distribusi Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($data as $index => $row)
                                @php
                                    $percent = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0;
                                    // Warna progress bar dinamis berdasarkan rank
                                    $barColor = $index < 3 ? 'bg-blue-600' : 'bg-slate-400 dark:bg-slate-500';
                                @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors">
                                <td class="px-8 py-6 text-center">
                                    <span class="text-lg font-black {{ $index < 3 ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400' }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center">
                                        <div class="font-mono text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-lg mr-3 border border-slate-200 dark:border-slate-600 uppercase">
                                            {{ $row->diagnosis->code ?? '-' }}
                                        </div>
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 transition-colors">
                                            {{ $row->diagnosis->name ?? 'Diagnosa Dihapus' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <div class="text-xl font-black text-slate-800 dark:text-slate-100">{{ number_format($row->total, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Pasien</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-[11px] font-black text-slate-600 dark:text-slate-400">{{ number_format($percent, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full shadow-sm" style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold">Data Tidak Ditemukan</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Belum ada diagnosa yang tercatat pada rentang tanggal tersebut.</p>
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