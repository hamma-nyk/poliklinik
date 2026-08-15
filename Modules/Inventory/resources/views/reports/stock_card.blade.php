<x-app-layout title="Kartu Stok Obat">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-800 dark:text-slate-100">
                    {{ __('Kartu Stok Obat') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Log mutasi pergerakan item secara mendetail</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Stock Card</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="p-6 rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50">
                <form method="GET" action="{{ route('inventory.reports.stock_card') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Pilih Item Obat</label>
                        <div>
                            <select name="medicine_id" class="tom-select" required>
                                <option value="">-- Cari Nama atau Kode Obat --</option>
                                @foreach($medicines as $med)
                                    <option value="{{ $med->id }}" {{ request('medicine_id') == $med->id ? 'selected' : '' }}>
                                        {{ $med->code }} - {{ $med->name }} ({{ $med->unit }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" 
                            class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                    </div>

                    <div class="flex gap-2 items-end">
                        <div class="w-full space-y-1.5">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            @if(request('medicine_id') && $selectedMedicine)
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50">
                
                {{-- Detail Header --}}
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-md flex items-center justify-center mr-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold tracking-tight">{{ $selectedMedicine->name }}</h3>
                            <div class="flex gap-3 text-xs text-slate-500 dark:text-slate-400 mt-1">
                                <span>KODE: <span class="font-mono">{{ $selectedMedicine->code }}</span></span>
                                <span>|</span>
                                <span>SATUAN: {{ $selectedMedicine->unit }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-950 px-6 py-3 rounded-md border border-slate-200 dark:border-slate-800 shadow-sm text-center md:text-right">
                        <span class="block text-xs text-slate-500 dark:text-slate-400 font-bold uppercase mb-1">Stok Saat Ini</span>
                        <span class="text-2xl font-bold tabular-nums">{{ $selectedMedicine->current_stock }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Waktu & Tanggal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Deskripsi Transaksi</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 text-center">Masuk</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 text-center">Keluar</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            
                            {{-- Baris Stok Awal --}}
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50">
                                <td class="p-4 align-middle text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest font-medium" colspan="2">
                                    Stok Awal Per {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                </td>
                                <td class="p-4 align-middle text-center text-slate-300 dark:text-slate-700">-</td>
                                <td class="p-4 align-middle text-center text-slate-300 dark:text-slate-700">-</td>
                                <td class="p-4 align-middle text-center font-bold">{{ $openingStock }}</td>
                            </tr>

                            @php 
                                $currentBalance = $openingStock; 
                                $totalIn = 0; $totalOut = 0;
                            @endphp

                            @forelse($transactions as $item)
                                @php
                                    $isMasuk = $item->transaction->type == 'in';
                                    $qtyIn   = $isMasuk ? $item->quantity : 0;
                                    $qtyOut  = !$isMasuk ? $item->quantity : 0;
                                    
                                    if($isMasuk) { $currentBalance += $item->quantity; $totalIn += $item->quantity; } 
                                    else { $currentBalance -= $item->quantity; $totalOut += $item->quantity; }
                                @endphp
                                <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                    <td class="p-4 align-middle whitespace-nowrap">
                                        <div class="font-medium">{{ \Carbon\Carbon::parse($item->transaction->transaction_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($item->transaction->created_at)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="font-medium">
                                            @if($item->transaction->medical_record_id)
                                                <span>Resep Pasien</span>
                                            @elseif($item->transaction->notes && str_contains(strtolower($item->transaction->notes), 'pembelian'))
                                                <span>Restock Pembelian</span>
                                            @else
                                                {{ $item->transaction->type == 'in' 
                                                    ? 'STOK MASUK (Rp ' . number_format($item->price_at_moment, 0, ',', '.') . ')' 
                                                    : 'STOK KELUAR' 
                                                }}                                            
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 italic">
                                            {{ $item->transaction->notes ?? 'Tanpa keterangan' }} 
<a href="{{ route('inventory.transactions.index') }}?search={{ $item->transaction->code }}" class="hover:underline">({{$item->transaction->code}})</a>
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        @if($qtyIn > 0)
                                            <span class="font-medium text-emerald-600 dark:text-emerald-400">+{{ $qtyIn }}</span>
                                        @else
                                            <span class="text-slate-300 dark:text-slate-700">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        @if($qtyOut > 0)
                                            <span class="font-medium text-rose-600 dark:text-rose-400">-{{ $qtyOut }}</span>
                                        @else
                                            <span class="text-slate-300 dark:text-slate-700">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        <span class="font-medium tabular-nums">{{ $currentBalance }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                    <td colspan="5" class="p-4 align-middle text-center text-slate-500 dark:text-slate-400 italic">
                                        Tidak ada aktivitas transaksi pada rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- Footer Summary --}}
                            <!-- <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-t-2 border-slate-100 dark:border-slate-700">
                                <td colspan="2" class="px-8 py-5 text-right text-[11px] font-bold text-slate-500 uppercase tracking-[0.2em]">Total Pergerakan</td>
                                <td class="px-6 py-5 text-center font-bold text-emerald-600 dark:text-emerald-400">+{{ $totalIn }}</td>
                                <td class="px-6 py-5 text-center font-bold text-rose-600 dark:text-rose-400">-{{ $totalOut }}</td>
                                <td class="px-8 py-5 text-center font-bold text-blue-600 dark:text-blue-400 text-lg">{{ $currentBalance }}</td>
                            </tr> -->
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50">
                                <td colspan="2" class="p-4 align-middle text-right font-medium">
                                    TOTAL QTY <br>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-normal">Total Nilai Masuk: Rp {{ number_format($totalValueIn, 0, ',', '.') }}</span>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <div class="text-emerald-600 dark:text-emerald-400 font-medium">{{ number_format($totalIn) }}</div>
                                </td>
                                <td class="p-4 align-middle text-center font-medium text-rose-600 dark:text-rose-400">{{ number_format($totalOut) }}</td>
                                <td class="p-4 align-middle text-center font-bold">{{ number_format($currentBalance) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            @else
                {{-- State Belum Pilih --}}
                <div class="flex flex-col items-center justify-center p-20 border border-dashed border-slate-200 dark:border-slate-800 rounded-md text-slate-500 transition-all">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-md flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium tracking-tight">Siap Meninjau Stok?</h3>
                    <p class="text-sm mt-2 max-w-xs text-center leading-relaxed">Pilih item obat dan tentukan periode tanggal pada filter di atas untuk melihat detail arus kas barang.</p>
                </div>
            @endif

        </div>
    </div>

    

    {{-- Script Select2 --}}
    @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.tom-select').forEach((el) => {
            new TomSelect(el, {
                create: false,
                sortField: { field: "text", order: "asc" }
            });
        });
    });
</script>
<style>
    .select2-container { display: none !important; }
    .ts-wrapper.single .ts-control { 
        border-radius: 0.375rem !important; 
        padding: 0.25rem 0.75rem !important; 
        height: 36px !important;
        border-color: #e2e8f0 !important; 
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        font-size: 0.875rem !important;
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }
    .dark .ts-wrapper.single .ts-control { 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-wrapper.single .ts-control input {
        font-size: 0.875rem !important;
    }
    .dark .ts-wrapper.single .ts-control input {
        color: #f8fafc !important;
    }
    .ts-dropdown { 
        border-radius: 0.375rem !important;
        border-color: #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        font-size: 0.875rem !important;
        z-index: 50 !important;
    }
    .dark .ts-dropdown { 
        background-color: #020617 !important; 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-dropdown .option {
        padding: 8px 12px !important;
    }
    .ts-dropdown .active { 
        background-color: #f1f5f9 !important; 
        color: #0f172a !important; 
    }
    .dark .ts-dropdown .active { 
        background-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .dark .ts-dropdown .option { 
        color: #cbd5e1; 
    }
</style>
@endpush
</x-app-layout>