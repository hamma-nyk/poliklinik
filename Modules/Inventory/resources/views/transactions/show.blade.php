<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Detail Transaksi') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">ID Transaksi: <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $transaction->code }}</span></p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Detail</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Tombol Kembali & Print (Optional) --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('inventory.transactions.index') }}" class="inline-flex items-center text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
                <!-- <button onclick="window.print()" class="hidden md:inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm print:hidden">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Dokumen
                </button> -->
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                {{-- Header Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 border-b border-slate-100 dark:border-slate-700 pb-8">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tanggal Transaksi</p>
                        <p class="font-bold text-lg text-slate-800 dark:text-slate-100">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d F Y') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tipe Mutasi</p>
                        <div class="flex items-center">
                            @if($transaction->type == 'in')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800/30 uppercase">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span> Stok Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 border border-orange-200 dark:border-orange-800/30 uppercase">
                                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-2"></span> Stok Keluar
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Catatan / No. Ref</p>
                        <p class="text-slate-700 dark:text-slate-300 font-medium">{{ $transaction->notes ?? '-' }}</p>
                    </div>
                </div>

                {{-- Table Items --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center">
                        <span class="w-1.5 h-6 bg-indigo-500 rounded-full mr-3"></span>
                        Rincian Item Obat
                    </h3>
                    
                    <div class="overflow-hidden border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Obat</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jumlah (Qty)</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                @php $grandTotal = 0; @endphp
                                @foreach($transaction->items as $item)
                                @php 
                                    $subtotal = $item->quantity * $item->price_at_moment; 
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                            {{ $item->medicine->name ?? 'Item Dihapus' }}
                                        </div>
                                        <div class="text-xs font-mono text-slate-400 dark:text-slate-500 mt-1 uppercase">
                                            {{ $item->medicine->code ?? 'N/A' }}
                                            @if($item->medicine && $item->medicine->trashed())
                                                <span class="ml-2 text-red-500 font-bold italic">(Dihapus dari Master)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-sm font-black text-slate-700 dark:text-slate-200">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-slate-600 dark:text-slate-400 font-medium">
                                        Rp {{ $item->price_at_moment == floor($item->price_at_moment) 
                                            ? number_format($item->price_at_moment, 0, ',', '.') 
                                            : number_format($item->price_at_moment, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-slate-800 dark:text-slate-100">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50 dark:bg-slate-700/50 font-black">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right text-slate-500 dark:text-slate-400 uppercase text-xs tracking-widest">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-right text-lg text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Referensi Rekam Medis --}}
                <div class="mt-10 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase mb-4 block tracking-widest">Sumber / Referensi Transaksi</span>
                    
                    @if($transaction->medical_record_id && $transaction->medicalRecord)
                        <div class="flex items-start">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase text-[10px]">Tautan Rekam Medis</p>
                                <a href="{{ route('clinical.records.index') }}?search={{ $transaction->medicalRecord->code }}" class="text-md font-bold text-blue-600 dark:text-blue-400 hover:underline inline-block">
                                    {{ $transaction->medicalRecord->code }} — {{ $transaction->medicalRecord->patient->name }}
                                </a>
                                <div class="text-xs text-slate-500 dark:text-slate-400 italic">
                                    Diagnosa & Resep oleh: <span class="font-bold">{{ $transaction->medicalRecord->doctor->name ?? $transaction->medicalRecord->nurse->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center text-slate-500 dark:text-slate-400 italic text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Transaksi diinput secara manual (Logistik Inventaris)
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>