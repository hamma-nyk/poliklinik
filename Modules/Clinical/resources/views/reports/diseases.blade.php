<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Laporan 10 Besar Penyakit') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
                <form method="GET" action="{{ route('clinical.reports.diseases') }}" class="flex flex-col md:flex-row gap-4 items-end">
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
                <div class="p-4 border-b bg-slate-50 flex justify-between items-center">
                    <span class="font-bold text-slate-700">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                    <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full font-bold">Total Kasus: {{ $grandTotal }}</span>
                </div>

                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-10 text-center">Rank</th>
                            <th class="px-6 py-3">Kode ICD-10</th>
                            <th class="px-6 py-3">Nama Penyakit (Diagnosa)</th>
                            <th class="px-6 py-3 w-32 text-center">Jumlah</th>
                            <th class="px-6 py-3 w-48">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $index => $row)
                            @php
                                $percent = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0;
                            @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-center font-bold text-slate-500">
                                #{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-600">
                                {{ $row->diagnosis->code ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">
                                {{ $row->diagnosis->name ?? 'Diagnosa Dihapus' }}
                            </td>
                            <td class="px-6 py-4 text-center text-lg font-bold text-blue-700">
                                {{ $row->total }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="text-xs font-bold w-12 text-right mr-2">{{ number_format($percent, 1) }}%</span>
                                    <div class="w-full bg-slate-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">Data tidak ditemukan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>