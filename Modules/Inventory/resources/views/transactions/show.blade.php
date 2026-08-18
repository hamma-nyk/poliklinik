<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">
                    {{ __('Detail Transaksi') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">ID Transaksi: <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $transaction->code }}</span></p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('inventory.transactions.index') }}">Transaksi</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Detail</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            
            {{-- Tombol Kembali & Print --}}
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 pb-4">
    
    {{-- Tombol Kembali: Boxed Style --}}
    <a href="{{ route('inventory.transactions.index') }}" 
       class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 w-full sm:w-auto uppercase tracking-widest group">
        <svg class="w-4 h-4 mr-2.5 transition-transform duration-300 group-hover:-translate-x-1" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar
    </a>

    {{-- Tombol Cetak: Boxed Style --}}
    <button onclick="window.print()" 
            class="hidden md:inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 print:hidden uppercase tracking-widest group/print">
        <svg class="w-4 h-4 mr-2.5 text-neutral-400 group-hover/print:text-emerald-500 transition-colors" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Cetak Dokumen
    </button>
</div>

            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-8">
                
                {{-- Header Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 pb-8 border-b border-neutral-200 dark:border-neutral-600">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Tanggal Transaksi</p>
                        <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d F Y') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Tipe Mutasi</p>
                        <div class="flex items-center">
                            @if($transaction->type == 'in')
                                <span class="inline-flex items-center rounded-md border border-transparent bg-emerald-500/10 text-emerald-500 px-2.5 py-0.5 text-xs font-semibold">
                                    Stok Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md border border-transparent bg-destructive/10 text-destructive px-2.5 py-0.5 text-xs font-semibold">
                                    Stok Keluar
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Catatan / No. Ref</p>
                        <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">{{ $transaction->notes ?? '-' }}</p>
                    </div>
                </div>

                {{-- Table Items --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                        <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                        Rincian Item Obat
                    </h3>
                    
                    <div class="overflow-hidden border border-neutral-200 dark:border-neutral-600 rounded-md">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b">
                                <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Nama Obat</th>
                                    <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Jumlah (Qty)</th>
                                    <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Harga Satuan</th>
                                    <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
                                @php $grandTotal = 0; @endphp
                                @foreach($transaction->items as $item)
                                @php 
                                    $subtotal = $item->quantity * $item->price_at_moment; 
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                    <td class="p-4 align-middle">
                                        <div class="font-medium text-neutral-800 dark:text-neutral-200">
                                            {{ $item->medicine->name ?? 'Item Dihapus' }}
                                        </div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 uppercase">
                                            {{ $item->medicine->code ?? 'N/A' }}
                                            @if($item->medicine && $item->medicine->trashed())
                                                <span class="ml-2 text-destructive font-medium italic">(Dihapus dari Master)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 align-middle text-center">
                                        <span class="inline-block px-3 py-1 bg-neutral-100 dark:bg-neutral-800 rounded-md text-sm font-medium text-neutral-700 dark:text-neutral-200">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="p-4 align-middle text-right text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                                        Rp {{ $item->price_at_moment == floor($item->price_at_moment) 
                                            ? number_format($item->price_at_moment, 0, ',', '.') 
                                            : number_format($item->price_at_moment, 2, ',', '.') }}
                                    </td>
                                    <td class="p-4 align-middle text-right text-sm font-medium text-neutral-800 dark:text-neutral-100">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-t border-neutral-200 dark:border-neutral-600 font-medium">
                                <tr>
                                    <td colspan="3" class="p-4 align-middle text-right text-neutral-500 dark:text-neutral-400">Total Keseluruhan</td>
                                    <td class="p-4 align-middle text-right text-lg">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Referensi Rekam Medis --}}
                <div class="mt-8 rounded-md border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-900 shadow-sm dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                    <span class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase mb-4 block tracking-wider">Sumber / Referensi Transaksi</span>
                    
                    @if($transaction->medical_record_id && $transaction->medicalRecord)
                        <div class="flex items-start">
                            <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-white text-neutral-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 mr-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Tautan Rekam Medis</p>
                                <a href="{{ route('clinical.records.index') }}?search={{ $transaction->medicalRecord->code }}" class="font-medium hover:underline inline-block">
                                    {{ $transaction->medicalRecord->code }} — {{ $transaction->medicalRecord->patient->name }}
                                </a>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Diagnosa & Resep oleh: <span class="font-medium">{{ $transaction->medicalRecord->doctor->name ?? $transaction->medicalRecord->nurse->nama }}</span>
                                </div>
                            </div>
                        </div>
                     @elseif($transaction->lab_check_id && $transaction->labCheck)
                        <div class="flex items-start">
                            <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-white text-neutral-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 mr-4">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Tautan Cek Lab</p>
                                <a href="{{ route('clinical.lab.index') }}?search={{ $transaction->labCheck->code }}" class="font-medium hover:underline inline-block">
                                    {{ $transaction->labCheck->code }} — {{ $transaction->labCheck->patient->name }}
                                </a>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Petugas: <span class="font-medium">{{ $transaction->labCheck->doctor->name ?? $transaction->labCheck->nurse->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center text-neutral-500 dark:text-neutral-400 text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Transaksi diinput secara manual (Logistik Inventaris)
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>