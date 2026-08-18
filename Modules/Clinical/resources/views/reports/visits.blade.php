<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Laporan Kunjungan Pasien') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Monitoring volume dan riwayat pelayanan klinis</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Kunjungan</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Filter Panel --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                <form method="GET" action="{{ route('clinical.reports.visits') }}" class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="w-full md:w-auto space-y-1.5">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" 
                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
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
                        <button type="submit" name="action" value="pdf" formtarget="_blank" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Export PDF
                        </button>
                    </div>
                </form>
            </div>

            {{-- Results Table --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-800/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-medium">
                            Total Kunjungan: {{ number_format($data->count(), 0, ',', '.') }} Pasien
                        </span>
                    </div>
                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Data terverifikasi sistem</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Waktu Kunjungan</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Identitas Pasien</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Status</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa Klinis</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Dokter</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Perawat</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Terapi Obat (Item & Qty)</th>

                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($data as $row)
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td class="p-4 align-middle text-neutral-600 dark:text-neutral-300">
                                    <div class="font-medium text-neutral-800 dark:text-neutral-100 uppercase">{{ $row->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $row->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="text-sm font-medium text-neutral-800 dark:text-neutral-100">{{ $row->patient->name }}</div>
                                    @if($row->jenis_kunjungan == 'Poli Umum')
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5"><a href="{{ route('clinical.records.index') }}?search={{ $row->code }}" class="hover:text-amber-600 transition-colors">RM: {{ $row->code }}</a></div>
                                    @else
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5"><a href="{{ route('clinical.lab.index') }}?search={{ $row->code }}" class="hover:text-amber-600 transition-colors">LAB: {{ $row->code }}</a></div>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium uppercase border {{ $row->patient->type == 'karyawan' ? 'bg-blue-50 text-blue-700 border-b border-neutral-200lue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800/50' : 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' }}">
                                        {{ $row->patient->type }}
                                    </span>
                                    <br>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $row->patient->type == 'karyawan' ? 'NIK:' : 'KTP:' }} {{ $row->patient->nik ?? $row->patient->ktp }}</div>
                                </td>
                                <td class="p-4 align-middle">
                                    @if($row->jenis_kunjungan == 'Poli Umum')
                                        <div class="text-sm text-neutral-700 dark:text-neutral-300 line-clamp-1 max-w-xs font-medium" title="{{ $row->diagnosis->name ?? $row->diagnosa }}">
                                            {{ $row->diagnosis->name ?? $row->diagnosa }}
                                        </div>
                                        @if($row->diagnosis)
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase">{{ $row->diagnosis->code }}</div>
                                        @endif
                                    @else
                                        <span style="font-size: 9px;">
                                            @if($row->gula_darah) GDS:{{$row->gula_darah}} - @endif
                                            @if($row->kolesterol) Chol:{{$row->kolesterol}} - @endif
                                            @if($row->asam_urat) UA:{{$row->asam_urat}} @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center">
                                        @php
                                            $name = $row->doctor->name ?? '-';
                                        @endphp

                                        @if($row->doctor == null)
                                            <span class="text-sm text-neutral-500 dark:text-neutral-400 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-md bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-600 flex items-center justify-center text-xs font-medium mr-3">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-neutral-900 dark:text-neutral-200">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Dokter
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center">
                                        @php
                                            $name = $row->nurse->nama ?? '-';
                                        @endphp

                                        @if($row->nurse == null)
                                            <span class="text-sm text-neutral-500 dark:text-neutral-400 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-md bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-600 flex items-center justify-center text-xs font-medium mr-3">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-neutral-900 dark:text-neutral-200">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Perawat
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                {{-- KOLOM DETAIL OBAT (RAPID VIEW) --}}
                                <td class="p-4 align-middle min-w-[250px]">
                                    @if($row->medicineTransactions->isNotEmpty())
                                        <div class="space-y-1.5">
                                            @foreach($row->medicineTransactions as $trans)
                                                @foreach($trans->items as $item)
                                                <div class="flex items-start justify-between gap-4 text-xs border-b border-neutral-200 dark:border-neutral-600 pb-1 last:border-0 transition-colors">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-neutral-700 dark:text-neutral-200 uppercase">{{ $item->medicine->name }}</span>
                                                        <span class="text-neutral-500 dark:text-neutral-400 italic">{{ number_format($item->quantity) }} {{ $item->medicine->unit }}</span>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400 italic flex items-center">
                                            <svg class="w-3 h-3 mr-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            Tanpa Terapi Obat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-4 align-middle text-center py-20">
                                    <div class="flex flex-col items-center justify-center">
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-medium">Data Tidak Ditemukan</h3>
                                        <p class="text-neutral-500 dark:text-neutral-400 text-xs mt-1">Ganti rentang tanggal untuk melihat data lainnya.</p>
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