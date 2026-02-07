<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Cek Lab (POCT)') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pemeriksaan Gula Darah, Kolesterol & Asam Urat</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-purple-600 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Laboratorium</span>
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
                    {{-- Per Page --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="w-full sm:w-24 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-purple-500 focus:bg-white focus:ring-purple-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 dark:focus:bg-slate-700">
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
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pasien / Kode..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-purple-500 focus:ring-purple-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100 dark:focus:bg-slate-700">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('clinical.lab.create') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-purple-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:bg-purple-700 hover:scale-105 transition-all duration-200 w-full md:w-auto dark:shadow-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Input Cek Baru
                    </a>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Waktu & Kode</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Pasien</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Gula Darah</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Kolesterol</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Asam Urat</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Dokter</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Perawat</th>
                                <th class="px-6 py-4 text-right text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($checks as $chk)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900 dark:text-slate-100">{{ $chk->created_at->format('d M Y') }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-500 mb-1.5 font-medium">{{ $chk->created_at->format('H:i') }} WIB</div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600 uppercase">
                                        {{ $chk->code ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-purple-700 dark:text-purple-400 group-hover:text-purple-600 transition-colors">{{ $chk->patient->name }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 flex items-center">
                                        {{ $chk->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                        @if(isset($chk->patient->birth_date))
                                            <span class="mx-1.5 text-slate-300 dark:text-slate-600">|</span>
                                            <span class="font-bold">({{ \Carbon\Carbon::parse($chk->patient->birth_date)->age }} Thn)</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if($chk->patient->type == 'karyawan')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 border border-blue-200 dark:border-blue-800/50 uppercase tracking-tighter">KARYAWAN</span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-black bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600 uppercase tracking-tighter">UMUM</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($chk->gula_darah)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_gula == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->gula_darah }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-slate-300 dark:text-slate-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($chk->kolesterol)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_kolesterol == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->kolesterol }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-slate-300 dark:text-slate-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($chk->asam_urat)
                                        <div class="inline-flex flex-col items-center">
                                            <span class="px-3 py-1 rounded-xl text-xs font-black border {{ $chk->status_asam_urat == 'danger' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800/50' : 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800/50' }}">
                                                {{ $chk->asam_urat }}
                                            </span>
                                            <span class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">mg/dL</span>
                                        </div>
                                    @else
                                        <span class="text-slate-300 dark:text-slate-700 font-bold">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $name = $chk->doctor->name ?? '-';
                                        @endphp

                                        @if($chk->doctor == null)
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
                                            $name = $chk->nurse->nama ?? '-';
                                        @endphp

                                        @if($chk->nurse == null)
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
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('clinical.lab.print', $chk->id) }}" target="_blank" 
                                           class="inline-flex items-center px-3 py-2 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-all">
                                            <svg class="w-4 h-4 mr-1.5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak
                                        </a>

                                        <form action="{{ route('clinical.lab.destroy', $chk->id) }}" method="POST" onsubmit="return confirm('Hapus data cek lab ini?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 dark:bg-slate-700/50 p-6 rounded-full mb-4 text-slate-300 dark:text-slate-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-black text-lg uppercase tracking-widest">Belum ada data lab</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Lakukan pemeriksaan POCT untuk melihat riwayat di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($checks->hasPages())
                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $checks->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>