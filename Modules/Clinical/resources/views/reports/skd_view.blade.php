<x-app-layout title="Preview Laporan SKD">
        <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight">Preview Laporan SKD</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Silahkan export laporan</p>
                </div>
            </div>
             <a href="{{ route('clinical.reports.skd') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                Kembali ke Filter
            </a>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-[100rem] mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Lebar maksimal untuk data grid --}}
            
            {{-- Dokumen Header Card --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="space-y-1">
                        <h3 class="font-medium text-lg uppercase tracking-tight">Arsip Keterangan Sakit Karyawan</h3>
                        <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                            <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Periode: <span class="font-medium">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</span> — <span class="font-medium">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</span></span>
                        </div>
                    </div>
                    
                    <div class="flex shrink-0 gap-3">
                        <form action="{{ route('clinical.reports.skd_export') }}" method="POST" target="_blank" class="flex gap-3">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                            
                            <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Export Excel
                            </button>
                            
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Export PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table View --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="overflow-x-auto overflow-y-auto max-h-[70vh]"> {{-- Sticky Header Area --}}
                    <table class="w-full caption-bottom text-sm text-left whitespace-nowrap">
                        <thead class="[&_tr]:border-b sticky top-0 z-10 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 font-medium">
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400 text-center">No</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">Informasi Karyawan</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">No. Registrasi</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">Tipe</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400 text-center">Masa Istirahat</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400 text-center">Durasi</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">Pemeriksa (Dr/Pwt)</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">Instansi/RSUD</th>
                                <th class="h-12 px-4 align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa Klinis</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($data as $key => $row)
                            @php
                                $dokter = '-'; $perawat = '-';
                                $klinik = $row->external_clinic_name;
                                $diagnosa = $row->notes;
                                
                                if($row->type == 'internal') {
                                    $klinik = 'Klinik Internal';
                                    $examiner = $row->medicalRecord->examiner ?? null;
                                    if ($examiner) {
                                        if (str_contains(get_class($examiner), 'Doctor')) { $dokter = $examiner->name; } 
                                        else { $perawat = $examiner->nama ?? $examiner->name; }
                                    }
                                } else { $dokter = $row->external_doctor_name; }
                            @endphp

                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td class="p-4 align-middle text-center text-neutral-500 dark:text-neutral-400">{{ $key + 1 }}</td>
                                <td class="p-4 align-middle">
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">{{ $row->patient->name }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-xs font-mono text-neutral-500">{{ $row->patient->nik ?? '-' }}</span>
                                        <span class="text-neutral-300 dark:text-neutral-600">|</span>
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Dept: {{ $row->patient->department->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle font-mono text-neutral-600 dark:text-neutral-300">{{ $row->reg_number }}</td>
                                <td class="p-4 align-middle">
                                    @if($row->type == 'internal')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800 uppercase">Internal</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800 uppercase">Eksternal</span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <div class="flex items-center justify-center gap-2 text-xs">
                                        <span>{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</span>
                                        <svg class="w-3 h-3 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        <span>{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <span class="px-2 py-1 bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-600 rounded-md text-xs font-medium">{{ $row->duration_days }} Hari</span>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-medium">{{ $dokter }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">Pwt: {{ $perawat }}</div>
                                </td>
                                <td class="p-4 align-middle text-neutral-600 dark:text-neutral-400 text-xs">{{ $klinik }}</td>
                                <td class="p-4 align-middle text-xs text-neutral-500 dark:text-neutral-400 truncate max-w-xs" title="{{ $diagnosa }}">
                                    {{ Str::limit($diagnosa, 50) }}
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td colspan="9" class="p-4 align-middle text-center text-neutral-500 dark:text-neutral-400 py-10">
                                    Data SKD tidak ditemukan untuk periode pencarian ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="flex justify-between items-center p-4 text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                <span>Data Source: Clinical Medical Records</span>
                <span>Generated at: {{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>