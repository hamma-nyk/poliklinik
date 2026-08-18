<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Laporan Pemakaian Obat') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Rekapitulasi pengeluaran resep dan penggunaan logistik medis</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Pemakaian</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                <form method="GET" action="{{ route('clinical.reports.medicines') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('clinical.reports.index') }}" 
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" name="action" value="filter" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                            Tampilkan
                        </button>
                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table Results --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-800/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-rose-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-medium text-xs">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Laporan Pengeluaran Stok</span>
                </div>

               <div class="overflow-x-auto">
    <table class="w-full caption-bottom text-sm">
        <thead class="[&_tr]:border-b">
    <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
        {{-- No kecil saja --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-16">
            No
        </th>
        
        {{-- Tanggal Transaksi --}}
        <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-32">
            Tanggal
        </th>
        
        {{-- Referensi (Pasien/Catatan) dibuat lebar --}}
        <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">
            Referensi / Pasien / Keterangan
        </th>
        
        {{-- Status/Jenis Pasien --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-32">
            Jenis Pasien
        </th>
        
        {{-- Qty Keluar --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-36">
            Qty Keluar
        </th>
    </tr>
</thead>
        <tbody class="[&_tr:last-child]:border-0">
    @php $grandTotalQty = 0; @endphp

    @forelse($data as $medicineId => $items)
        @php
            // Ambil info obat dari item pertama dalam grup
            $medicine = $items->first()->medicine;
            $subtotalQtyPerMedicine = $items->sum('quantity');
            $grandTotalQty += $subtotalQtyPerMedicine;
        @endphp

        {{-- BARIS HEADER PER OBAT --}}
        <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 bg-neutral-50/50 dark:bg-neutral-800/40">
            <td colspan="4" class="p-4 align-middle">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-sm font-medium text-neutral-800 dark:text-neutral-100 uppercase">
                            {{ $medicine->name ?? 'Obat Dihapus' }}
                        </span>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400 ml-2">({{ $medicine->code ?? '-' }})</span>
                    </div>
                    <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                        Total Keluar: {{ number_format($subtotalQtyPerMedicine, 0, ',', '.') }} {{ $medicine->unit }}
                    </div>
                </div>
            </td>
            <td class="p-4 align-middle text-center">
                {{-- Kosongkan atau isi sisa stok --}}
                <span class="text-xs text-neutral-500 dark:text-neutral-400">STOK SAAT INI: {{ $medicine->current_stock }}</span>
            </td>
        </tr>

        {{-- LOOP DETAIL TRANSAKSI UNTUK OBAT INI --}}
        @foreach($items as $index => $row)
            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                <td class="p-4 align-middle text-center text-xs text-neutral-500 dark:text-neutral-400">{{ $loop->iteration }}</td>
                <td class="p-4 align-middle">
                    <div class="text-xs font-medium text-neutral-700 dark:text-neutral-300">
                        {{ $row->transaction->transaction_date->format('d M Y') }}
                    </div>
                </td>
                <td class="p-4 align-middle">
                    @if($row->transaction->medicalRecord)
                        <div class="text-sm font-medium text-neutral-700 dark:text-neutral-200">
                            {{ $row->transaction->medicalRecord->patient->name }}
                        </div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400 italic">Resep: {{ $row->transaction->medicalRecord->code }}</div>
                    @else
                        <div class="text-sm text-neutral-600 dark:text-neutral-300 italic">{{ $row->transaction->notes ?? 'Adjustment' }}</div>
                    @endif
                </td>
                <td class="p-4 align-middle text-center">
                    @if($row->transaction->medicalRecord?->patient)
                     <span class="px-2 py-0.5 rounded text-xs font-medium uppercase border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                        {{ $row->transaction->medicalRecord?->patient->type ?? 'UMUM' }}
                    </span>
                    @else
                        <span class="px-2 py-0.5 rounded text-xs font-medium uppercase border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                            ADJ/LAIN
                        </span>
                    @endif
                </td>
                <td class="p-4 align-middle text-center font-medium text-neutral-700 dark:text-neutral-200 text-sm">
                    {{ number_format($row->quantity, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach

    @empty
        <tr>
            <td colspan="5" class="p-4 align-middle py-20 text-center text-neutral-500 dark:text-neutral-400 italic">Data tidak ditemukan.</td>
        </tr>
    @endforelse
</tbody>

        {{-- FOOTER GRAND TOTAL --}}
@if($data->isNotEmpty())
    <tfoot class="border-t border-neutral-200 dark:border-neutral-600">
        <tr class="bg-neutral-50 dark:bg-neutral-800">
            <td colspan="4" class="p-4 align-middle text-right text-xs text-neutral-500 dark:text-neutral-400 font-medium uppercase">Grand Total Seluruh Obat Keluar</td>
            <td class="p-4 align-middle text-center text-lg font-medium text-neutral-900 dark:text-neutral-50">
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