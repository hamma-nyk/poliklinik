<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Data Pasien') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Registrasi & Database Rekam Medis Pasien</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Pasien</span>
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
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID / Nama / NIK..." 
                               class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('master.patients.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Registrasi Pasien
                    </a>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Identitas Pasien</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">ID & Kategori</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Jenis Kelamin & Usia</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Kontak</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($patients as $patient)
                            <tr class="border-b border-neutral-100 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 group">
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium dark:border-neutral-600 dark:bg-neutral-800">
                                            {{ substr($patient->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4 grid gap-0.5">
                                            <div class="font-medium">{{ $patient->name }}</div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $patient->nik ? "NIK: ".$patient->nik : "KTP: ".$patient->ktp }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-medium font-mono">{{ $patient->code ?? '-' }}</div>
                                    <div class="mt-1">
                                        @if($patient->type == 'karyawan')
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-900 text-neutral-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-50 dark:text-neutral-900">
                                                Karyawan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md border border-transparent bg-neutral-100 text-neutral-900 px-2.5 py-0.5 text-xs font-semibold dark:bg-neutral-800 dark:text-neutral-50">
                                                Umum
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="text-sm font-medium">
                                        {{ $patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 flex items-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $patient->birth_date }} 
                                        @if(isset($patient->birth_date))
                                            <span class="text-neutral-400 dark:text-neutral-500 font-bold">({{ \Carbon\Carbon::parse($patient->birth_date)->age }} Thn)</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4 mr-2 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $patient->phone ?? '-' }}
                                    </div>
                                </td>

                                <td class="p-4 align-middle whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('master.patients.edit', $patient->id) }}" 
                                       class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-8 w-8 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-neutral-50 dark:bg-neutral-800 p-4 rounded-full mb-3 text-neutral-300 dark:text-neutral-500">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h3 class="text-neutral-500 dark:text-neutral-400 font-medium text-lg">Belum ada pasien terdaftar</h3>
                                        <p class="text-neutral-400 dark:text-neutral-500 text-sm mt-1">Lakukan registrasi untuk menambahkan database rekam medis.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($patients->hasPages())
                <div class="border-t border-neutral-200 dark:border-neutral-600 p-4">
                    {{ $patients->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
