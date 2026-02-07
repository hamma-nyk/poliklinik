<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Detail Rekam Medis') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Arsip digital pemeriksaan pasien</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('clinical.records.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                <a href="{{ route('clinical.records.print', $record->id) }}" target="_blank" class="inline-flex items-center px-5 py-2 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                
                {{-- ID Header --}}
                <div class="bg-slate-50/50 dark:bg-slate-800/50 px-8 py-6 border-b border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1">Nomor Registrasi RM</div>
                        <div class="text-3xl font-black text-indigo-600 dark:text-indigo-400 font-mono tracking-tight">{{ $record->code }}</div>
                    </div>
                    <div class="md:text-right">
                        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1">Waktu Pemeriksaan</div>
                        <div class="font-bold text-slate-700 dark:text-slate-200 flex items-center md:justify-end">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $record->created_at->format('d M Y') }} 
                            <span class="mx-2 text-slate-300">|</span>
                            {{ $record->created_at->format('H:i') }} WIB
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        
                        {{-- Data Pasien --}}
                        <div class="lg:col-span-1">
                            <h3 class="font-black text-slate-800 dark:text-slate-100 text-sm uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                                Identitas Pasien
                            </h3>
                            <div class="space-y-4">
                                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase mb-1">Nama Lengkap</div>
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $record->patient->name }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase mb-1">ID Pasien</div>
                                        <div class="font-mono text-xs font-bold text-slate-700 dark:text-slate-300">{{ $record->patient->code }}</div>
                                    </div>
                                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase mb-1">Kategori</div>
                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase {{ $record->patient->type == 'karyawan' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30' }}">
                                            {{ $record->patient->type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase mb-1">Detail Fisik</div>
                                    <div class="text-sm text-slate-700 dark:text-slate-300">
                                        {{ $record->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ \Carbon\Carbon::parse($record->patient->birth_date)->age }} Thn
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tanda Vital & Hasil Pemeriksaan --}}
                        <div class="lg:col-span-2">
                            <h3 class="font-black text-slate-800 dark:text-slate-100 text-sm uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-2 bg-rose-500 rounded-full mr-3"></span>
                                Pemeriksaan Klinis
                            </h3>
                            
                            {{-- Vital Signs Grid --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-2xl border border-blue-100 dark:border-blue-800/30">
                                    <div class="text-[10px] text-blue-600 dark:text-blue-400 font-black uppercase tracking-tighter">Tensi (mmHg)</div>
                                    <div class="text-xl font-black text-slate-800 dark:text-slate-100">{{ $record->tensi ?? '-' }}</div>
                                </div>
                                <div class="bg-rose-50 dark:bg-rose-900/20 p-4 rounded-2xl border border-rose-100 dark:border-rose-800/30">
                                    <div class="text-[10px] text-rose-600 dark:text-rose-400 font-black uppercase tracking-tighter">Suhu (°C)</div>
                                    <div class="text-xl font-black text-slate-800 dark:text-slate-100">{{ $record->suhu_tubuh ?? '-' }}</div>
                                </div>
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 rounded-2xl border border-emerald-100 dark:border-emerald-800/30">
                                    <div class="text-[10px] text-emerald-600 dark:text-emerald-400 font-black uppercase tracking-tighter">Berat (Kg)</div>
                                    <div class="text-xl font-black text-slate-800 dark:text-slate-100">{{ $record->berat_badan ?? '-' }}</div>
                                </div>
                                <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-2xl border border-amber-100 dark:border-amber-800/30">
                                    <div class="text-[10px] text-amber-600 dark:text-amber-400 font-black uppercase tracking-tighter">Tinggi (cm)</div>
                                    <div class="text-xl font-black text-slate-800 dark:text-slate-100">{{ $record->tinggi_badan ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-2">Keluhan Utama</label>
                                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $record->keluhan_utama }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-2">Riwayat Penyakit</label>
                                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $record->riwayat_penyakit ?? '-' }}</p>
                                    </div>
                                    @if($record->riwayat_alergi)
                                    <div class="p-3 bg-red-50 dark:bg-red-900/10 border-l-4 border-red-500 rounded-r-xl">
                                        <label class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase block mb-1">Alergi Obat</label>
                                        <p class="text-red-700 dark:text-red-300 font-bold text-sm">{{ $record->riwayat_alergi }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest block mb-2">Diagnosa (ICD-10)</label>
                                        <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30 p-4 rounded-2xl">
                                            <div class="font-black text-lg text-indigo-800 dark:text-indigo-300 leading-tight mb-1">{{ $record->diagnosis->name ?? $record->diagnosa }}</div>
                                            <div class="font-mono text-sm text-indigo-600 dark:text-indigo-400">{{ $record->diagnosis->code ?? '' }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-2">Tindakan / Terapi</label>
                                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $record->tindakan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Resep Obat --}}
                    <div class="mt-12">
                        <h3 class="font-black text-slate-800 dark:text-slate-100 text-sm uppercase tracking-widest mb-6 flex items-center">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></span>
                            Resep Obat & Farmasi
                        </h3>
                        <div class="overflow-hidden border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <table class="w-full text-sm">
                                <thead class="bg-slate-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-black text-slate-500 dark:text-slate-400 uppercase text-[10px]">Item Obat</th>
                                        <th class="px-6 py-4 text-center font-black text-slate-500 dark:text-slate-400 uppercase text-[10px]">Qty</th>
                                        <th class="px-6 py-4 text-left font-black text-slate-500 dark:text-slate-400 uppercase text-[10px]">Aturan Pakai / Instruksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                    @forelse($record->medicines as $item)
                                    <tr class="dark:bg-slate-800">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800 dark:text-slate-200">{{ $item->medicine->name ?? 'Item Dihapus' }}</div>
                                            <div class="text-[10px] font-mono text-slate-400 uppercase mt-0.5">{{ $item->medicine->code ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg font-black text-slate-700 dark:text-slate-200">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="px-6 py-4 italic text-slate-600 dark:text-slate-400">
                                            {{ $item->instructions }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500 italic">Tidak ada resep obat pada kunjungan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tanda Tangan --}}
                    <div class="mt-12 pt-12 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                        <div class="text-center w-64">
                            @if ($record->doctor?->sip)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-20 uppercase tracking-widest font-bold">Dokter Pemeriksa,</p>
                            <div class="relative inline-block">
                                <p class="font-black text-slate-800 dark:text-slate-100 underline decoration-indigo-500 underline-offset-8">{{ $record->doctor->name ?? '-'}}</p>                                
                                <p class="text-[12px] text-slate-400 mt-2"> {{ ('SIP.' . $record->doctor->sip) }}</p>
                            </div>
                            @elseif ($record->nurse->str)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-20 uppercase tracking-widest font-bold">Perawat Pemeriksa,</p>
                            <div class="relative inline-block">
                                <p class="font-black text-slate-800 dark:text-slate-100 underline decoration-indigo-500 underline-offset-8">{{ $record->nurse->nama ?? '-'}}</p>                                
                                <p class="text-[12px] text-slate-400 mt-2"> {{ ('STR.' . $record->nurse->str) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>