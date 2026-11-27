<x-app-layout title="Filter MCU">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">
                    {{ __('Filter MCU') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Bandingkan 2 file Excel untuk menyaring peserta yang sudah mengikuti MCU</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span>Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Filter MCU</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 flex items-center">
                <svg class="w-4 h-4 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-600 hover:text-emerald-900 dark:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 shadow-sm relative dark:border-red-800 dark:bg-red-950 dark:text-red-200 flex items-center">
                <svg class="w-4 h-4 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto text-red-600 hover:text-red-900 dark:text-red-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950/60 dark:text-red-200">
                <ul class="list-disc ml-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload Form --}}
        <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 sm:p-6">
            <form action="{{ route('master.mcu-filter.process') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-600 bg-neutral-50/60 dark:bg-neutral-900/40 p-4 space-y-2">
                        <label class="block text-sm font-semibold">Excel 1 — Master Data Peserta <span class="text-red-500">*</span></label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload file master data (misal: <span class="font-mono">master data.xlsx</span>) yang memiliki kolom <strong>NIK</strong> atau <strong>Nama</strong>.</p>
                        <input type="file" name="master_file" accept=".xlsx,.xls,.csv" required
                               class="block w-full text-sm text-neutral-600 dark:text-neutral-300 rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 p-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-neutral-50 dark:file:bg-neutral-50 dark:file:text-neutral-900 hover:file:opacity-90 cursor-pointer">
                    </div>

                    <div class="rounded-xl border border-neutral-200 dark:border-neutral-600 bg-neutral-50/60 dark:bg-neutral-900/40 p-4 space-y-2">
                        <label class="block text-sm font-semibold">Excel 2 — List Sudah MCU <span class="text-red-500">*</span></label>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload file daftar yang sudah MCU (misal: <span class="font-mono">sudah mcu.xlsx</span>). Jika <strong>NIK atau Nama</strong> cocok, peserta akan dikeluarkan.</p>
                        <input type="file" name="mcu_file" accept=".xlsx,.xls,.csv" required
                               class="block w-full text-sm text-neutral-600 dark:text-neutral-300 rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 p-1.5 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-neutral-50 dark:file:bg-neutral-50 dark:file:text-neutral-900 hover:file:opacity-90 cursor-pointer">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2">
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">
                        Format didukung: <span class="font-mono">.xlsx</span>, <span class="font-mono">.xls</span>, <span class="font-mono">.csv</span>. Pencocokan otomatis mengabaikan perbedaan huruf besar/kecil dan spasi berlebih.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @if($result)
                            <a href="{{ route('master.mcu-filter.export') }}"
                               class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 h-9 px-4 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                Export Excel (Boleh Ikut MCU)
                            </a>
                        @endif
                        <button type="submit"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-5 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Proses Filter MCU
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($result)
            {{-- Ringkasan Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-600 dark:bg-neutral-800 p-4 shadow">
                    <div class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Total Master Data</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($result['master_count']) }}</div>
                    <div class="text-xs text-neutral-400 truncate mt-0.5">{{ $result['master_filename'] }}</div>
                </div>
                <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-600 dark:bg-neutral-800 p-4 shadow">
                    <div class="text-xs font-medium text-neutral-500 dark:text-neutral-400">List Sudah MCU</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($result['mcu_count']) }}</div>
                    <div class="text-xs text-neutral-400 truncate mt-0.5">{{ $result['mcu_filename'] }}</div>
                </div>
                <div class="rounded-xl border border-emerald-200 bg-emerald-50/70 dark:border-emerald-800/60 dark:bg-emerald-950/40 p-4 shadow">
                    <div class="text-xs font-medium text-emerald-700 dark:text-emerald-300">Boleh Ikut MCU</div>
                    <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 mt-1">{{ number_format($result['eligible_count']) }}</div>
                    <div class="text-xs text-emerald-600/80 dark:text-emerald-400/80 mt-0.5">Peserta belum MCU</div>
                </div>
                <div class="rounded-xl border border-rose-200 bg-rose-50/70 dark:border-rose-800/60 dark:bg-rose-950/40 p-4 shadow">
                    <div class="text-xs font-medium text-rose-700 dark:text-rose-300">Dikeluarkan (Sudah MCU)</div>
                    <div class="text-2xl font-bold text-rose-700 dark:text-rose-300 mt-1">{{ number_format($result['excluded_count']) }}</div>
                    <div class="text-xs text-rose-600/80 dark:text-rose-400/80 mt-0.5">Tidak boleh ikut lagi</div>
                </div>
            </div>

            {{-- Tabel Hasil dengan Tab --}}
            <div x-data="{ tab: 'eligible' }" class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="p-4 border-b border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="tab = 'eligible'"
                                :class="tab === 'eligible' ? 'bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900' : 'border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700'"
                                class="inline-flex items-center rounded-md px-3.5 h-9 text-xs font-semibold transition-colors">
                            Boleh Ikut MCU ({{ $result['eligible_count'] }})
                        </button>
                        <button type="button" @click="tab = 'excluded'"
                                :class="tab === 'excluded' ? 'bg-rose-600 text-white' : 'border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700'"
                                class="inline-flex items-center rounded-md px-3.5 h-9 text-xs font-semibold transition-colors">
                            Dikeluarkan / Sudah MCU ({{ $result['excluded_count'] }})
                        </button>
                    </div>

                    <a href="{{ route('master.mcu-filter.export') }}"
                       class="inline-flex items-center justify-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 h-9 text-xs font-medium hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Download Excel Hasil Filter
                    </a>
                </div>

                {{-- Tab 1: Boleh Ikut MCU --}}
                <div x-show="tab === 'eligible'" class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead>
                            <tr>
                                <th class="h-11 px-4 text-left align-middle w-12">No</th>
                                @foreach($result['headers'] as $header)
                                    <th class="h-11 px-4 text-left align-middle whitespace-nowrap">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result['eligible_rows'] as $idx => $row)
                            <tr>
                                <td class="p-3.5 align-middle text-neutral-500 dark:text-neutral-400">{{ $idx + 1 }}</td>
                                @foreach($row as $cell)
                                    <td class="p-3.5 align-middle whitespace-nowrap">{{ $cell !== '' ? $cell : '-' }}</td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($result['headers']) + 1 }}" class="p-8 text-center text-neutral-500 dark:text-neutral-400">
                                    Semua peserta di Master Data sudah pernah MCU.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tab 2: Dikeluarkan --}}
                <div x-show="tab === 'excluded'" x-cloak class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead>
                            <tr>
                                <th class="h-11 px-4 text-left align-middle w-12">No</th>
                                <th class="h-11 px-4 text-left align-middle whitespace-nowrap">Alasan Dikeluarkan</th>
                                @foreach($result['headers'] as $header)
                                    <th class="h-11 px-4 text-left align-middle whitespace-nowrap">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result['excluded_rows'] as $idx => $item)
                            <tr>
                                <td class="p-3.5 align-middle text-neutral-500 dark:text-neutral-400">{{ $idx + 1 }}</td>
                                <td class="p-3.5 align-middle whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800/50 px-2.5 py-0.5 text-xs font-semibold">
                                        {{ $item['reason'] }}
                                    </span>
                                </td>
                                @foreach($item['data'] as $cell)
                                    <td class="p-3.5 align-middle whitespace-nowrap">{{ $cell !== '' ? $cell : '-' }}</td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($result['headers']) + 2 }}" class="p-8 text-center text-neutral-500 dark:text-neutral-400">
                                    Tidak ada peserta yang cocok dengan daftar Sudah MCU.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
