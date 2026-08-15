<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Laporan Penyakit') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Analisis pola penyakit (Morbiditas) berdasarkan diagnosa ICD-10</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Morbiditas</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
                <form method="GET" action="{{ route('clinical.reports.diseases') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('clinical.reports.index') }}" 
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" name="action" value="filter" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">
                            Tampilkan
                        </button>
                        
                        {{-- TOMBOL EXPORT EXCEL (BARU) --}}
                        <button type="submit" name="action" value="excel" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            Export Excel
                        </button>

                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Result Card --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="font-medium text-xs">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="inline-flex items-center px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-md font-medium text-xs border border-blue-100 dark:border-blue-800/50">
                        TOTAL SELURUH KASUS: {{ number_format($grandTotal, 0, ',', '.') }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400 w-20">Rank</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Kode & Nama Diagnosa</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Jumlah Kasus</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 w-64">Distribusi Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($data as $index => $row)
                                @php
                                    $percent = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0;
                                    // Warna progress bar dinamis berdasarkan rank
                                    $barColor = $index < 3 ? 'bg-blue-600' : 'bg-slate-400 dark:bg-slate-500';
                                @endphp
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                <td class="p-4 align-middle text-center">
                                    <span class="text-lg font-bold {{ $index < 3 ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400' }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center">
                                        <div class="font-mono text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-md mr-3 border border-slate-200 dark:border-slate-600 uppercase">
                                            {{ $row->diagnosis->code ?? '-' }}
                                        </div>
                                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200 group-hover:text-blue-600 transition-colors">
                                            {{ $row->diagnosis->name ?? 'Diagnosa Dihapus' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <div class="text-xl font-medium text-slate-800 dark:text-slate-100">{{ number_format($row->total, 0, ',', '.') }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Pasien</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ number_format($percent, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full shadow-sm" style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-4 align-middle text-center py-20">
                                    <div class="flex flex-col items-center justify-center">
                                        <h3 class="text-slate-500 dark:text-slate-400 font-medium">Data Tidak Ditemukan</h3>
                                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Belum ada diagnosa yang tercatat pada rentang tanggal tersebut.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>