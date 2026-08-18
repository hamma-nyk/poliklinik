<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Data Dokter') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Manajemen Tenaga Medis & Spesialis Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Dokter</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Success --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar: Search & Action --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
                
                <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    {{-- Per Page --}}
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="flex h-9 w-full sm:w-24 items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Dokter / SIP..." 
                               class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('master.doctors.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Dokter
                    </a>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Nama Dokter</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">SIP / STR</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Spesialisasi</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Status</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($doctors as $doc)
                            <tr class="border-b border-neutral-100 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <td class="p-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800">
                                            {{ substr($doc->name, 0, 1) }}
                                        </div>
                                        <div class="grid gap-0.5">
                                            <div class="font-medium">{{ $doc->name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400 font-mono">{{ $doc->code ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 align-middle">
                                    <div class="font-medium">{{ $doc->sip ?? '-' }}</div>
                                </td>

                                <td class="p-4 align-middle">
                                    <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-transparent bg-neutral-100 text-neutral-900 hover:bg-neutral-100/80 dark:bg-neutral-800 dark:text-neutral-50 dark:hover:bg-neutral-700/80">
                                        {{ $doc->specialization }}
                                    </div>
                                </td>

                                <td class="p-4 align-middle text-center">
                                    @if($doc->is_active)
                                        <div class="inline-flex items-center rounded-md border border-transparent bg-emerald-500/10 text-emerald-500 px-2.5 py-0.5 text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                            Active
                                        </div>
                                    @else
                                        <div class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-500 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-400">
                                            <span class="w-1.5 h-1.5 bg-neutral-400 rounded-full mr-1.5"></span>
                                            Cuti/Off
                                        </div>
                                    @endif
                                </td>

                                <td class="p-4 align-middle text-right">
                                    <a href="{{ route('master.doctors.edit', $doc->id) }}" 
                                       class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 w-8 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-sm text-neutral-500">
                                    Belum ada data dokter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($doctors->hasPages())
                <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                    {{ $doctors->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>