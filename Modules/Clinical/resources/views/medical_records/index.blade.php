<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Rekam Medis') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Riwayat Pemeriksaan & Diagnosa Pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Medical Record</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center p-4 mb-4 text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm relative dark:bg-green-900/20 dark:text-green-400 dark:border-green-800/30">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Search & Action --}}
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
                
                <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="w-full sm:w-24 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 dark:focus:bg-slate-700">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500 dark:text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No RM / Pasien / Diagnosa..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100 dark:focus:bg-slate-700">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('clinical.records.create') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:scale-105 transition-all duration-200 w-full md:w-auto dark:shadow-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Input Pemeriksaan
                    </a>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50 uppercase tracking-wider text-[11px] font-black text-slate-500 dark:text-slate-400">
                                <th class="px-6 py-4 text-left">Waktu & No. RM</th>
                                <th class="px-6 py-4 text-left">Pasien</th>
                                <th class="px-6 py-4 text-left">Diagnosa (ICD-10)</th>
                                <th class="px-6 py-4 text-left">Dokter</th>
                                <th class="px-6 py-4 text-left">Perawat</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($records as $rm)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150 group">
                                {{-- Kolom 1 --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900 dark:text-slate-100">
                                        {{ $rm->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-500 mb-1.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $rm->created_at->format('H:i') }} WIB
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600">
                                        {{ $rm->code }}
                                    </span>
                                </td>

                                {{-- Kolom 2 --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-blue-700 dark:text-blue-400 group-hover:text-blue-600 transition-colors">{{ $rm->patient->name }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $rm->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                        @if(isset($rm->patient->birth_date))
                                            <span class="text-slate-400 dark:text-slate-500 font-bold">({{ \Carbon\Carbon::parse($rm->patient->birth_date)->age }} Thn)</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if($rm->patient->type == 'karyawan')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800/50 uppercase">KARYAWAN</span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600 uppercase">UMUM</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 3: Diagnosa --}}
                                <td class="px-6 py-4">
                                    @if($rm->diagnosis)
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $rm->diagnosis->name }}</div>
                                        <div class="text-[11px] font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded inline-block mt-1 border border-slate-200 dark:border-slate-600">
                                            {{ $rm->diagnosis->code ?? '-' }}
                                        </div>
                                    @else
                                        <span class="text-sm text-slate-400 dark:text-slate-500 italic">Belum ada diagnosa</span>
                                    @endif
                                    
                                    <div class="text-[11px] text-slate-500 dark:text-slate-500 mt-2 truncate max-w-xs flex items-center italic" title="{{ $rm->keluhan_utama }}">
                                        <svg class="w-3 h-3 mr-1 text-slate-400 dark:text-slate-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                        "{{ Str::limit($rm->keluhan_utama, 35) }}"
                                    </div>
                                </td>

                                {{-- Kolom 4: Dokter --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $rm->doctor->name ?? '-';
                                        @endphp

                                        @if($rm->doctor == null)
                                            <span class="text-sm text-slate-400 dark:text-slate-500 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-xl bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-700 flex items-center justify-center text-xs font-black mr-3 shadow-sm">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900 dark:text-slate-200">{{ $name }}</div>
                                            <div class="text-[10px] text-blue-500 uppercase tracking-widest font-bold">
                                                Dokter
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $rm->nurse->nama ?? '-';
                                        @endphp

                                        @if($rm->nurse == null)
                                            <span class="text-sm text-slate-400 dark:text-slate-500 italic">-</span>
                                        @else
                                        <div class="h-9 w-9 rounded-xl bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 border border-pink-200 dark:border-pink-700 flex items-center justify-center text-xs font-black mr-3 shadow-sm">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900 dark:text-slate-200">{{ $name }}</div>
                                            <div class="text-[10px] text-pink-500 uppercase tracking-widest font-bold">
                                                Perawat
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 5: Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('clinical.records.show', $rm->id) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all">
                                            Detail
                                        </a>
                                        
                                        <a href="{{ route('clinical.records.print', $rm->id) }}" target="_blank" 
                                           class="p-2 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" title="Cetak PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 dark:bg-slate-700/50 p-6 rounded-full mb-4 text-slate-300 dark:text-slate-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold text-lg">Belum ada rekam medis</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1 max-w-xs mx-auto">Klik tombol "Input Pemeriksaan" untuk mencatat diagnosa pasien baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($records->hasPages())
                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $records->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>