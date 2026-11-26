<x-app-layout title="Data MCU">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">
                    {{ __('Data MCU') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Manajemen Tipe MCU & Mapping Diagnosa Penyakit</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span>Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Data MCU</span>
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

        {{-- Toolbar: Search & Action --}}
        <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                <div class="relative w-full sm:w-auto">
                    <select name="per_page" onchange="this.form.submit()"
                            class="flex h-9 w-full sm:w-20 items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>

                <div class="relative w-full sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Tipe MCU / Diagnosa..."
                           class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                </div>
            </form>

            <div class="w-full md:w-auto">
                <a href="{{ route('master.mcu-types.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Tipe MCU
                </a>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                        <tr class="border-b border-neutral-200 dark:border-neutral-600">
                            <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Tipe / Bagian MCU</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Pemeriksaan Dianjurkan</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Diagnosa Ter-mapping</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        @forelse($mcuTypes as $mcu)
                        <tr class="border-b border-neutral-200 transition-colors dark:border-neutral-600">
                            <td class="p-4 align-top font-semibold whitespace-nowrap">
                                <div>{{ $mcu->name }}</div>
                                <div class="text-xs font-normal text-neutral-500 dark:text-neutral-400 mt-1">{{ $mcu->diagnoses_count }} diagnosa</div>
                            </td>
                            <td class="p-4 align-top text-xs text-neutral-600 dark:text-neutral-300 max-w-xs">
                                {{ $mcu->recommended_exams ?: '-' }}
                            </td>
                            <td class="p-4 align-top">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($mcu->diagnoses->take(8) as $diag)
                                        <span class="inline-flex items-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-700/60 px-2 py-0.5 text-xs">
                                            {{ $diag->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-neutral-400 italic">Belum ada diagnosa</span>
                                    @endforelse
                                    @if($mcu->diagnoses_count > 8)
                                        <span class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-neutral-700 px-2 py-0.5 text-xs font-medium text-neutral-600 dark:text-neutral-300">
                                            +{{ $mcu->diagnoses_count - 8 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 align-top text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('master.mcu-types.edit', $mcu->id) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-neutral-200 bg-white px-3 py-1.5 hover:bg-neutral-100 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700">Edit</a>
                                <form action="{{ route('master.mcu-types.destroy', $mcu->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tipe MCU ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-red-200 text-red-600 bg-white px-3 py-1.5 hover:bg-red-50 dark:border-red-800 dark:bg-neutral-800 dark:text-red-400 dark:hover:bg-red-950/50">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-neutral-500 dark:text-neutral-400">Belum ada data tipe MCU.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mcuTypes->hasPages())
            <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                {{ $mcuTypes->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
