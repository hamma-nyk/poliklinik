<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Detail Rekam Medis') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Arsip digital pemeriksaan pasien</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('clinical.records.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
                {{-- Tombol Kirim WhatsApp (Baru) --}}
    <a href="{{ route('clinical.records.send_wa', $record->id) }}" 
   onclick="return confirmAndDisable(this)"
   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50 group">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    <span>Kirim WA</span>
</a>

<script>
function confirmAndDisable(el) {
    if (!confirm('Kirim rekam medis ini ke nomor WhatsApp pasien?')) return false;
    
    // Ubah tampilan tombol menjadi loading
    el.classList.add('opacity-50', 'pointer-events-none');
    el.innerHTML = `
        <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Mengirim...
    `;
    return true;
}
</script>
                <a href="{{ route('clinical.records.print', $record->id) }}" target="_blank" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden">
                
                {{-- ID Header --}}
                <div class="bg-slate-50/50 dark:bg-slate-800/50 px-8 py-6 border-b border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1">Nomor Registrasi RM</div>
                        <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 font-mono tracking-tight">{{ $record->code }}</div>
                    </div>
                    <div class="md:text-right">
                        <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1">Waktu Pemeriksaan</div>
                        <div class="font-bold text-slate-700 dark:text-slate-200 flex items-center md:justify-end">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ strtoupper($record->created_at->format('d M Y')) }} 
                            <span class="mx-2 text-slate-300">|</span>
                            {{ $record->created_at->format('H:i') }} WIB
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        
                        {{-- Data Pasien --}}
                        <div class="lg:col-span-1">
                            <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                                <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                                Identitas Pasien
                            </h3>
                            <div class="space-y-4">
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Lengkap</div>
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $record->patient->name }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ID Pasien</div>
                                        <div class="font-mono text-sm font-semibold text-slate-900 dark:text-slate-50">{{ $record->patient->code }}</div>
                                    </div>
                                    <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kategori</div>
                                        <span class="inline-flex items-center rounded-md border {{ $record->patient->type == 'karyawan' ? 'border-transparent bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-50' : 'border-slate-200 text-slate-950 dark:border-slate-800 dark:text-slate-50' }} px-2.5 py-0.5 text-xs font-semibold uppercase">
                                            {{ $record->patient->type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Detail Fisik</div>
                                    <div class="text-sm font-medium text-slate-900 dark:text-slate-50">
                                        {{ $record->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ \Carbon\Carbon::parse($record->patient->birth_date)->age }} Thn
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tanda Vital & Hasil Pemeriksaan --}}
                        <div class="lg:col-span-2">
                            <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                                <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                                Pemeriksaan Klinis
                            </h3>
                            
                            {{-- Vital Signs Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tensi (mmHg)</div>
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $record->tensi ?? '-' }}</div>
                                </div>
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Suhu (°C)</div>
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $record->suhu_tubuh ?? '-' }}</div>
                                </div>
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Berat (Kg)</div>
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $record->berat_badan ?? '-' }}</div>
                                </div>
                                <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tinggi (cm)</div>
                                    <div class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $record->tinggi_badan ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 block mb-2">Keluhan Utama</label>
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 leading-relaxed">{{ $record->keluhan_utama }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 block mb-2">Riwayat Penyakit</label>
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 leading-relaxed">{{ $record->riwayat_penyakit ?? '-' }}</p>
                                    </div>
                                    @if($record->riwayat_alergi)
                                    <div class="p-4 bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-md">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-red-600 dark:text-red-400 block mb-1">Alergi Obat</label>
                                        <p class="text-red-700 dark:text-red-300 font-semibold text-sm">{{ $record->riwayat_alergi }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 block mb-2">Diagnosa (ICD-10)</label>
                                        <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-4">
                                            <div class="font-semibold text-sm text-slate-900 dark:text-slate-50 leading-tight mb-1">{{ $record->diagnosis->name ?? $record->diagnosa }}</div>
                                            <div class="font-mono text-sm text-slate-500 dark:text-slate-400">{{ $record->diagnosis->code ?? '' }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 block mb-2">Tindakan / Terapi</label>
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-50 leading-relaxed">{{ $record->tindakan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Resep Obat --}}
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                            <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                            Resep Obat & Farmasi
                        </h3>
                        <div class="overflow-hidden border border-slate-200 dark:border-slate-800 rounded-md">
                            <table class="w-full caption-bottom text-sm">
                                <thead class="[&_tr]:border-b bg-slate-50 dark:bg-slate-800/50">
                                    <tr class="border-b transition-colors">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Item Obat</th>
                                        <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Qty</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Aturan Pakai / Instruksi</th>
                                    </tr>
                                </thead>
                                <tbody class="[&_tr:last-child]:border-0 divide-y divide-slate-200 dark:divide-slate-800">
                                    @forelse($record->medicines as $item)
                                    <tr class="border-b transition-colors hover:bg-slate-100/50 dark:hover:bg-slate-800/50">
                                        <td class="p-4 align-middle">
                                            <div class="font-medium text-slate-900 dark:text-slate-100">{{ $item->medicine->name ?? 'Item Dihapus' }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">{{ $item->medicine->code ?? '' }}</div>
                                        </td>
                                        <td class="p-4 align-middle text-center">
                                            <span class="inline-flex items-center rounded-md border border-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-950 dark:border-slate-800 dark:text-slate-50">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="p-4 align-middle text-slate-600 dark:text-slate-400">
                                            {{ $item->instructions }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="p-4 align-middle text-center text-slate-500 dark:text-slate-400 italic">Tidak ada resep obat pada kunjungan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tanda Tangan --}}
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex justify-end">
                        <div class="text-center w-64">
                            @if ($record->doctor?->id)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-20 uppercase tracking-widest font-semibold">Dokter Pemeriksa,</p>
                            <div class="relative inline-block">
                                <p class="font-semibold text-slate-900 dark:text-slate-50 underline decoration-slate-300 dark:decoration-slate-700 underline-offset-8">{{ $record->doctor->name ?? '-'}}</p>                                
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2"> {{ ('SIP.' . $record->doctor->sip) }}</p>
                            </div>
                            @elseif ($record->nurse?->id)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-20 uppercase tracking-widest font-semibold">Perawat Pemeriksa,</p>
                            <div class="relative inline-block">
                                <p class="font-semibold text-slate-900 dark:text-slate-50 underline decoration-slate-300 dark:decoration-slate-700 underline-offset-8">{{ $record->nurse->nama ?? '-'}}</p>                                
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2"> {{ ('STR.' . $record->nurse->str) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>