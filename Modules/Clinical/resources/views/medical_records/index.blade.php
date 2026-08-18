<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 leading-tight dark:text-neutral-100">
                    {{ __('Rekam Medis') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Riwayat Pemeriksaan & Diagnosa Pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Medical Record</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Search & Action --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                
                <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-20">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No RM / Pasien / Diagnosa..." 
                               class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('clinical.records.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Input Pemeriksaan
                    </a>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Waktu & No. RM</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Pasien</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa (ICD-10)</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Dokter</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Perawat</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($records as $rm)
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                {{-- Kolom 1 --}}
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-bold text-neutral-900 dark:text-neutral-100 uppercase">
                                        {{ $rm->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-1.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $rm->created_at->format('H:i') }} WIB
                                    </div>
                                    <span class="inline-flex items-center rounded-md border border-neutral-200 bg-neutral-50 text-neutral-950 px-2.5 py-0.5 text-xs font-semibold dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50">
                                        {{ $rm->code }}
                                    </span>
                                </td>

                                {{-- Kolom 2 --}}
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-bold text-neutral-900 dark:text-neutral-100">{{ $rm->patient->name }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        {{ $rm->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                        @if(isset($rm->patient->birth_date))
                                            <span>({{ \Carbon\Carbon::parse($rm->patient->birth_date)->age }} Thn)</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if($rm->patient->type == 'karyawan')
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-50 uppercase">KARYAWAN</span>
                                        @else
                                            <span class="inline-flex items-center rounded-md border border-neutral-200 px-2.5 py-0.5 text-xs font-semibold text-neutral-950 dark:border-neutral-600 dark:text-neutral-50 uppercase">UMUM</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 3: Diagnosa --}}
                                <td class="p-4 align-middle">
                                    @if($rm->diagnosis)
                                        <div class="text-sm font-bold text-neutral-900 dark:text-neutral-100">{{ $rm->diagnosis->name }}</div>
                                        <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-neutral-200 text-neutral-950 dark:border-neutral-600 dark:text-neutral-50 mt-1">
                                            {{ $rm->diagnosis->code ?? '-' }}
                                        </div>
                                    @else
                                        <span class="text-sm text-neutral-400 dark:text-neutral-500 italic">Belum ada diagnosa</span>
                                    @endif
                                    
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 truncate max-w-xs flex items-center italic" title="{{ $rm->keluhan_utama }}">
                                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                        "{{ Str::limit($rm->keluhan_utama, 35) }}"
                                    </div>
                                </td>

                                {{-- Kolom 4: Dokter --}}
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $rm->doctor->name ?? '-';
                                        @endphp

                                        @if($rm->doctor == null)
                                            <span class="text-sm text-neutral-400 dark:text-neutral-500 italic">-</span>
                                        @else
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800 mr-3">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div class="grid gap-0.5">
                                            <div class="font-medium">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase">
                                                Dokter
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $rm->nurse->nama ?? '-';
                                        @endphp

                                        @if($rm->nurse == null)
                                            <span class="text-sm text-neutral-400 dark:text-neutral-500 italic">-</span>
                                        @else
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800 mr-3">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div class="grid gap-0.5">
                                            <div class="font-medium">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase">
                                                Perawat
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 5: Aksi --}}
                                <td class="p-4 align-middle whitespace-nowrap">
    <div class="flex items-center justify-center gap-2">
        {{-- Button Detail: Boxed dengan Icon & Text --}}
        <a href="{{ route('clinical.records.show', $rm->id) }}" 
           class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
            
            <svg class="w-4 h-4" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </a>
        
        {{-- Button Cetak: Icon Only dengan Slate elevation --}}
        <a href="{{ route('clinical.records.print', $rm->id) }}" target="_blank" 
           class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" 
           title="Cetak PDF">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
        </a>
        <a href="{{ route('clinical.records.send_wa', $rm->id) }}" 
   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 px-3 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" 
   title="Kirim WA">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
    </svg>
</a>
    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-4 align-middle text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <div class="text-neutral-400 mb-4">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-medium">Belum ada rekam medis</h3>
                                        <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1">Klik tombol "Input Pemeriksaan" untuk mencatat diagnosa pasien baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($records->hasPages())
                <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                    {{ $records->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>