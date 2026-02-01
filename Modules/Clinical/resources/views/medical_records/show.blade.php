<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800">{{ __('Detail Rekam Medis') }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('clinical.records.index') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold hover:bg-slate-50">
                    &larr; Kembali
                </a>
                <a href="{{ route('clinical.records.print', $record->id) }}" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">No. Rekam Medis</div>
                        <div class="text-2xl font-bold text-blue-800">{{ $record->code }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-bold text-slate-500 uppercase">Tanggal Periksa</div>
                        <div class="font-bold text-slate-800">{{ $record->created_at->format('d F Y, H:i') }} WIB</div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <h3 class="font-bold text-slate-800 border-b pb-2 mb-4">Data Pasien</h3>
                        <table class="w-full text-sm">
                            <tr>
                                <td class="py-1 text-slate-500 w-1/3">Nama Lengkap</td>
                                <td class="font-bold">{{ $record->patient->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-slate-500">KTP</td>
                                <td>{{ $record->patient->ktp ?? '-' }}</td>
                            </tr>
                            @if ($record->patient->type == 'karyawan')
                            <tr>
                                <td class="py-1 text-slate-500">NIK</td>
                                <td>{{ $record->patient->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-slate-500">Bagian</td>
                                <td>{{ $record->patient->subbag_dept ?? '-' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="py-1 text-slate-500">Jenis Kelamin</td>
                                <td>{{ $record->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-slate-500">Usia</td>
                                <td>{{ \Carbon\Carbon::parse($record->patient->birth_date)->age }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-slate-500">Status</td>
                                <td>
                                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ $record->patient->type == 'karyawan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($record->patient->type) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800 border-b pb-2 mb-4">Tanda Vital</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-3 rounded-lg text-center">
                                <div class="text-xs text-blue-600 font-bold uppercase">Tensi</div>
                                <div class="text-lg font-bold text-slate-800">{{ $record->tensi ?? '-' }} <span class="text-xs font-normal">mmHg</span></div>
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg text-center">
                                <div class="text-xs text-red-600 font-bold uppercase">Suhu</div>
                                <div class="text-lg font-bold text-slate-800">{{ $record->suhu_tubuh ?? '-' }} <span class="text-xs font-normal">°C</span></div>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg text-center">
                                <div class="text-xs text-green-600 font-bold uppercase">Berat</div>
                                <div class="text-lg font-bold text-slate-800">{{ $record->berat_badan ?? '-' }} <span class="text-xs font-normal">Kg</span></div>
                            </div>
                            <div class="bg-amber-50 p-3 rounded-lg text-center">
                                <div class="text-xs text-amber-600 font-bold uppercase">Tinggi</div>
                                <div class="text-lg font-bold text-slate-800">{{ $record->tinggi_badan ?? '-' }} <span class="text-xs font-normal">cm</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="font-bold text-slate-800 border-b pb-2 mb-4">Hasil Pemeriksaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keluhan Utama</label>
                                <p class="text-slate-800 mb-4">{{ $record->keluhan_utama }}</p>

                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Riwayat Penyakit</label>
                                <p class="text-slate-800 mb-4">{{ $record->riwayat_penyakit ?? '-' }}</p>

                                <label class="block text-xs font-bold text-red-500 uppercase mb-1">Alergi Obat</label>
                                <p class="text-red-700 font-bold mb-4">{{ $record->riwayat_alergi ?? 'Tidak ada' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-blue-600 uppercase mb-1">Diagnosa (ICD-10)</label>
                                <div class="bg-blue-50 border border-blue-100 p-3 rounded-lg mb-4">
                                    <div class="font-bold text-lg text-blue-800">{{ $record->diagnosis->name ?? $record->diagnosa }}</div>
                                    <div class="text-sm text-blue-600">{{ $record->diagnosis->code ?? '' }}</div>
                                </div>

                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tindakan / Terapi</label>
                                <p class="text-slate-800">{{ $record->tindakan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="font-bold text-slate-800 border-b pb-2 mb-4">Resep Obat yang Diberikan</h3>
                        <table class="w-full text-sm border-collapse border border-slate-200">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="border border-slate-200 px-4 py-2 text-left">Nama Obat</th>
                                    <th class="border border-slate-200 px-4 py-2 text-center w-24">Jumlah</th>
                                    <th class="border border-slate-200 px-4 py-2 text-left">Aturan Pakai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($record->medicines as $item)
                                <tr>
                                    <td class="border border-slate-200 px-4 py-2">
                                        {{ $item->medicine->name ?? 'Obat Dihapus' }}
                                        <div class="text-xs text-slate-400">{{ $item->medicine->code ?? '' }}</div>
                                    </td>
                                    <td class="border border-slate-200 px-4 py-2 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="border border-slate-200 px-4 py-2 italic text-slate-600">{{ $item->instructions }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="border border-slate-200 px-4 py-4 text-center text-slate-400 italic">Tidak ada obat yang diresepkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="md:col-span-2 mt-8 flex justify-end text-center">
                        <div>
                            <p class="text-sm text-slate-500 mb-16">Dokter Pemeriksa,</p>
                            <p class="font-bold underline">{{ $record->doctor->name }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>