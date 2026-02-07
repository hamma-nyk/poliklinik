<x-app-layout title="Preview Laporan SKD">
        <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div class="flex items-center gap-3">
                <!-- <div class="p-2 bg-indigo-50 dark:bg-slate-700 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div> -->
                <div>
                    <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 tracking-tight">Preview Laporan SKD</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Silahkan export laporan</p>
                </div>
            </div>
             <a href="{{ route('clinical.reports.skd') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                Kembali ke Filter
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-[100rem] mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Lebar maksimal untuk data grid --}}
            
            {{-- Dokumen Header Card --}}
            <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="space-y-1">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 uppercase tracking-tight">Arsip Keterangan Sakit Karyawan</h3>
                        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Periode: <span class="font-bold text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}</span> — <span class="font-bold text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</span></span>
                        </div>
                    </div>
                    
                    <div class="flex shrink-0 gap-3">
                        <form action="{{ route('clinical.reports.skd_export') }}" method="POST" target="_blank" class="flex gap-3">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                            
                            <button type="submit" name="format" value="excel" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95 uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Export Excel
                            </button>
                            
                            <button type="submit" name="format" value="pdf" class="inline-flex items-center px-5 py-2.5 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 shadow-lg shadow-rose-500/20 transition-all hover:scale-105 active:scale-95 uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Export PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table View --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-[2rem] border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto overflow-y-auto max-h-[70vh]"> {{-- Sticky Header Area --}}
                    <table class="w-full text-[11px] text-left whitespace-nowrap">
                        <thead class="sticky top-0 z-10 bg-slate-50 dark:bg-slate-700 text-slate-500 dark:text-slate-400 uppercase font-bold border-b border-slate-200 dark:border-slate-600">
                            <tr>
                                <th class="px-4 py-4 text-center">No</th>
                                <th class="px-4 py-4">Informasi Karyawan</th>
                                <th class="px-4 py-4">No. Registrasi</th>
                                <th class="px-4 py-4">Tipe</th>
                                <th class="px-4 py-4 text-center">Masa Istirahat</th>
                                <th class="px-4 py-4 text-center">Durasi</th>
                                <th class="px-4 py-4">Pemeriksa (Dr/Pwt)</th>
                                <th class="px-4 py-4">Instansi/RSUD</th>
                                <th class="px-4 py-4">Diagnosa Klinis</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
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

                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150">
                                <td class="px-4 py-4 text-center font-bold text-slate-400 dark:text-slate-500">{{ $key + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $row->patient->name }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-mono font-bold">{{ $row->patient->nik ?? '-' }}</span>
                                        <span class="text-slate-300 dark:text-slate-600">|</span>
                                        <span class="text-slate-500 dark:text-slate-400 italic">Dept: {{ $row->patient->department->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 font-mono font-bold text-slate-600 dark:text-slate-300 tracking-tight">{{ $row->reg_number }}</td>
                                <td class="px-4 py-4">
                                    @if($row->type == 'internal')
                                        <span class="inline-flex items-center px-2.5 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg font-bold border border-indigo-100 dark:border-indigo-800 text-[9px] uppercase tracking-wider">Internal</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 rounded-lg font-bold border border-orange-100 dark:border-orange-800 text-[9px] uppercase tracking-wider">Eksternal</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</span>
                                        <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        <span class="text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full font-bold text-slate-700 dark:text-slate-200">{{ $row->duration_days }} Hari</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-slate-800 dark:text-slate-200 font-semibold">{{ $dokter }}</div>
                                    <div class="text-[9px] text-slate-400 italic">Pwt: {{ $perawat }}</div>
                                </td>
                                <td class="px-4 py-4 text-slate-600 dark:text-slate-400 font-medium italic">{{ $klinik }}</td>
                                <td class="px-4 py-4 italic text-slate-500 dark:text-slate-400 truncate max-w-xs" title="{{ $diagnosa }}">
                                    {{ Str::limit($diagnosa, 50) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-24 text-center text-slate-400 dark:text-slate-600 italic">
                                    Data SKD tidak ditemukan untuk periode pencarian ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="flex justify-between items-center px-4 text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">
                <span>Data Source: Clinical Medical Records</span>
                <span>Generated at: {{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>