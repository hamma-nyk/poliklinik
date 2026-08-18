<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Cek Lab (POCT)') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Pemeriksaan Gula Darah, Kolesterol & Asam Urat</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Laboratorium</span>
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
                    {{-- Per Page --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full sm:w-20 items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
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
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pasien / Kode..." 
                               class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('clinical.lab.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Input Cek Baru
                    </a>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm divide-y divide-neutral-100 dark:divide-neutral-700">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Waktu & Kode</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Pasien</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Gula Darah</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Kolesterol</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Asam Urat</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Dokter</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Perawat</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-widest text-[11px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0 divide-y divide-neutral-100 dark:divide-neutral-700">
                            @forelse($checks as $chk)
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 group">
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-bold text-neutral-900 dark:text-neutral-100">{{ $chk->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-neutral-500 dark:text-neutral-500 mb-1.5 font-medium">{{ $chk->created_at->format('H:i') }} WIB</div>
                                    <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-50 uppercase font-mono">
                                        {{ $chk->code ?? '-' }}
                                    </span>
                                </td>

                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-bold text-purple-700 dark:text-purple-400 group-hover:text-purple-600 transition-colors">{{ $chk->patient->name }}</div>
                                    <div class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-1 flex items-center">
                                        {{ $chk->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                        @if(isset($chk->patient->birth_date))
                                            <span class="mx-1.5 text-neutral-300 dark:text-neutral-600">|</span>
                                            <span class="font-bold">({{ \Carbon\Carbon::parse($chk->patient->birth_date)->age }} Thn)</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if($chk->patient->type == 'karyawan')
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-900 text-neutral-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-50 dark:text-neutral-900 uppercase tracking-tighter">KARYAWAN</span>
                                        @else
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-50 uppercase tracking-tighter">UMUM</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    @if($chk->gula_darah)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_gula == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->gula_darah }}
                                            </span>
                                            <span class="text-[9px] font-bold text-neutral-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-neutral-300 dark:text-neutral-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    @if($chk->kolesterol)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_kolesterol == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->kolesterol }}
                                            </span>
                                            <span class="text-[9px] font-bold text-neutral-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-neutral-300 dark:text-neutral-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    @if($chk->asam_urat)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_asam_urat == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->asam_urat }}
                                            </span>
                                            <span class="text-[9px] font-bold text-neutral-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-neutral-300 dark:text-neutral-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $chk->doctor->name ?? '-';
                                        @endphp

                                        @if($chk->doctor == null)
                                            <span class="text-sm text-neutral-400 dark:text-neutral-500 italic">-</span>
                                        @else
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800 mr-3 text-neutral-700 dark:text-neutral-300">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div class="grid gap-0.5">
                                            <div class="font-medium text-neutral-900 dark:text-neutral-200">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest font-bold">
                                                Dokter
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $chk->nurse->nama ?? '-';
                                        @endphp

                                        @if($chk->nurse == null)
                                            <span class="text-sm text-neutral-400 dark:text-neutral-500 italic">-</span>
                                        @else
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800 mr-3 text-neutral-700 dark:text-neutral-300">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <div class="grid gap-0.5">
                                            <div class="font-medium text-neutral-900 dark:text-neutral-200">{{ $name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest font-bold">
                                                Perawat
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('clinical.lab.print', $chk->id) }}" target="_blank" 
                                           class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                                            <svg class="w-4 h-4 mr-1.5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak
                                        </a>

                                        <form action="{{ route('clinical.lab.destroy', $chk->id) }}" method="POST" onsubmit="return confirm('Hapus data cek lab ini?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-neutral-400 dark:text-neutral-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-4 align-middle py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-neutral-50 dark:bg-neutral-700/50 p-6 rounded-full mb-4 text-neutral-300 dark:text-neutral-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-black text-lg uppercase tracking-widest">Belum ada data lab</h3>
                                        <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1">Lakukan pemeriksaan POCT untuk melihat riwayat di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($checks->hasPages())
                <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                    {{ $checks->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>