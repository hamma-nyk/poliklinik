<x-app-layout title="Riwayat Surat Dokter">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-800 dark:text-slate-100">
                    {{ __('Surat Keterangan Dokter') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Arsip digital surat keterangan sakit & izin medis</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Arsip SKD</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- Toolbar: Search, Filter & Action --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
                
                <form method="GET" action="{{ route('clinical.sick-leaves.index') }}" class="w-full flex flex-col md:flex-row gap-3 items-center flex-grow">
                    {{-- Row Count --}}
                    <div class="relative w-full sm:w-20">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Surat atau Nama Pasien..." 
                               class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                    </div>

                    {{-- Filter Jenis (Optional) --}}
                    <div class="relative w-full md:w-44">
                        <select name="type" onchange="this.form.submit()" 
                                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                            <option value="">Semua Jenis SKD</option>
                            <option value="internal" {{ request('type') == 'internal' ? 'selected' : '' }}>Internal (Klinik)</option>
                            <option value="external" {{ request('type') == 'external' ? 'selected' : '' }}>Eksternal (RS Luar)</option>
                        </select>
                    </div>
                </form>

                <div class="w-full md:w-auto shrink-0">
                    <a href="{{ route('clinical.sick-leaves.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Buat SKD Baru
                    </a>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">No. Surat / Tanggal</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Nama Pasien</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Jenis / Sumber</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Durasi Izin</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($letters as $letter)
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 group">
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="grid gap-0.5">
                                        <div class="font-medium text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ $letter->reg_number }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 text-base leading-none mb-1 group-hover:text-indigo-600 transition-colors">{{ $letter->patient->name }}</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono font-semibold tracking-widest uppercase italic">{{ $letter->patient->nik }}</div>
                                </td>
                                <td class="p-4 align-middle">
                                    @if($letter->type == 'internal')
                                        <span class="inline-flex items-center rounded-md border border-transparent bg-slate-100 text-slate-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-800 dark:text-slate-50">
                                            Internal (Klinik)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-slate-200 text-slate-950 dark:border-slate-800 dark:text-slate-50">
                                            Eksternal (RS Luar)
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $letter->duration_days }} Hari</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono italic leading-tight">
                                        {{ \Carbon\Carbon::parse($letter->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($letter->end_date)->format('d/m/y') }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('clinical.sick-leaves.show', $letter->id) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-8 px-3 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        @if($letter->type == 'internal')
                                            <a href="{{ route('clinical.sick-leaves.print', $letter->id) }}" target="_blank" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-8 px-3 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50" title="Cetak Surat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50">
                                <td colspan="5" class="p-4 align-middle text-center bg-white dark:bg-slate-950">
                                    <div class="flex flex-col items-center justify-center py-10">
                                        <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-full mb-4 text-slate-300 dark:text-slate-600 transition-colors border border-dashed dark:border-slate-800">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
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
                    <div class="border-t border-slate-200 dark:border-slate-800 p-4">
                        {{ $letters->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>