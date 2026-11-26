<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">
                    {{ __('Laporan Penyakit') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Analisis pola penyakit (Morbiditas) berdasarkan diagnosa ICD-10</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Morbiditas</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="w-full space-y-6">
            
            {{-- Filter Panel --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4">
                <form method="GET" action="{{ route('clinical.reports.diseases') }}" class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-end">
                    <div class="w-full lg:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="w-full lg:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="flex flex-wrap gap-2 w-full lg:w-auto">
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
                        
                        {{-- TOMBOL EXPORT EXCEL (BARU) --}}
                        <button type="submit" name="action" value="excel" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            Export Excel
                        </button>

                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Result Card --}}
            <div x-data="{ openIndex: null }" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-800/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="font-medium text-xs">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="inline-flex items-center px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-md font-medium text-xs border border-blue-200 dark:border-blue-800/50">
                        TOTAL SELURUH KASUS: {{ number_format($grandTotal, 0, ',', '.') }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-20">Rank</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Kode & Nama Diagnosa</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Jumlah Kasus</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-64">Distribusi Persentase</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400 w-36">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($data as $index => $row)
                                @php
                                    $percent = $grandTotal > 0 ? ($row->total / $grandTotal) * 100 : 0;
                                    // Warna progress bar dinamis berdasarkan rank
                                    $barColor = $index < 3 ? 'bg-blue-600' : 'bg-neutral-400 dark:bg-neutral-500';
                                    $records = $patientDetails->get($row->diagnosis_id, collect());
                                @endphp
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td class="p-4 align-middle text-center">
                                    <span class="text-lg font-bold {{ $index < 3 ? 'text-blue-600 dark:text-blue-400' : 'text-neutral-400' }}">
                                        #{{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center">
                                        <div class="font-mono text-xs font-medium text-neutral-500 dark:text-neutral-400 bg-neutral-100 dark:bg-neutral-700 px-2 py-1 rounded-md mr-3 border border-neutral-200 dark:border-neutral-600 uppercase shrink-0">
                                            {{ $row->diagnosis->code ?? '-' }}
                                        </div>
                                        <div class="text-sm font-medium text-neutral-800 dark:text-neutral-200 group-hover:text-blue-600 transition-colors">
                                            {{ $row->diagnosis->name ?? 'Diagnosa Dihapus' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <div class="text-xl font-medium text-neutral-800 dark:text-neutral-100">{{ number_format($row->total, 0, ',', '.') }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">Pasien</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-medium text-neutral-600 dark:text-neutral-400">{{ number_format($percent, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-neutral-100 dark:bg-neutral-700 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full shadow-sm" style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-right whitespace-nowrap">
                                    <button type="button"
                                        @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs font-medium text-neutral-700 dark:text-neutral-200 shadow-sm hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                        <span x-text="openIndex === {{ $index }} ? 'Tutup' : 'Lihat Pasien'"></span>
                                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': openIndex === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr x-show="openIndex === {{ $index }}" x-cloak x-transition class="bg-neutral-50/70 dark:bg-neutral-900/50">
                                <td colspan="5" class="p-4">
                                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 overflow-hidden">
                                        <div class="px-4 py-2.5 border-b border-neutral-200 dark:border-neutral-700 flex flex-wrap items-center justify-between gap-2 bg-neutral-50 dark:bg-neutral-900/60">
                                            <span class="text-xs font-semibold uppercase tracking-wider text-neutral-600 dark:text-neutral-300">
                                                Daftar Pasien — {{ $row->diagnosis->name ?? 'Diagnosa' }} ({{ $records->count() }} Kasus)
                                            </span>
                                            <a href="{{ route('clinical.reports.diseases', ['start_date' => $startDate, 'end_date' => $endDate, 'action' => 'excel_detail', 'diagnosis_id' => $row->diagnosis_id]) }}" target="_blank"
                                               class="inline-flex items-center gap-1.5 rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-2.5 py-1 text-xs font-medium text-neutral-700 dark:text-neutral-200 shadow-sm hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                                Export Excel Pasien
                                            </a>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-xs">
                                                <thead>
                                                    <tr class="border-b border-neutral-200 dark:border-neutral-700">
                                                        <th class="px-4 py-2.5 text-left font-semibold text-neutral-500 dark:text-neutral-400 w-12">No</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold text-neutral-500 dark:text-neutral-400">Tanggal Pemeriksaan</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold text-neutral-500 dark:text-neutral-400">No. RM</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold text-neutral-500 dark:text-neutral-400">Nama Pasien</th>
                                                        <th class="px-4 py-2.5 text-left font-semibold text-neutral-500 dark:text-neutral-400">Dokter</th>
                                                        <th class="px-4 py-2.5 text-right font-semibold text-neutral-500 dark:text-neutral-400">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700/60">
                                                    @foreach($records as $recIdx => $rec)
                                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/40">
                                                        <td class="px-4 py-2.5 text-neutral-500 dark:text-neutral-400">{{ $recIdx + 1 }}</td>
                                                        <td class="px-4 py-2.5 whitespace-nowrap">
                                                            <span class="font-medium text-neutral-800 dark:text-neutral-100">{{ $rec->created_at->format('d M Y') }}</span>
                                                            <span class="text-neutral-500 dark:text-neutral-400 ml-1">{{ $rec->created_at->format('H:i') }} WIB</span>
                                                        </td>
                                                        <td class="px-4 py-2.5 font-mono font-semibold whitespace-nowrap">{{ $rec->code }}</td>
                                                        <td class="px-4 py-2.5">
                                                            <div class="font-medium text-neutral-900 dark:text-neutral-100">{{ $rec->patient->name ?? '-' }}</div>
                                                            @if($rec->patient)
                                                                <span class="text-[10px] uppercase tracking-wider text-neutral-500 dark:text-neutral-400">{{ $rec->patient->type }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2.5 text-neutral-600 dark:text-neutral-300">{{ $rec->doctor->name ?? '-' }}</td>
                                                        <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                                            <a href="{{ route('clinical.records.show', $rec->id) }}" class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 px-2.5 py-1 text-xs font-medium hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                                                Detail RM
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 align-middle text-center py-20">
                                    <div class="flex flex-col items-center justify-center">
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-medium">Data Tidak Ditemukan</h3>
                                        <p class="text-neutral-500 dark:text-neutral-400 text-xs mt-1">Belum ada diagnosa yang tercatat pada rentang tanggal tersebut.</p>
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