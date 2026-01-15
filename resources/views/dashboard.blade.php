<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center transition hover:shadow-md hover:-translate-y-1">
                    <div class="p-3 bg-blue-100 rounded-xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Dokter</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalDoctors }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center transition hover:shadow-md hover:-translate-y-1">
                    <div class="p-3 bg-emerald-100 rounded-xl text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Jenis Obat</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalMedicines }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center transition hover:shadow-md hover:-translate-y-1">
                    <div class="p-3 bg-purple-100 rounded-xl text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Rekam Medis</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalMedicalRecords }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center transition hover:shadow-md hover:-translate-y-1">
                    <div class="p-3 bg-orange-100 rounded-xl text-orange-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Aktivitas Hari Ini</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $transactionsToday }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 lg:col-span-1 flex flex-col">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-red-50 rounded-t-2xl">
                        <h3 class="font-bold text-red-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Stok Obat Menipis
                        </h3>
                        <a href="{{ route('inventory.medicines.index') }}" class="text-xs text-red-600 underline hover:text-red-800">Lihat Semua</a>
                    </div>
                    <div class="p-0 flex-1 overflow-y-auto max-h-80">
                        @forelse($lowStockMedicines as $med)
                        <div class="p-4 border-b border-slate-50 flex justify-between items-center hover:bg-slate-50">
                            <div>
                                <p class="font-bold text-slate-800">{{ $med->name }}</p>
                                <p class="text-xs text-slate-500">{{ $med->code }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-700">
                                Sisa: {{ $med->current_stock }}
                            </span>
                        </div>
                        @empty
                        <div class="p-6 text-center text-slate-400 text-sm">
                            <p>Aman! Tidak ada stok kritis.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 lg:col-span-2">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Riwayat Transaksi Terakhir</h3>
                        <a href="{{ route('inventory.transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua -></a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                                <tr>
                                    <th class="p-4 font-semibold">Tanggal</th>
                                    <th class="p-4 font-semibold">Kode</th>
                                    <th class="p-4 font-semibold">Tipe</th>
                                    <th class="p-4 font-semibold">Item</th>
                                    <th class="p-4 font-semibold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($latestTransactions as $trx)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-sm font-bold text-slate-800">
                                        {{ $trx->code }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        @if($trx->type == 'in')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                MASUK
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                KELUAR
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-slate-600">
                                        {{ $trx->items->count() }} Jenis Obat
                                    </td>
                                    <td class="p-4 text-right">
                                        <span class="text-xs font-bold text-green-600">Selesai</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>