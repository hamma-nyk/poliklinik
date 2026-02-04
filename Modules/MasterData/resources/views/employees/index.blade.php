<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Data Karyawan') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Manajemen Database Sumber Daya Manusia (HR)</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Karyawan</span>
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
                    <button @click="show = false" class="absolute right-4 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @elseif(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center p-4 mb-4 text-red-800 rounded-xl bg-red-50 border border-red-200 shadow-sm relative dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="absolute right-4 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- Action & Search Bar --}}
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
                
               <form method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3 items-center">
                    <div class="relative w-full sm:w-auto">
                        <select name="per_page" onchange="this.form.submit()" 
                                class="w-full sm:w-24 appearance-none rounded-xl border-slate-200 bg-slate-50 py-2.5 pl-3 pr-8 text-sm focus:border-blue-500 focus:bg-white focus:ring-blue-500 cursor-pointer font-medium text-slate-600 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 dark:focus:bg-slate-700">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500 dark:text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100 dark:focus:bg-slate-700">
                    </div>
                </form>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    @role('superadmin')
                    <form action="{{ route('master.employees.import') }}" method="POST" enctype="multipart/form-data" 
                          class="flex items-center gap-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl px-3 py-1.5 hover:border-slate-300 dark:hover:border-slate-500 transition-colors">
                        @csrf
                        <input type="file" name="csv_file" class="block w-full text-xs text-slate-500 dark:text-slate-400
                            file:mr-2 file:py-1 file:px-2
                            file:rounded-lg file:border-0
                            file:text-xs file:font-semibold
                            file:bg-slate-200 file:text-slate-700
                            dark:file:bg-slate-600 dark:file:text-slate-200
                            hover:file:bg-slate-300 dark:hover:file:bg-slate-500 cursor-pointer"/>
                        <button type="submit" class="bg-slate-800 dark:bg-blue-600 text-white p-1.5 rounded-lg hover:bg-slate-700 dark:hover:bg-blue-500 transition-colors" title="Upload CSV">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </button>
                    </form>
                    @endrole
                    <form action="{{ route('master.employees.sync') }}" method="POST" 
          onsubmit="document.getElementById('btn-sync-icon').classList.add('hidden'); document.getElementById('btn-sync-loading').classList.remove('hidden');">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-bold hover:bg-emerald-200 hover:text-emerald-800 transition-all shadow-sm" title="Tarik data terbaru dari HRIS Pusat">
            
            <svg id="btn-sync-icon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            
            <svg id="btn-sync-loading" class="animate-spin w-5 h-5 mr-2 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>

            Sync
        </button>
    </form>
<form action="{{ route('master.employees.trim') }}" method="POST" onsubmit="return confirm('Yakin ingin membersihkan spasi (TRIM) pada semua data karyawan? Proses ini aman dan tidak menghapus data.');">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-700 border border-orange-200 rounded-xl text-sm font-bold hover:bg-orange-200 hover:text-orange-800 transition-all shadow-sm" title="Bersihkan spasi berlebih di database">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                Trim
            </button>
        </form>
                    <a href="{{ route('master.employees.create') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:scale-105 transition-all duration-200 dark:shadow-blue-900/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Input Karyawan
                    </a>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Karyawan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Bagian</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sub Bagian</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ID System</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($employees as $emp)
                           
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 transition duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md dark:shadow-slate-900/40">
                                            {{ substr($emp->nama, 0, 1) }}{{ substr(strrchr($emp->nama, " "), 1, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $emp->nama }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $emp->position->name }}</div>
                                            <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">NIK: {{ $emp->nik }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $emp->department->name ?? 'N/A' }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $emp->subDepartment->name ?? 'N/A' }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($emp->is_status_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800/30">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:border-slate-600">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-2"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="font-mono text-xs text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded border border-slate-200 dark:border-slate-600">
                                        {{ $emp->code ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('master.employees.edit', $emp->id) }}" 
                                       class="text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 inline-block" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-full mb-3">
                                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-500 dark:text-slate-400 font-medium">Belum ada data karyawan</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Silakan input manual atau upload file CSV.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($employees->hasPages())
                <div class="bg-slate-50 dark:bg-slate-800/80 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $employees->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>