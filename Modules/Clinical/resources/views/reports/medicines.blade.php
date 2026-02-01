<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Laporan Pemakaian Obat') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
                <form method="GET" action="{{ route('clinical.reports.medicines') }}" class="flex flex-col md:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-lg border-slate-300 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" name="action" value="filter" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-700">
                            Tampilkan
                        </button>
                        <button type="submit" name="action" value="pdf" formtarget="_blank" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-4 border-b bg-slate-50">
                    <span class="font-bold text-slate-700">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                </div>

                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-10 text-center">No</th>
                            <th class="px-6 py-3">Kode Obat</th>
                            <th class="px-6 py-3">Nama Obat</th>
                            <th class="px-6 py-3 text-center">Satuan</th>
                            <th class="px-6 py-3 text-center">Total Terpakai</th>
                            <th class="px-6 py-3 text-center">Sisa Stok (Gudang)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $index => $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-slate-600">
                                {{ $row->medicine->code ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">
                                {{ $row->medicine->name ?? 'Obat Dihapus' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $row->medicine->unit ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full font-bold">
                                    {{ $row->total_qty }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-slate-500">
                                {{ $row->medicine->current_stock ?? 0 }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">Tidak ada transaksi obat keluar pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>