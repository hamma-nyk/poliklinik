<x-app-layout title="Preview Laporan SKD">
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Preview Laporan SKD
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-8xl biar lebar --}}
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg">Laporan Surat Keterangan Dokter</h3>
                        <p class="text-sm text-slate-500">
                            Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('clinical.reports.skd_export') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $startDate }}">
                            <input type="hidden" name="end_date" value="{{ $endDate }}">
                            
                            <button type="submit" name="format" value="excel" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700">
                                Download Excel
                            </button>
                            <button type="submit" name="format" value="pdf" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700">
                                Download PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 overflow-hidden overflow-x-auto">
                <table class="w-full text-xs text-left whitespace-nowrap">
                    <thead class="bg-slate-100 text-slate-500 uppercase font-bold border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3">NIK</th>
                            <th class="px-4 py-3">No. KTP</th>
                            <th class="px-4 py-3">Nama Karyawan</th>
                            <th class="px-4 py-3">Bagian / Jabatan</th>
                            <th class="px-4 py-3">No. SKD</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3 text-center">Mulai</th>
                            <th class="px-4 py-3 text-center">Akhir</th>
                            <th class="px-4 py-3 text-center">Lama</th>
                            <th class="px-4 py-3">Nama Dokter</th>
                            <th class="px-4 py-3">Nama Perawat</th>
                            <th class="px-4 py-3">RSUD / Poli</th>
                            <th class="px-4 py-3">Diagnosa / Ket</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $key => $row)
                        @php
                            // Logic Mapping Data (Sama seperti PDF & Excel)
                            $dokter = '-';
                            $perawat = '-';
                            $klinik = $row->external_clinic_name;
                            $diagnosa = $row->notes;
                            
                            if($row->type == 'internal') {
                                $klinik = 'Klinik Internal';
                                $examiner = $row->medicalRecord->examiner ?? null;
                                
                                // Cek apakah pemeriksa Dokter atau Perawat
                                if ($examiner) {
                                    // Ganti 'Doctor' dengan nama class model Dokter Anda jika berbeda
                                    if (str_contains(get_class($examiner), 'Doctor')) {
                                        $dokter = $examiner->name;
                                    } else {
                                        $perawat = $examiner->nama ?? $examiner->name;
                                    }
                                }
                            } else {
                                $dokter = $row->external_doctor_name;
                            }
                        @endphp

                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-center font-bold text-slate-500">{{ $key + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-slate-600">{{ $row->patient->nik ?? '-' }}</td>
                            <td class="px-4 py-3 font-mono text-slate-600">{{ $row->patient->ktp ?? '-' }}</td>
                            <td class="px-4 py-3 font-bold text-slate-800">{{ $row->patient->name }}</td>
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-700">{{ $row->patient->department->name ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $row->patient->position->name ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 font-mono text-indigo-600 font-bold">{{ $row->reg_number }}</td>
                            <td class="px-4 py-3">
                                @if($row->type == 'internal')
                                    <span class="bg-indigo-100 text-indigo-800 text-[10px] font-bold px-2 py-0.5 rounded">INTERNAL</span>
                                @else
                                    <span class="bg-orange-100 text-orange-800 text-[10px] font-bold px-2 py-0.5 rounded">EKSTERNAL</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-center font-bold">{{ $row->duration_days }} Hari</td>
                            <td class="px-4 py-3 font-bold text-slate-700">{{ $dokter }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $perawat }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $klinik }}</td>
                            <td class="px-4 py-3 italic text-slate-500 truncate max-w-xs" title="{{ $diagnosa }}">
                                {{ Str::limit($diagnosa, 30) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="px-6 py-8 text-center text-slate-400 italic">
                                Tidak ada data SKD pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>