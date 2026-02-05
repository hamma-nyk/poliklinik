<x-app-layout title="Kartu Stok Obat">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Kartu Stok Obat') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Log mutasi pergerakan item secara mendetail</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Stock Card</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <form method="GET" action="{{ route('inventory.reports.stock_card') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pilih Item Obat</label>
                        <div class="dark:select2-dark">
                            <select name="medicine_id" class="select2 w-full border-slate-200 dark:border-slate-600 rounded-xl" required>
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
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" 
                            class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm transition-all focus:border-blue-500">
                    </div>

                    <div class="flex gap-2 items-end">
                        <div class="w-full space-y-1.5">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 text-sm transition-all focus:border-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white p-2.5 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-95 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            @if(request('medicine_id') && $selectedMedicine)
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                
                {{-- Detail Header --}}
                <div class="p-8 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 tracking-tight">{{ $selectedMedicine->name }}</h3>
                            <div class="flex gap-3 text-[11px] font-bold uppercase tracking-widest mt-1">
                                <span class="text-slate-400">KODE: <span class="text-blue-600 dark:text-blue-400 font-mono">{{ $selectedMedicine->code }}</span></span>
                                <span class="text-slate-300">|</span>
                                <span class="text-slate-400">SATUAN: {{ $selectedMedicine->unit }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-900 px-6 py-3 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm text-center md:text-right">
                        <span class="block text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Stok Saat Ini</span>
                        <span class="text-3xl font-black text-blue-600 dark:text-blue-400 tabular-nums">{{ $selectedMedicine->current_stock }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-100/50 dark:bg-slate-900/30 text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                <th class="px-8 py-4">Waktu & Tanggal</th>
                                <th class="px-6 py-4 text-left">Deskripsi Transaksi</th>
                                <th class="px-6 py-4 text-center bg-emerald-50/50 dark:bg-emerald-900/10 text-emerald-600 dark:text-emerald-400">Masuk</th>
                                <th class="px-6 py-4 text-center bg-rose-50/50 dark:bg-rose-900/10 text-rose-600 dark:text-rose-400">Keluar</th>
                                <th class="px-8 py-4 text-center bg-blue-50 dark:bg-blue-900/10 text-blue-600 dark:text-blue-400">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            
                            {{-- Baris Stok Awal --}}
                            <tr class="bg-slate-50/80 dark:bg-slate-900/50 font-black">
                                <td class="px-8 py-4 text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-widest" colspan="2">
                                    Stok Awal Per {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-300 dark:text-slate-700">-</td>
                                <td class="px-6 py-4 text-center text-slate-300 dark:text-slate-700">-</td>
                                <td class="px-8 py-4 text-center text-slate-800 dark:text-slate-200 text-base">{{ $openingStock }}</td>
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
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($item->transaction->transaction_date)->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">{{ \Carbon\Carbon::parse($item->transaction->created_at)->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="font-medium text-sm text-slate-700 dark:text-slate-200 tracking-tight">
                                            @if($item->transaction->medical_record_id)
                                                <span class="text-blue-600 dark:text-blue-400">Resep Pasien</span>
                                            @elseif($item->transaction->notes && str_contains(strtolower($item->transaction->notes), 'pembelian'))
                                                <span class="text-emerald-600 dark:text-emerald-400">Restock Pembelian</span>
                                            @else
                                                {{ $item->transaction->type == 'in' 
                                                    ? 'STOK MASUK (Rp ' . number_format($item->price_at_moment, 0, ',', '.') . ')' 
                                                    : 'STOK KELUAR' 
                                                }}                                            
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 italic leading-tight">
                                            {{ $item->transaction->notes ?? 'Tanpa keterangan' }} 
<a href="{{ route('inventory.transactions.index') }}?search={{ $item->transaction->code }}" class="hover:text-amber-600 transition-colors">({{$item->transaction->code}})</a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($qtyIn > 0)
                                            <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">+{{ $qtyIn }}</span>
                                        @else
                                            <span class="text-slate-200 dark:text-slate-700">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($qtyOut > 0)
                                            <span class="text-sm font-black text-rose-600 dark:text-rose-400">-{{ $qtyOut }}</span>
                                        @else
                                            <span class="text-slate-200 dark:text-slate-700">-</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-center bg-blue-50/30 dark:bg-blue-900/10">
                                        <span class="text-sm font-black text-slate-800 dark:text-slate-100 tabular-nums">{{ $currentBalance }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600 italic">
                                        Tidak ada aktivitas transaksi pada rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- Footer Summary --}}
                            <!-- <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-t-2 border-slate-100 dark:border-slate-700">
                                <td colspan="2" class="px-8 py-5 text-right text-[11px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Pergerakan</td>
                                <td class="px-6 py-5 text-center font-black text-emerald-600 dark:text-emerald-400">+{{ $totalIn }}</td>
                                <td class="px-6 py-5 text-center font-black text-rose-600 dark:text-rose-400">-{{ $totalOut }}</td>
                                <td class="px-8 py-5 text-center font-black text-blue-600 dark:text-blue-400 text-lg">{{ $currentBalance }}</td>
                            </tr> -->
                            <tr class="bg-slate-100 font-bold border-t-2 border-slate-200">
                                <td colspan="2" class="px-6 py-3 text-right">
                                    TOTAL QTY <br>
                                    <span class="text-xs font-normal text-slate-500">Total Nilai Masuk: Rp {{ number_format($totalValueIn, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="text-emerald-600 font-black text-lg">{{ number_format($totalIn) }}</div>
                                </td>
                                <td class="px-6 py-3 font-black text-lg text-center text-rose-600">{{ number_format($totalOut) }}</td>
                                <td class="px-6 py-3 font-black text-lg text-center text-blue-800">{{ number_format($currentBalance) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            @else
                {{-- State Belum Pilih --}}
                <div class="flex flex-col items-center justify-center p-20 bg-white dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-[2rem] text-slate-400 transition-all">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-500 dark:text-slate-400 uppercase tracking-tighter">Siap Meninjau Stok?</h3>
                    <p class="text-sm mt-2 max-w-xs text-center leading-relaxed">Pilih item obat dan tentukan periode tanggal pada filter di atas untuk melihat detail arus kas barang.</p>
                </div>
            @endif

        </div>
    </div>

    

    {{-- Script Select2 --}}
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        /* Custom Select2 Styling for Dark Mode & Modern Look */
        .select2-container--default .select2-selection--single {
            border-radius: 0.75rem;
            height: 42px;
            padding-top: 6px;
            border-color: #e2e8f0;
        }
        .dark .select2-container--default .select2-selection--single {
            background-color: #334155;
            border-color: #475569;
            color: white;
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #f1f5f9;
        }
        .dark .select2-dropdown {
            background-color: #1e293b;
            border-color: #475569;
            color: white;
        }
        .dark .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Cari nama atau kode obat...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>