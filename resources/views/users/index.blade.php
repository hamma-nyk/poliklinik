<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100 tracking-tight">
                    {{ __('Manajemen Pengguna') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Otoritas Akun & Konfigurasi Hak Akses Sistem</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Sistem</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Users</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert Section --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center p-4 mb-4 text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm relative dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/30">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute right-4 text-emerald-600 hover:text-emerald-900 dark:text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- Toolbar --}}
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <form method="GET" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 items-center flex-grow">
                    <div class="relative group w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / Email..." 
                               class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 text-sm py-2.5 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-100 dark:placeholder-slate-500">
                    </div>
                </form>

                <div class="w-full md:w-auto">
                    <a href="{{ route('users.create') }}" class="inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all duration-200 w-full md:w-auto uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Tambah User
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-[2rem] border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-700/50 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700">
                                <th class="px-6 py-5 text-left">Profil Pengguna</th>
                                <th class="px-6 py-5 text-center">USERNAME</th>
                                <th class="px-6 py-5 text-left">Otoritas / Hak Akses</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition duration-150 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold text-sm shadow-sm transition-colors group-hover:border-indigo-300">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 flex items-center font-mono">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800 tracking-tight">
                                            {{ $user->username }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($user->permissions as $perm)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800 uppercase tracking-tight">
                                                {{ str_replace('_', ' ', $perm->name) }}
                                            </span>
                                        @empty
                                            @if($user->hasRole('superadmin'))
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-100 dark:border-amber-800 uppercase tracking-tight">
                                                    Super Administrator
                                                </span>
                                            @else
                                                <span class="text-xs text-slate-400 dark:text-slate-500 italic">Akses Terbatas</span>
                                            @endif
                                        @endforelse
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <div class="flex justify-center items-center gap-2">
        
        {{-- CASE 1: Jika User yang di-loop adalah Superadmin --}}
        @if($user->hasRole('superadmin'))
            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold bg-slate-50 dark:bg-slate-800 text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-widest">
                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                System Root
            </span>

        {{-- CASE 2: Jika User biasa, cek apakah yang sedang login adalah Superadmin --}}
        @elseif(auth()->user()->hasRole('superadmin'))
            {{-- Tombol Edit --}}
            <a href="{{ route('users.edit', $user) }}" 
               class="p-2 text-slate-400 hover:text-indigo-600 dark:text-slate-500 dark:hover:text-indigo-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all shadow-sm active:scale-95 group" 
               title="Edit User">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>
            
            {{-- Tombol Hapus --}}
            <form action="{{ route('users.destroy', $user) }}" method="POST" 
                  onsubmit="return confirm('PERINGATAN: Menghapus user ini akan mencabut seluruh akses sistem. Lanjutkan?');" 
                  class="inline">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="p-2 text-slate-400 hover:text-rose-600 dark:text-slate-500 dark:hover:text-rose-400 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl transition-all shadow-sm active:scale-95 group" 
                        title="Hapus User">
                    <svg class="w-5 h-5 group-hover:shake" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>

        {{-- CASE 3: Jika User login bukan Superadmin dan sedang melihat user lain --}}
        @else
            <span class="text-[10px] text-slate-400 italic">No Access</span>
        @endif

    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500 font-medium">
                                    Belum ada pengguna tambahan dalam sistem.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>