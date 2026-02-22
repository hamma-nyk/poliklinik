<x-app-layout title="Detail Surat Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('Detail Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">{{$letter->reg_number}}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('clinical.sick-leaves.index') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                    Kembali
                </a>
                @if($letter->type == 'internal')
                    <a href="{{ route('clinical.sick-leaves.print', $letter->id) }}" target="_blank" class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all hover:scale-105 active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                
                {{-- Header Status --}}
                <div class="bg-slate-50 dark:bg-slate-700/30 px-8 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <span class="text-[10px] text-slate-400 dark:text-slate-400 font-bold uppercase tracking-[0.2em]">Data Arsip Medis</span>
                    @if($letter->type == 'internal')
                        <span class="bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-[10px] font-bold px-3 py-1 rounded-lg border border-indigo-200 dark:border-indigo-800 uppercase tracking-wider">Internal Klinik</span>
                    @else
                        <span class="bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 text-[10px] font-bold px-3 py-1 rounded-lg border border-orange-200 dark:border-orange-800 uppercase tracking-wider">Eksternal (RS Luar)</span>
                    @endif
                </div>

                <div class="p-8 space-y-10">
                    
                    {{-- Section 1: Pasien --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Lengkap Pasien</label>
                            <p class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ $letter->patient->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">NIK / No. Karyawan</label>
                            <p class="text-xl font-bold text-slate-800 dark:text-slate-100 font-mono tracking-tight">{{ $letter->patient->nik }}</p>
                        </div>
                    </div>

                    <div class="h-px bg-slate-100 dark:bg-slate-700/50"></div>

                    {{-- Section 2: Detail Medis --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tenaga Medis / Dokter</label>
                            @if($letter->type == 'internal')
                                @if($letter->medicalRecord->doctor?->id)
                                <p class="font-bold text-indigo-600 dark:text-indigo-400 text-lg">dr. {{ $letter->medicalRecord->doctor->name ?? '-' }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-tight">SIP: {{ $letter->medicalRecord->doctor->sip ?? '-' }}</p>
                                @elseif($letter->medicalRecord->nurse?->id)
                                <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">dr. {{ $letter->medicalRecord->nurse->nama ?? '-' }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-tight">SIP: {{ $letter->medicalRecord->nurse->str ?? '-' }}</p>
                                @endif
                            @else
                                <p class="font-bold text-slate-800 dark:text-slate-100 text-lg">{{ $letter->external_doctor_name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-tight">{{ $letter->external_clinic_name }}</p>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Diagnosa Klinis</label>
                            <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-700">
                                <p class="text-slate-700 dark:text-slate-300 text-sm italic leading-relaxed">"{{ $letter->notes ?? 'Tidak ada catatan diagnosa.' }}"</p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Durasi Izin --}}
                    <div class="bg-indigo-50 dark:bg-slate-700 rounded-2xl p-6 border border-indigo-100 dark:border-slate-600 group transition-all duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <label class="block text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-widest">Masa Istirahat Sakit</label>
                        </div>
                        
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <p class="text-slate-800 dark:text-slate-200 text-sm leading-relaxed max-w-md">
                                Pasien diberikan izin istirahat selama <span class="font-bold text-indigo-600 dark:text-indigo-400 text-lg">{{ $letter->duration_days }} Hari</span> kalender.
                            </p>
                            <div class="text-right">
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase mb-1">Rentang Tanggal</div>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-200">
                                    {{ \Carbon\Carbon::parse($letter->start_date)->translatedFormat('d F Y') }} 
                                    <span class="mx-2 text-slate-300 dark:text-slate-600">s/d</span> 
                                    {{ \Carbon\Carbon::parse($letter->end_date)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Footer --}}
                    <div class="pt-4 flex items-center justify-center gap-2 text-slate-400 dark:text-slate-600">
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Document Secured by Internal Medical System</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>