<x-app-layout title="Detail Surat Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">
                    {{ __('Detail Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">{{$letter->reg_number}}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('clinical.sick-leaves.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50">
                    Kembali
                </a>
                @if($letter->type == 'internal')
                    <a href="{{ route('clinical.sick-leaves.print', $letter->id) }}" target="_blank" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 overflow-hidden transition-all">
                
                {{-- Header Status --}}
                <div class="bg-neutral-50 dark:bg-neutral-900 px-8 py-5 border-b border-neutral-200 dark:border-neutral-800 flex justify-between items-center">
                    <span class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">Data Arsip Medis</span>
                    @if($letter->type == 'internal')
                        <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-50">Internal Klinik</span>
                    @else
                        <span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-neutral-200 text-neutral-950 dark:border-neutral-800 dark:text-neutral-50">Eksternal (RS Luar)</span>
                    @endif
                </div>

                <div class="p-6 space-y-10">
                    
                    {{-- Section 1: Pasien --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-8 border-b border-neutral-200 dark:border-neutral-800">
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nama Lengkap Pasien</label>
                            <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">{{ $letter->patient->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">NIK / No. Karyawan</label>
                            <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50 font-mono tracking-tight">{{ $letter->patient->nik }}</p>
                        </div>
                    </div>

                    {{-- Section 2: Detail Medis --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-8 border-b border-neutral-200 dark:border-neutral-800">
                        <div class="space-y-1">
                            <label class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Tenaga Medis / Dokter</label>
                            @if($letter->type == 'internal')
                                @if($letter->medicalRecord->doctor?->id)
                                <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">dr. {{ $letter->medicalRecord->doctor->name ?? '-' }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium uppercase tracking-tight">SIP: {{ $letter->medicalRecord->doctor->sip ?? '-' }}</p>
                                @elseif($letter->medicalRecord->nurse?->id)
                                <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">dr. {{ $letter->medicalRecord->nurse->nama ?? '-' }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium uppercase tracking-tight">SIP: {{ $letter->medicalRecord->nurse->str ?? '-' }}</p>
                                @endif
                            @else
                                <p class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">{{ $letter->external_doctor_name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 font-medium uppercase tracking-tight">{{ $letter->external_clinic_name }}</p>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Diagnosa Klinis</label>
                            <div class="rounded-md border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-900 shadow-sm dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50">
                                <p class="italic">"{{ $letter->notes ?? 'Tidak ada catatan diagnosa.' }}"</p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Durasi Izin --}}
                    <div class="rounded-md border border-neutral-200 bg-neutral-50 dark:bg-neutral-900 dark:border-neutral-800 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 rounded-md shadow-sm text-neutral-900 dark:text-neutral-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <label class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Masa Istirahat Sakit</label>
                        </div>
                        
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <p class="text-neutral-800 dark:text-neutral-200 text-sm leading-relaxed max-w-md">
                                Pasien diberikan izin istirahat selama <span class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">{{ $letter->duration_days }} Hari</span> kalender.
                            </p>
                            <div class="text-right">
                                <div class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">Rentang Tanggal</div>
                                <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                    {{ \Carbon\Carbon::parse($letter->start_date)->translatedFormat('d F Y') }} 
                                    <span class="mx-2 text-neutral-500 dark:text-neutral-400">s/d</span> 
                                    {{ \Carbon\Carbon::parse($letter->end_date)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Footer --}}
                    <div class="pt-4 flex items-center justify-center gap-2 text-neutral-400 dark:text-neutral-500">
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Document Secured by Internal Medical System</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>