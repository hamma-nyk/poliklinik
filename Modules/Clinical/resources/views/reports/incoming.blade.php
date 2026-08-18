<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Laporan Obat Masuk') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Rekapitulasi pengadaan dan restock logistik medis</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Restock</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                <form method="GET" action="{{ route('clinical.reports.incoming') }}" class="flex flex-col md:flex-row gap-6 items-end">
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
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-medium">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Data Restock Terkumpul</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
    <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
        {{-- No - Cukup kecil --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-16">
            No
        </th>

        {{-- Tanggal & Supplier --}}
        <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">
            Tanggal & Supplier
        </th>

        {{-- Nomor Faktur / Invoice --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-48">
            Nomor Faktur
        </th>

        {{-- Volume Masuk --}}
        <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-32">
            Volume Masuk
        </th>

        {{-- Harga Beli Satuan --}}
        <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400 w-48">
            Harga Beli (@)
        </th>
    </tr>
</thead>
                        <tbody class="[&_tr:last-child]:border-0">
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
        <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 bg-neutral-50/50 dark:bg-neutral-800/40">
            <td colspan="3" class="p-4 align-middle">
                <div class="flex flex-col">
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Master Barang</span>
                    <span class="font-medium text-neutral-900 dark:text-neutral-100">
                        {{ $medicine->name ?? 'Obat Dihapus' }} 
                        <span class="text-neutral-500 ml-2">[{{ $medicine->code ?? 'N/A' }}]</span>
                    </span>
                </div>
            </td>
            <td class="p-4 align-middle text-center">
                <span class="text-xs text-neutral-500 dark:text-neutral-400 block">Total Volume</span>
                <span class="font-medium text-neutral-900 dark:text-neutral-100">
                    {{ number_format($subtotalQty, 0, ',', '.') }} {{ $medicine->unit }}
                </span>
            </td>
            <td class="p-4 align-middle text-right">
                <span class="text-xs text-neutral-500 dark:text-neutral-400 block">Subtotal Investasi</span>
                <span class="font-medium text-neutral-900 dark:text-neutral-100">
                    Rp {{ number_format($subtotalAmount, 0, ',', '.') }}
                </span>
            </td>
        </tr>

        {{-- DETAIL TRANSAKSI MASUK --}}
        @foreach($group as $row)
            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                <td class="p-4 align-middle text-center text-neutral-500 dark:text-neutral-400">
                    {{ $loop->iteration }}
                </td>
                <td class="p-4 align-middle">
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                        {{ $row->transaction->transaction_date->format('d M Y') }}
                    </div>
                    <div class="font-medium">
                        {{ $row->transaction->supplier->name ?? 'Tanpa Supplier' }}
                    </div>
                </td>
                <td class="p-4 align-middle text-center">
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">No. Faktur</div>
                    <div class="font-medium">
                        {{ $row->transaction->invoice_number ?? '-' }}
                    </div>
                </td>
                <td class="p-4 align-middle text-center">
                    <div class="font-medium">
                        {{ number_format($row->quantity, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $medicine->unit }}</div>
                </td>
                <td class="p-4 align-middle text-right">
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Price @</div>
                    <div class="font-medium">
                        Rp {{ number_format($row->price_at_moment, 2, ',', '.') }}
                    </div>
                </td>
            </tr>
        @endforeach

    @empty
        <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
            <td colspan="5" class="p-4 align-middle text-center text-neutral-500 dark:text-neutral-400 py-10">
                Data Tidak Ditemukan
            </td>
        </tr>
    @endforelse
</tbody>

{{-- GRAND TOTAL FOOTER --}}
@if($data->isNotEmpty())
    <tfoot class="border-t border-neutral-200 dark:border-neutral-600 font-medium">
        <tr class="bg-neutral-50 dark:bg-neutral-800">
            <td colspan="4" class="p-4 align-middle text-right text-xs text-neutral-500 dark:text-neutral-400 uppercase">
                Total Nilai Investasi Pengadaan Seluruhnya
            </td>
            <td class="p-4 align-middle text-right">
                <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Grand Total</div>
                <div class="font-medium text-neutral-900 dark:text-neutral-50 text-base">
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