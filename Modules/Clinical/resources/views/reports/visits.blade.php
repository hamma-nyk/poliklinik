<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan Kunjungan Pasien') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Monitoring volume dan riwayat pelayanan klinis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Kunjungan</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('clinical.reports.visits') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 text-sm transition-all shadow-sm">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 text-sm transition-all shadow-sm">
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

            {{-- Results Table --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-bold text-slate-700 dark:text-slate-200">
                            Total Kunjungan: {{ number_format($data->count(), 0, ',', '.') }} Pasien
                        </span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest italic">Data terverifikasi sistem</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-900/20">
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Waktu Kunjungan</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Identitas Pasien</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Status</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Diagnosa Klinis</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Dokter</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Perawat</th>
                                <th class="px-6 py-4 text-left bg-slate-50/50 dark:bg-slate-700/30">Terapi Obat (Item & Qty)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($data as $row)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                    <div class="font-bold text-slate-800 dark:text-slate-100">{{ $row->created_at->format('d/m/Y') }}</div>
                                    <div class="text-[11px] text-slate-400 dark:text-slate-500 font-medium tracking-tight">{{ $row->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $row->patient->name }}</div>
                                    @if($row->jenis_kunjungan == 'Poli Umum')
                                    <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-0.5 tracking-tighter"><a href="{{ route('clinical.records.index') }}?search={{ $row->code }}" class="hover:text-amber-600 transition-colors">RM: {{ $row->code }}</a></div>
                                    @else
                                    <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-0.5 tracking-tighter"><a href="{{ route('clinical.lab.index') }}?search={{ $row->code }}" class="hover:text-amber-600 transition-colors">LAB: {{ $row->code }}</a></div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-tighter border {{ $row->patient->type == 'karyawan' ? 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800/50' : 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' }}">
                                        {{ $row->patient->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @if($row->jenis_kunjungan == 'Poli Umum')
                                        <div class="text-sm text-slate-700 dark:text-slate-300 line-clamp-1 max-w-xs font-medium" title="{{ $row->diagnosis->name ?? $row->diagnosa }}">
                                            {{ $row->diagnosis->name ?? $row->diagnosa }}
                                        </div>
                                        @if($row->diagnosis)
                                        <div class="text-[10px] font-mono text-slate-400 dark:text-slate-500 uppercase">{{ $row->diagnosis->code }}</div>
                                        @endif
                                    @else
                                        <span style="font-size: 9px;">
                                            @if($row->gula_darah) GDS:{{$row->gula_darah}} - @endif
                                            @if($row->kolesterol) Chol:{{$row->kolesterol}} - @endif
                                            @if($row->asam_urat) UA:{{$row->asam_urat}} @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $row->doctor->name ?? '-';
                                        @endphp

                                        @if($row->doctor == null)
                                            <span class="text-sm text-slate-400 dark:text-slate-500 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-xl bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-700 flex items-center justify-center text-xs font-black mr-3 shadow-sm">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900 dark:text-slate-200">{{ $name }}</div>
                                            <div class="text-[10px] text-blue-500 uppercase tracking-widest font-bold">
                                                Dokter
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $row->nurse->nama ?? '-';
                                        @endphp

                                        @if($row->nurse == null)
                                            <span class="text-sm text-slate-400 dark:text-slate-500 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-xl bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 border border-pink-200 dark:border-pink-700 flex items-center justify-center text-xs font-black mr-3 shadow-sm">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900 dark:text-slate-200">{{ $name }}</div>
                                            <div class="text-[10px] text-pink-500 uppercase tracking-widest font-bold">
                                                Perawat
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                {{-- KOLOM DETAIL OBAT (RAPID VIEW) --}}
                                <td class="px-6 py-5 bg-slate-50/30 dark:bg-slate-800/30 min-w-[250px]">
                                    @if($row->medicineTransactions->isNotEmpty())
                                        <div class="space-y-1.5">
                                            @foreach($row->medicineTransactions as $trans)
                                                @foreach($trans->items as $item)
                                                <div class="flex items-start justify-between gap-4 text-[10px] border-b border-slate-100 dark:border-slate-700/50 pb-1 last:border-0 group-hover:border-indigo-200 transition-colors">
                                                    <div class="flex flex-col">
                                                        <span class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-tighter">{{ $item->medicine->name }}</span>
                                                        <span class="text-slate-400 dark:text-slate-500 italic">{{ number_format($item->quantity) }} {{ $item->medicine->unit }}</span>
                                                    </div>
                                                    <!-- <div class="text-right flex flex-col">
                                                        <span class="font-mono text-slate-400 dark:text-slate-500">@ {{ number_format($item->price_at_moment, 0, ',', '.') }}</span>
                                                        <span class="font-bold text-indigo-600 dark:text-indigo-400 leading-none">Rp{{ number_format($item->quantity * $item->price_at_moment, 0, ',', '.') }}</span>
                                                    </div> -->
                                                </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-400 dark:text-slate-600 italic flex items-center">
                                            <svg class="w-3 h-3 mr-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            Tanpa Terapi Obat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold">Data Tidak Ditemukan</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Ganti rentang tanggal untuk melihat data lainnya.</p>
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