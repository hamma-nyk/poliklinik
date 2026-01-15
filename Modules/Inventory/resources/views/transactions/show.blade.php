<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi: {{ $transaction->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-2 gap-4 mb-6 border-b pb-4">
                    
                    <div>
                        <p class="text-sm text-gray-500">Tanggal</p>
                        <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tipe</p>
                        <p class="font-bold text-lg uppercase {{ $transaction->type == 'in' ? 'text-blue-600' : 'text-orange-600' }}">
                            {{ $transaction->type == 'in' ? 'Stok Masuk' : 'Stok Keluar' }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="text-gray-800">{{ $transaction->notes ?? '-' }}</p>
                    </div>
                </div>

                <h3 class="font-bold text-gray-700 mb-2">Item Obat</h3>
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga @ (Saat Transaksi)</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $grandTotal = 0; @endphp
                        @foreach($transaction->items as $item)
                        @php 
                            $subtotal = $item->quantity * $item->price_at_moment; 
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $item->medicine->name ?? 'Item Dihapus/Tidak Ditemukan' }}
                                @if($item->medicine && $item->medicine->trashed())
                                    <span class="text-red-500 text-xs">(Sudah Dihapus)</span>
                                @endif</td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-center font-bold">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right">Rp {{ number_format($item->price_at_moment, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-100 font-bold">
                            <td colspan="3" class="px-4 py-2 text-right">Total Transaksi</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
<div class="col-span-2 mt-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
            <span class="text-xs font-bold text-slate-500 uppercase mb-2 block">Sumber / Referensi</span>
            
            @if($transaction->medical_record_id && $transaction->medicalRecord)
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <div>
                        Rekam Medis Pasien: 
                        <a href="{{ route('clinical.records.index') }}?search={{ $transaction->medicalRecord->code }}" class="font-bold text-blue-700 hover:underline">
                            {{ $transaction->medicalRecord->code }} - {{ $transaction->medicalRecord->patient->name }}
                        </a>
                        <div class="text-xs text-slate-500 mt-1">
                            Dokter: {{ $transaction->medicalRecord->doctor->name }}
                        </div>
                    </div>
                </div>
            @else
                <p class="text-slate-500 italic">Transaksi manual (Bukan dari resep dokter)</p>
            @endif
        </div>
                <div class="mt-6">
                    <a href="{{ route('inventory.transactions.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>