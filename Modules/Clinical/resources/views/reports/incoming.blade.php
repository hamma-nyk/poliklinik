<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan Obat Masuk') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Rekapitulasi pengadaan dan restock logistik medis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Restock</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('clinical.reports.incoming') }}" class="flex flex-col md:flex-row gap-6 items-end">
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
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Results --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-bold text-slate-700 dark:text-slate-200">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Restock Terkumpul</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
    <tr class="bg-slate-50/30 dark:bg-slate-900/20">
        {{-- No - Cukup kecil --}}
        <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-16">
            No
        </th>

        {{-- Tanggal & Supplier --}}
        <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">
            Tanggal & Supplier
        </th>

        {{-- Nomor Faktur / Invoice --}}
        <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-48">
            Nomor Faktur
        </th>

        {{-- Volume Masuk --}}
        <th class="px-6 py-4 text-center text-[11px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter bg-indigo-50/30 dark:bg-indigo-900/10 w-32">
            Volume Masuk
        </th>

        {{-- Harga Beli Satuan --}}
        <th class="px-8 py-4 text-right text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter w-48">
            Harga Beli (@)
        </th>
    </tr>
</thead>
                        <tbody class="bg-white dark:bg-slate-800">
    @php 
        $grandTotalInvestasi = 0; 
    @endphp

    @forelse($data as $medicineId => $group)
        @php
            $medicine = $group->first()->medicine;
            $subtotalQty = $group->sum('quantity');
            $subtotalAmount = $group->sum(function($i) { return $i->quantity * $i->price_at_moment; });
            $grandTotalInvestasi += $subtotalAmount;
        @endphp

        {{-- HEADER GRUP OBAT --}}
        <tr class="bg-slate-50/50 dark:bg-slate-900/40 border-t-2 border-slate-100 dark:border-slate-700">
            <td colspan="3" class="px-8 py-3 border-l-4 border-indigo-500">
                <div class="flex flex-col">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Master Barang</span>
                    <span class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase">
                        {{ $medicine->name ?? 'Obat Dihapus' }} 
                        <span class="text-indigo-500 ml-2">[{{ $medicine->code ?? 'N/A' }}]</span>
                    </span>
                </div>
            </td>
            <td class="px-6 py-3 text-center bg-indigo-50/30 dark:bg-indigo-900/20">
                <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase block">Total Volume</span>
                <span class="text-sm font-black text-indigo-700 dark:text-indigo-300">
                    {{ number_format($subtotalQty, 0, ',', '.') }} {{ $medicine->unit }}
                </span>
            </td>
            <td class="px-8 py-3 text-right bg-indigo-50/50 dark:bg-indigo-900/30">
                <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase block">Subtotal Investasi</span>
                <span class="text-sm font-black text-indigo-700 dark:text-indigo-300">
                    Rp {{ number_format($subtotalAmount, 0, ',', '.') }}
                </span>
            </td>
        </tr>

        {{-- DETAIL TRANSAKSI MASUK --}}
        @foreach($group as $row)
            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group border-b border-slate-100 dark:border-slate-700">
                <td class="px-8 py-4 text-center text-xs font-medium text-slate-400 italic">
                    {{ $loop->iteration }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">
                        {{ $row->transaction->transaction_date->format('d M Y') }}
                    </div>
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-200 uppercase">
                        {{ $row->transaction->supplier->name ?? 'Tanpa Supplier' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">No. Faktur</div>
                    <div class="text-xs font-medium text-slate-600 dark:text-slate-400">
                        {{ $row->transaction->invoice_number ?? '-' }}
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-300">
                        {{ number_format($row->quantity, 0, ',', '.') }}
                    </div>
                    <div class="text-[9px] text-slate-400 uppercase tracking-widest">{{ $medicine->unit }}</div>
                </td>
                <td class="px-8 py-4 text-right">
                    <div class="text-[9px] text-slate-400 font-bold uppercase mb-1">Price @</div>
                    <div class="text-xs font-bold text-slate-700 dark:text-slate-200">
                        Rp {{ number_format($row->price_at_moment, 2, ',', '.') }}
                    </div>
                </td>
            </tr>
        @endforeach

    @empty
        <tr>
            <td colspan="5" class="px-6 py-20 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-full mb-4 text-slate-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 5-8-5"></path></svg>
                    </div>
                    <h3 class="text-slate-500 font-bold uppercase text-xs tracking-widest">Data Tidak Ditemukan</h3>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

{{-- GRAND TOTAL FOOTER --}}
@if($data->isNotEmpty())
    <tfoot class="bg-slate-800 dark:bg-indigo-600 text-white">
        <tr>
            <td colspan="4" class="px-8 py-5 text-right text-xs font-black uppercase tracking-[0.3em]">
                Total Nilai Investasi Pengadaan Seluruhnya
            </td>
            <td class="px-8 py-5 text-right">
                <div class="text-[10px] font-bold text-indigo-200 uppercase mb-1 tracking-widest">Grand Total</div>
                <div class="text-2xl font-black italic">
                    <span class="text-sm mr-1">Rp</span>{{ number_format($grandTotalInvestasi, 0, ',', '.') }}
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