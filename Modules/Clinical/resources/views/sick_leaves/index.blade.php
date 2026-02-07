<x-app-layout title="Riwayat Surat Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ __('Surat Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Arsip digital surat keterangan sakit & izin medis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Arsip SKD</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center p-4 text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm relative dark:bg-slate-800 dark:text-emerald-400 dark:border-slate-700">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- Toolbar: Search, Filter & Action --}}
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                
                <form method="GET" action="{{ route('clinical.sick-leaves.index') }}" class="w-full flex flex-col md:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="w-full md:w-24 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-indigo-500 focus:ring-indigo-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 transition-all">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Surat atau Nama Pasien..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100 dark:placeholder-slate-400">
                    </div>

                    {{-- Filter Jenis (Optional) --}}
                    <div class="relative w-full md:w-auto">
                        <select name="type" onchange="this.form.submit()" 
                                class="w-full md:w-44 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-indigo-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 transition-all">
                            <option value="">Semua Jenis SKD</option>
                            <option value="internal" {{ request('type') == 'internal' ? 'selected' : '' }}>Internal (Klinik)</option>
                            <option value="external" {{ request('type') == 'external' ? 'selected' : '' }}>Eksternal (RS Luar)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </form>

                <div class="w-full md:w-auto shrink-0">
                    <a href="{{ route('clinical.sick-leaves.create') }}" class="inline-flex justify-center items-center w-full px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all duration-200 uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Buat SKD Baru
                    </a>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-[2rem] border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-700/30 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700">
                                <th class="px-8 py-5">No. Surat / Tanggal</th>
                                <th class="px-6 py-5">Nama Pasien</th>
                                <th class="px-6 py-5">Jenis / Sumber</th>
                                <th class="px-6 py-5">Durasi Izin</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150 group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ $letter->reg_number }}</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono italic">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 text-base leading-none mb-1 group-hover:text-indigo-600 transition-colors">{{ $letter->patient->name }}</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono font-semibold tracking-widest uppercase italic">{{ $letter->patient->nik }}</div>
                                </td>
                                <td class="px-6 py-6">
                                    @if($letter->type == 'internal')
                                        <span class="inline-flex items-center px-3 py-1 bg-indigo-50 dark:bg-slate-700 text-indigo-700 dark:text-indigo-300 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-indigo-100 dark:border-slate-600">
                                            Internal (Klinik)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 bg-orange-50 dark:bg-slate-700 text-orange-700 dark:text-orange-300 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-orange-100 dark:border-slate-600">
                                            Eksternal (RS Luar)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6">
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $letter->duration_days }} Hari</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono italic leading-tight">
                                        {{ \Carbon\Carbon::parse($letter->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($letter->end_date)->format('d/m/y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('clinical.sick-leaves.show', $letter->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl transition-all shadow-sm active:scale-95" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        @if($letter->type == 'internal')
                                            <a href="{{ route('clinical.sick-leaves.print', $letter->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl transition-all shadow-sm active:scale-95" title="Cetak Surat">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center bg-white dark:bg-slate-800">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-6 bg-slate-50 dark:bg-slate-700 rounded-full mb-4 text-slate-300 dark:text-slate-600 transition-colors border border-dashed dark:border-slate-600">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-bold text-lg uppercase tracking-tight">Data tidak ditemukan</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1 max-w-xs mx-auto italic leading-relaxed text-center">Coba gunakan kata kunci lain atau ubah filter untuk mencari arsip surat keterangan sakit.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Links --}}
                @if($letters->hasPages())
                    <div class="p-8 border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-700/30 transition-colors duration-300">
                        {{ $letters->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>