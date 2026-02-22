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
                        <a href="{{ route('clinical.reports.index') }}" 
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-2.5 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-[11px] font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-600 transition-all shadow-sm active:scale-95 uppercase tracking-widest group">
                            <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
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
        {{-- No kecil saja --}}
        <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-16">
            No
        </th>
        
        {{-- Tanggal Transaksi --}}
        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-32">
            Tanggal
        </th>
        
        {{-- Referensi (Pasien/Catatan) dibuat lebar --}}
        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">
            Referensi / Pasien / Keterangan
        </th>
        
        {{-- Status/Jenis Pasien --}}
        <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-32">
            Jenis Pasien
        </th>
        
        {{-- Qty Keluar --}}
        <th class="px-6 py-4 text-center text-[11px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-tighter bg-rose-50/30 dark:bg-rose-900/10 w-36">
            Qty Keluar
        </th>
    </tr>
</thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
    @php $grandTotalQty = 0; @endphp

    @forelse($data as $medicineId => $items)
        @php
            // Ambil info obat dari item pertama dalam grup
            $medicine = $items->first()->medicine;
            $subtotalQtyPerMedicine = $items->sum('quantity');
            $grandTotalQty += $subtotalQtyPerMedicine;
        @endphp

        {{-- BARIS HEADER PER OBAT --}}
        <tr class="bg-slate-50/50 dark:bg-slate-900/40">
            <td colspan="4" class="px-6 py-3 border-l-4 bg-slate-200 dark:bg-rose-900/10 border-rose-600 dark:border-rose-500">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase">
                            {{ $medicine->name ?? 'Obat Dihapus' }}
                        </span>
                        <span class="text-[10px] text-slate-400 ml-2">({{ $medicine->code ?? '-' }})</span>
                    </div>
                    <div class="text-xs font-bold text-rose-600 dark:text-rose-400">
                        Total Keluar: {{ number_format($subtotalQtyPerMedicine, 0, ',', '.') }} {{ $medicine->unit }}
                    </div>
                </div>
            </td>
            <td class="px-6 py-3 text-center bg-slate-200 dark:bg-rose-900/10">
                {{-- Kosongkan atau isi sisa stok --}}
                <span class="text-[10px] font-bold text-slate-400">STOK SAAT INI: {{ $medicine->current_stock }}</span>
            </td>
        </tr>

        {{-- LOOP DETAIL TRANSAKSI UNTUK OBAT INI --}}
        @foreach($items as $index => $row)
            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                <td class="px-6 py-4 text-center text-xs text-slate-400">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">
                    <div class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">
                        {{ $row->transaction->transaction_date->format('d M Y') }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($row->transaction->medicalRecord)
                        <div class="text-xs font-bold text-slate-700 dark:text-slate-200">
                            {{ $row->transaction->medicalRecord->patient->name }}
                        </div>
                        <div class="text-[9px] text-slate-400 italic">Resep: {{ $row->transaction->medicalRecord->code }}</div>
                    @else
                        <div class="text-xs text-slate-600 italic">{{ $row->transaction->notes ?? 'Adjustment' }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($row->transaction->medicalRecord?->patient)
                     <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase {{ $row->transaction->medicalRecord?->patient->type == 'karyawan' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $row->transaction->medicalRecord?->patient->type ?? 'UMUM' }}
                    </span>
                    @else
                        <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase bg-green-100 text-green-700">
                            ADJ/LAIN
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-200 text-sm">
                    {{ number_format($row->quantity, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach

    @empty
        <tr>
            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic">Data tidak ditemukan.</td>
        </tr>
    @endforelse
</tbody>

        {{-- FOOTER GRAND TOTAL --}}
@if($data->isNotEmpty())
    <tfoot class="bg-slate-200 dark:bg-slate-800 text-white">
        <tr>
            <td colspan="4" class="px-8 py-4 text-right text-xs text-slate-400  dark:text-slate-300 font-black uppercase tracking-widest">Grand Total Seluruh Obat Keluar</td>
            <td class="px-6 py-4 text-center text-lg font-black text-rose-400">
                {{ number_format($grandTotalQty, 0, ',', '.') }}
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