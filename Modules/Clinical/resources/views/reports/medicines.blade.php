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
                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-16">No</th>
                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Tanggal & Obat</th>
                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Referensi / Pasien</th>
                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Qty</th>
                <!-- <th class="px-6 py-4 text-right text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Harga (@)</th>
                <th class="px-6 py-4 text-right text-[11px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter bg-indigo-50/30 dark:bg-indigo-900/10">Subtotal</th> -->
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
            @php 
                $grandTotal = 0; 
                $totalqty = 0;
            @endphp
            @forelse($data as $index => $row)
                @php 
                    $subtotal = $row->quantity * $row->price_at_moment;
                    $totalqty += $row->quantity;
                    $grandTotal += $subtotal;
                @endphp
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                    {{-- NO --}}
                    <td class="px-6 py-5 text-center text-sm font-medium text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                    
                    {{-- INFO OBAT --}}
                    <td class="px-6 py-5">
                        <div class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">
                            {{ $row->transaction->transaction_date->format('d M Y') }}
                        </div>
                        <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $row->medicine->name ?? 'Obat Dihapus' }}</div>
                        <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">{{ $row->medicine->code ?? 'N/A' }}</div>
                    </td>

                    {{-- REFERENSI / PASIEN --}}
                    <td class="px-6 py-5">
                        @if($row->transaction->medicalRecord)
                            <div class="flex items-center">
                                <div class="p-1.5 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200 uppercase">{{ $row->transaction->medicalRecord->patient->name }}</div>
                                    <div class="text-[10px] text-slate-400 italic">Resep Rawat Jalan ({{ $row->transaction->medicalRecord->code }})</div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center">
                                <div class="p-1.5 bg-amber-50 dark:bg-amber-900/30 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $row->transaction->notes ?? 'Adjustment Stok' }}</div>
                                    <div class="text-[10px] text-amber-600 font-bold uppercase tracking-tighter">Non-Resep</div>
                                </div>
                            </div>
                        @endif
                    </td>

                    {{-- QTY --}}
                    <td class="px-6 py-5 text-center">
                        <div class="text-sm font-black text-slate-700 dark:text-slate-200">
                            {{ number_format($row->quantity, 0, ',', '.') }}
                        </div>
                        <!-- <div class="text-[10px] text-slate-400 uppercase font-bold">{{ $row->medicine->unit }}</div> -->
                    </td>

                    <!-- {{-- HARGA SATUAN --}}
                    <td class="px-6 py-5 text-right">
                        <div class="text-[10px] text-slate-400 mb-0.5">Price @</div>
                        <div class="text-sm font-bold text-slate-600 dark:text-slate-400">
                            {{ number_format($row->price_at_moment, 2, ',', '.') }}
                        </div>
                    </td>

                    {{-- SUBOTOTAL --}}
                    <td class="px-6 py-5 text-right bg-indigo-50/10 dark:bg-indigo-900/5">
                        <div class="text-sm font-black text-indigo-600 dark:text-indigo-400">
                            Rp {{ number_format($subtotal, 2, ',', '.') }}
                        </div>
                    </td> -->
                </tr>
            @empty
                {{-- Bagian Empty Tetap Sama --}}
            @endforelse
        </tbody>

        {{-- FOOTER UNTUK TOTAL KESELURUHAN --}}
        @if($data->isNotEmpty())
        <tfoot class="bg-slate-50 dark:bg-slate-900/50">
            <tr>
                <td colspan="3" class="px-6 py-4 text-right text-[11px] font-black text-slate-500 uppercase tracking-widest">Total Obat Keluar</td>
                <td class="px-6 py-5 text-center">
                    <div class="text-lg font-black text-indigo-600 dark:text-indigo-400">
                        <!-- Rp {{ number_format($grandTotal, 2, ',', '.') }} -->
                        {{ number_format($totalqty, 0, ',', '.') }}
                    </div>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
            </div>
        </div>
    </div>
</x-app-layout>